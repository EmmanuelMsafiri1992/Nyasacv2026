<?php

namespace App\Services;

use App\Models\AiIndustry;
use App\Models\AiJobTitle;
use App\Models\AiSummaryTemplate;
use App\Models\AiAchievementTemplate;
use App\Models\AiSkill;
use App\Models\AiActionVerb;
use App\Models\AiPhrase;
use App\Models\AiCoverLetterTemplate;
use App\Models\AiGenerationLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ResumeAiService
{
    /**
     * Generate a professional summary based on user input
     */
    public function generateSummary(array $input): array
    {
        $jobTitle = $input['job_title'] ?? 'Professional';
        $industry = $input['industry'] ?? null;
        $yearsExperience = $input['years_experience'] ?? 5;
        $skills = $input['skills'] ?? [];
        $tone = $input['tone'] ?? 'professional';
        $count = $input['count'] ?? 3;

        // Determine experience level
        $level = $this->determineExperienceLevel($yearsExperience);

        // Find matching templates
        $templates = $this->findSummaryTemplates($industry, $jobTitle, $level, $tone);

        // Generate variations
        $summaries = [];
        $usedTemplates = [];

        foreach ($templates->take($count * 2) as $template) {
            if (count($summaries) >= $count) break;

            $generated = $this->processSummaryTemplate($template->template, [
                'job_title' => $jobTitle,
                'years' => $yearsExperience,
                'industry' => $industry ?? $this->inferIndustry($jobTitle),
                'skills' => $skills,
                'level' => $level,
            ]);

            // Avoid duplicates
            $hash = md5($generated);
            if (!in_array($hash, $usedTemplates)) {
                $usedTemplates[] = $hash;
                $summaries[] = [
                    'text' => $generated,
                    'tone' => $template->tone,
                    'word_count' => str_word_count($generated),
                ];
            }
        }

        // If we don't have enough, generate with phrase combinations
        while (count($summaries) < $count) {
            $generated = $this->generateSummaryFromPhrases($jobTitle, $yearsExperience, $skills, $level, $tone);
            $hash = md5($generated);
            if (!in_array($hash, $usedTemplates)) {
                $usedTemplates[] = $hash;
                $summaries[] = [
                    'text' => $generated,
                    'tone' => $tone,
                    'word_count' => str_word_count($generated),
                ];
            }
        }

        return $summaries;
    }

    /**
     * Generate achievement bullet points
     */
    public function generateBulletPoints(array $input): array
    {
        $jobTitle = $input['job_title'] ?? 'Professional';
        $category = $input['category'] ?? 'general';
        $context = $input['context'] ?? [];
        $count = $input['count'] ?? 5;
        $includeMetrics = $input['include_metrics'] ?? true;

        $templates = $this->findAchievementTemplates($jobTitle, $category);
        $actionVerbs = $this->getActionVerbs($category);

        $bullets = [];
        $usedTemplates = [];

        foreach ($templates->shuffle()->take($count * 2) as $template) {
            if (count($bullets) >= $count) break;

            $verb = $actionVerbs->random();
            $generated = $this->processAchievementTemplate($template->template, [
                'verb' => $verb->verb,
                'context' => $context,
                'include_metrics' => $includeMetrics,
            ]);

            $hash = md5($generated);
            if (!in_array($hash, $usedTemplates)) {
                $usedTemplates[] = $hash;
                $bullets[] = [
                    'text' => $generated,
                    'category' => $template->category,
                    'impact_type' => $template->impact_type,
                    'action_verb' => $verb->verb,
                ];
            }
        }

        // Generate additional bullets if needed
        while (count($bullets) < $count) {
            $verb = $actionVerbs->random();
            $generated = $this->generateGenericBullet($verb->verb, $jobTitle, $includeMetrics);
            $hash = md5($generated);
            if (!in_array($hash, $usedTemplates)) {
                $usedTemplates[] = $hash;
                $bullets[] = [
                    'text' => $generated,
                    'category' => 'general',
                    'impact_type' => $includeMetrics ? 'quantitative' : 'qualitative',
                    'action_verb' => $verb->verb,
                ];
            }
        }

        return $bullets;
    }

    /**
     * Suggest skills based on job title
     */
    public function suggestSkills(array $input): array
    {
        $jobTitle = $input['job_title'] ?? '';
        $industry = $input['industry'] ?? null;
        $existingSkills = $input['existing_skills'] ?? [];
        $count = $input['count'] ?? 10;

        // Find job title in database
        $jobTitleModel = AiJobTitle::active()
            ->search($jobTitle)
            ->first();

        $skills = collect();

        // Get skills for this job title
        if ($jobTitleModel) {
            $skills = AiSkill::active()
                ->forJobTitle($jobTitleModel->id)
                ->ordered()
                ->get();
        }

        // Add industry-specific skills
        if ($industry) {
            $industryModel = AiIndustry::where('slug', Str::slug($industry))
                ->orWhere('name', 'like', "%{$industry}%")
                ->first();

            if ($industryModel) {
                $industrySkills = AiSkill::active()
                    ->where('industry_id', $industryModel->id)
                    ->ordered()
                    ->get();
                $skills = $skills->merge($industrySkills);
            }
        }

        // Add general popular skills
        $popularSkills = AiSkill::active()
            ->popular(60)
            ->whereNull('industry_id')
            ->ordered()
            ->get();
        $skills = $skills->merge($popularSkills);

        // Filter out existing skills
        $existingLower = array_map('strtolower', $existingSkills);
        $skills = $skills->filter(function ($skill) use ($existingLower) {
            return !in_array(strtolower($skill->name), $existingLower);
        });

        // Remove duplicates and limit
        $skills = $skills->unique('name')->take($count);

        return $skills->map(function ($skill) {
            return [
                'name' => $skill->name,
                'category' => $skill->category,
                'popularity' => $skill->popularity,
            ];
        })->values()->toArray();
    }

    /**
     * Enhance a weak bullet point
     */
    public function enhanceBulletPoint(array $input): array
    {
        $original = $input['text'] ?? '';
        $jobTitle = $input['job_title'] ?? '';
        $addMetrics = $input['add_metrics'] ?? true;

        if (empty($original)) {
            return ['error' => 'No text provided'];
        }

        $enhancements = [];

        // Analyze the original
        $analysis = $this->analyzeBulletPoint($original);

        // Enhancement 1: Add stronger action verb
        $strongVerbs = AiActionVerb::active()
            ->byCategory($analysis['likely_category'])
            ->strong(7)
            ->get();

        if ($strongVerbs->isNotEmpty()) {
            $verb = $strongVerbs->random();
            $enhanced = $this->replaceFirstWord($original, $verb->verb);
            $enhancements[] = [
                'text' => $enhanced,
                'improvement' => 'Stronger action verb',
                'original_verb' => $analysis['first_word'],
                'new_verb' => $verb->verb,
            ];
        }

        // Enhancement 2: Add metrics placeholder
        if ($addMetrics && !$analysis['has_numbers']) {
            $withMetrics = $this->addMetricsToText($original);
            $enhancements[] = [
                'text' => $withMetrics,
                'improvement' => 'Added quantifiable metrics',
            ];
        }

        // Enhancement 3: Make more specific
        $moreSpecific = $this->makeMoreSpecific($original, $jobTitle);
        if ($moreSpecific !== $original) {
            $enhancements[] = [
                'text' => $moreSpecific,
                'improvement' => 'More specific and impactful',
            ];
        }

        // Enhancement 4: Combine improvements
        if (count($enhancements) >= 2) {
            $combined = $original;
            if (isset($enhancements[0]['new_verb'])) {
                $combined = $this->replaceFirstWord($combined, $enhancements[0]['new_verb']);
            }
            if ($addMetrics && !$analysis['has_numbers']) {
                $combined = $this->addMetricsToText($combined);
            }
            $enhancements[] = [
                'text' => $combined,
                'improvement' => 'Combined enhancements',
            ];
        }

        return [
            'original' => $original,
            'analysis' => $analysis,
            'enhancements' => $enhancements,
        ];
    }

    /**
     * Generate a cover letter
     */
    public function generateCoverLetter(array $input): array
    {
        $jobTitle = $input['job_title'] ?? 'Professional';
        $company = $input['company'] ?? 'the company';
        $industry = $input['industry'] ?? null;
        $type = $input['type'] ?? 'general';
        $skills = $input['skills'] ?? [];
        $experience = $input['experience'] ?? [];
        $tone = $input['tone'] ?? 'professional';
        $recipientName = $input['recipient_name'] ?? 'Hiring Manager';

        // Get templates for each paragraph
        $opening = $this->getCoverLetterParagraph('opening', $type, $industry, $tone);
        $bodySkills = $this->getCoverLetterParagraph('body_skills', $type, $industry, $tone);
        $bodyExperience = $this->getCoverLetterParagraph('body_experience', $type, $industry, $tone);
        $closing = $this->getCoverLetterParagraph('closing', $type, $industry, $tone);

        // Process templates
        $variables = [
            'job_title' => $jobTitle,
            'company' => $company,
            'industry' => $industry ?? $this->inferIndustry($jobTitle),
            'skills' => $skills,
            'experience' => $experience,
            'recipient_name' => $recipientName,
        ];

        $letter = [
            'greeting' => "Dear {$recipientName},",
            'opening' => $this->processTemplate($opening, $variables),
            'body_skills' => $this->processTemplate($bodySkills, $variables),
            'body_experience' => $this->processTemplate($bodyExperience, $variables),
            'closing' => $this->processTemplate($closing, $variables),
            'sign_off' => "Sincerely,",
        ];

        // Generate full text version
        $fullText = $letter['greeting'] . "\n\n" .
                    $letter['opening'] . "\n\n" .
                    $letter['body_skills'] . "\n\n" .
                    $letter['body_experience'] . "\n\n" .
                    $letter['closing'] . "\n\n" .
                    $letter['sign_off'];

        return [
            'sections' => $letter,
            'full_text' => $fullText,
            'word_count' => str_word_count($fullText),
            'type' => $type,
            'tone' => $tone,
        ];
    }

    /**
     * Get available industries
     */
    public function getIndustries(): Collection
    {
        return AiIndustry::active()->orderBy('name')->get(['id', 'name', 'slug']);
    }

    /**
     * Get job titles for an industry
     */
    public function getJobTitles(?int $industryId = null): Collection
    {
        $query = AiJobTitle::active();

        if ($industryId) {
            $query->where('industry_id', $industryId);
        }

        return $query->orderBy('title')->get(['id', 'title', 'level', 'industry_id']);
    }

    /**
     * Search job titles
     */
    public function searchJobTitles(string $search): Collection
    {
        return AiJobTitle::active()
            ->search($search)
            ->with('industry:id,name')
            ->limit(10)
            ->get(['id', 'title', 'level', 'industry_id']);
    }

    /**
     * Log a generation for analytics
     */
    public function logGeneration(int $userId, string $type, array $input, string $output): AiGenerationLog
    {
        return AiGenerationLog::create([
            'user_id' => $userId,
            'type' => $type,
            'input_data' => $input,
            'generated_content' => $output,
        ]);
    }

    /**
     * Mark a generation as used
     */
    public function markAsUsed(int $logId, ?int $rating = null): bool
    {
        return AiGenerationLog::where('id', $logId)->update([
            'was_used' => true,
            'rating' => $rating,
        ]) > 0;
    }

    // ==================== Private Helper Methods ====================

    private function determineExperienceLevel(int $years): string
    {
        if ($years <= 2) return 'entry';
        if ($years <= 5) return 'mid';
        if ($years <= 10) return 'senior';
        return 'executive';
    }

    private function findSummaryTemplates(?string $industry, string $jobTitle, string $level, string $tone): Collection
    {
        $query = AiSummaryTemplate::active()
            ->byLevel($level)
            ->byTone($tone)
            ->ordered();

        // Try to find industry-specific first
        if ($industry) {
            $industryModel = AiIndustry::where('slug', Str::slug($industry))
                ->orWhere('name', 'like', "%{$industry}%")
                ->first();

            if ($industryModel) {
                $query->where(function ($q) use ($industryModel) {
                    $q->where('industry_id', $industryModel->id)
                      ->orWhereNull('industry_id');
                });
            }
        }

        $templates = $query->get();

        // If not enough templates, get general ones
        if ($templates->count() < 3) {
            $generalTemplates = AiSummaryTemplate::active()
                ->byLevel($level)
                ->whereNull('industry_id')
                ->ordered()
                ->get();
            $templates = $templates->merge($generalTemplates)->unique('id');
        }

        return $templates;
    }

    private function processSummaryTemplate(string $template, array $data): string
    {
        $replacements = [
            '{job_title}' => $data['job_title'],
            '{years}' => $data['years'],
            '{industry}' => $data['industry'],
            '{level}' => ucfirst($data['level']),
            '{skills_list}' => $this->formatSkillsList($data['skills']),
            '{top_skills}' => $this->formatTopSkills($data['skills'], 3),
        ];

        $result = str_replace(array_keys($replacements), array_values($replacements), $template);

        // Add variety with phrases
        $result = $this->injectPhraseVariety($result, $data['level']);

        return $this->cleanText($result);
    }

    private function generateSummaryFromPhrases(string $jobTitle, int $years, array $skills, string $level, string $tone): string
    {
        $intro = $this->getRandomPhrase('summary_intro', $tone);
        $skillsPhrase = $this->getRandomPhrase('summary_skills', $tone);
        $goal = $this->getRandomPhrase('summary_goal', $tone);

        $summary = "{$intro} {$jobTitle} with {$years}+ years of experience. ";

        if (!empty($skills)) {
            $skillsText = $this->formatTopSkills($skills, 3);
            $summary .= str_replace('{skills}', $skillsText, $skillsPhrase) . " ";
        }

        $summary .= $goal;

        return $this->cleanText($summary);
    }

    private function findAchievementTemplates(string $jobTitle, string $category): Collection
    {
        $query = AiAchievementTemplate::active()->ordered();

        if ($category !== 'general') {
            $query->where(function ($q) use ($category) {
                $q->byCategory($category)->orWhere('category', 'general');
            });
        }

        return $query->get();
    }

    private function getActionVerbs(string $category): Collection
    {
        $verbs = AiActionVerb::active()->past();

        if ($category !== 'general') {
            $verbs->where(function ($q) use ($category) {
                $q->byCategory($category)->orWhere('category', 'general');
            });
        }

        $results = $verbs->get();

        // Fallback to default verbs if database is empty
        if ($results->isEmpty()) {
            return collect($this->getDefaultActionVerbs());
        }

        return $results;
    }

    private function processAchievementTemplate(string $template, array $data): string
    {
        $verb = ucfirst($data['verb']);
        $template = preg_replace('/^\{verb\}/i', $verb, $template);
        $template = str_replace('{verb}', strtolower($data['verb']), $template);

        // Replace context placeholders
        if (!empty($data['context'])) {
            foreach ($data['context'] as $key => $value) {
                $template = str_replace("{{$key}}", $value, $template);
            }
        }

        // Add random metrics if needed
        if ($data['include_metrics']) {
            $template = $this->injectRandomMetrics($template);
        }

        return $this->cleanText($template);
    }

    private function generateGenericBullet(string $verb, string $jobTitle, bool $includeMetrics): string
    {
        $templates = [
            "{verb} key initiatives resulting in improved team performance and operational efficiency",
            "{verb} cross-functional collaboration to deliver projects on time and within budget",
            "{verb} process improvements that enhanced productivity across the department",
            "{verb} strategic solutions to complex challenges, driving measurable results",
            "{verb} team members and stakeholders to achieve organizational objectives",
        ];

        $template = $templates[array_rand($templates)];
        $bullet = str_replace('{verb}', ucfirst($verb), $template);

        if ($includeMetrics) {
            $bullet = $this->addMetricsToText($bullet);
        }

        return $bullet;
    }

    private function getCoverLetterParagraph(string $paragraph, string $type, ?string $industry, string $tone): string
    {
        $template = AiCoverLetterTemplate::active()
            ->byType($type)
            ->byParagraph($paragraph)
            ->byTone($tone)
            ->ordered()
            ->first();

        if ($template) {
            return $template->template;
        }

        // Fallback templates
        return $this->getDefaultCoverLetterParagraph($paragraph);
    }

    private function processTemplate(string $template, array $variables): string
    {
        foreach ($variables as $key => $value) {
            if (is_array($value)) {
                $value = $this->formatSkillsList($value);
            }
            $template = str_replace("{{$key}}", $value, $template);
        }

        return $this->cleanText($template);
    }

    private function analyzeBulletPoint(string $text): array
    {
        $words = explode(' ', trim($text));
        $firstWord = strtolower($words[0] ?? '');

        return [
            'first_word' => $firstWord,
            'word_count' => count($words),
            'has_numbers' => (bool) preg_match('/\d+/', $text),
            'has_percentage' => (bool) preg_match('/\d+%/', $text),
            'has_dollar' => (bool) preg_match('/\$[\d,]+/', $text),
            'likely_category' => $this->inferCategory($firstWord),
        ];
    }

    private function inferCategory(string $verb): string
    {
        $categories = [
            'leadership' => ['led', 'managed', 'directed', 'supervised', 'mentored', 'coached', 'guided'],
            'technical' => ['developed', 'built', 'engineered', 'programmed', 'designed', 'implemented', 'deployed'],
            'communication' => ['presented', 'communicated', 'negotiated', 'collaborated', 'facilitated', 'coordinated'],
            'analytical' => ['analyzed', 'researched', 'evaluated', 'assessed', 'identified', 'diagnosed'],
            'creative' => ['created', 'designed', 'conceptualized', 'innovated', 'pioneered'],
            'sales' => ['sold', 'generated', 'acquired', 'closed', 'prospected', 'converted'],
        ];

        foreach ($categories as $category => $verbs) {
            if (in_array($verb, $verbs)) {
                return $category;
            }
        }

        return 'general';
    }

    private function replaceFirstWord(string $text, string $newWord): string
    {
        return preg_replace('/^\w+/', ucfirst($newWord), trim($text));
    }

    private function addMetricsToText(string $text): string
    {
        $metricsPatterns = [
            ', resulting in {metric}% improvement',
            ', achieving {metric}% increase in efficiency',
            ', reducing costs by {metric}%',
            ', impacting {metric}+ stakeholders',
            ', generating ${metric}K in value',
        ];

        $pattern = $metricsPatterns[array_rand($metricsPatterns)];
        $metric = rand(15, 45);
        $pattern = str_replace('{metric}', $metric, $pattern);

        // Add before the period if exists, otherwise at the end
        if (substr($text, -1) === '.') {
            return substr($text, 0, -1) . $pattern . '.';
        }

        return $text . $pattern;
    }

    private function makeMoreSpecific(string $text, string $jobTitle): string
    {
        $genericPhrases = [
            'various tasks' => 'key responsibilities',
            'different things' => 'multiple initiatives',
            'helped with' => 'contributed to',
            'worked on' => 'spearheaded',
            'was responsible for' => 'owned',
            'did' => 'executed',
        ];

        $result = $text;
        foreach ($genericPhrases as $generic => $specific) {
            $result = str_ireplace($generic, $specific, $result);
        }

        return $result;
    }

    private function injectRandomMetrics(string $text): string
    {
        // Replace placeholders with random realistic metrics
        $text = preg_replace_callback('/\{percent\}/', function () {
            return rand(15, 85) . '%';
        }, $text);

        $text = preg_replace_callback('/\{number\}/', function () {
            return rand(5, 50);
        }, $text);

        $text = preg_replace_callback('/\{dollar\}/', function () {
            return '$' . number_format(rand(10, 500) * 1000);
        }, $text);

        return $text;
    }

    private function injectPhraseVariety(string $text, string $level): string
    {
        // Add variety based on experience level
        $levelPhrases = [
            'entry' => ['eager to', 'passionate about', 'dedicated to'],
            'mid' => ['proven track record in', 'experienced in', 'skilled at'],
            'senior' => ['extensive experience in', 'expert in', 'deep expertise in'],
            'executive' => ['visionary leader in', 'strategic executive with', 'accomplished leader in'],
        ];

        $phrases = $levelPhrases[$level] ?? $levelPhrases['mid'];
        $phrase = $phrases[array_rand($phrases)];

        // Replace generic phrases with level-appropriate ones
        $text = preg_replace('/experienced in/i', $phrase, $text, 1);

        return $text;
    }

    private function getRandomPhrase(string $context, string $tone): string
    {
        $phrase = AiPhrase::active()
            ->byContext($context)
            ->byTone($tone)
            ->inRandomOrder()
            ->first();

        if ($phrase) {
            return $phrase->phrase;
        }

        return $this->getDefaultPhrase($context);
    }

    private function formatSkillsList(array $skills): string
    {
        if (empty($skills)) {
            return '';
        }

        if (count($skills) === 1) {
            return $skills[0];
        }

        if (count($skills) === 2) {
            return implode(' and ', $skills);
        }

        $last = array_pop($skills);
        return implode(', ', $skills) . ', and ' . $last;
    }

    private function formatTopSkills(array $skills, int $count): string
    {
        return $this->formatSkillsList(array_slice($skills, 0, $count));
    }

    private function inferIndustry(string $jobTitle): string
    {
        $titleLower = strtolower($jobTitle);

        $industryKeywords = [
            'Technology' => ['software', 'developer', 'engineer', 'programmer', 'data', 'it ', 'tech'],
            'Healthcare' => ['nurse', 'doctor', 'medical', 'health', 'clinical', 'patient'],
            'Finance' => ['accountant', 'financial', 'banking', 'investment', 'analyst'],
            'Marketing' => ['marketing', 'brand', 'digital', 'seo', 'content', 'social media'],
            'Sales' => ['sales', 'account executive', 'business development'],
            'Education' => ['teacher', 'professor', 'instructor', 'educator'],
            'Legal' => ['lawyer', 'attorney', 'legal', 'paralegal'],
            'Design' => ['designer', 'ux', 'ui', 'graphic', 'creative'],
        ];

        foreach ($industryKeywords as $industry => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($titleLower, $keyword)) {
                    return $industry;
                }
            }
        }

        return 'Professional Services';
    }

    private function cleanText(string $text): string
    {
        // Remove multiple spaces
        $text = preg_replace('/\s+/', ' ', $text);

        // Fix punctuation spacing
        $text = preg_replace('/\s+([.,!?])/', '$1', $text);

        // Ensure proper capitalization after periods
        $text = preg_replace_callback('/\.\s+([a-z])/', function ($matches) {
            return '. ' . strtoupper($matches[1]);
        }, $text);

        return trim($text);
    }

    private function getDefaultActionVerbs(): array
    {
        return [
            (object)['verb' => 'Led', 'category' => 'leadership'],
            (object)['verb' => 'Developed', 'category' => 'technical'],
            (object)['verb' => 'Managed', 'category' => 'leadership'],
            (object)['verb' => 'Created', 'category' => 'creative'],
            (object)['verb' => 'Implemented', 'category' => 'technical'],
            (object)['verb' => 'Improved', 'category' => 'analytical'],
            (object)['verb' => 'Coordinated', 'category' => 'communication'],
            (object)['verb' => 'Designed', 'category' => 'creative'],
            (object)['verb' => 'Analyzed', 'category' => 'analytical'],
            (object)['verb' => 'Delivered', 'category' => 'general'],
        ];
    }

    private function getDefaultPhrase(string $context): string
    {
        $defaults = [
            'summary_intro' => 'Results-driven',
            'summary_skills' => 'Proficient in {skills}',
            'summary_goal' => 'Committed to delivering exceptional results and driving organizational success.',
        ];

        return $defaults[$context] ?? '';
    }

    private function getDefaultCoverLetterParagraph(string $paragraph): string
    {
        $defaults = [
            'opening' => 'I am writing to express my strong interest in the {job_title} position at {company}. With my background and passion for excellence, I am confident I would be a valuable addition to your team.',
            'body_skills' => 'Throughout my career, I have developed expertise in {skills}. These skills have enabled me to consistently deliver results and exceed expectations in challenging environments.',
            'body_experience' => 'My professional experience has equipped me with the ability to tackle complex challenges and collaborate effectively with diverse teams. I am particularly drawn to this opportunity because of {company}\'s reputation for innovation and excellence.',
            'closing' => 'I am excited about the possibility of contributing to {company} and would welcome the opportunity to discuss how my skills and experience align with your needs. Thank you for considering my application.',
        ];

        return $defaults[$paragraph] ?? '';
    }
}
