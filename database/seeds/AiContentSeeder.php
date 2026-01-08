<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\AiIndustry;
use App\Models\AiJobTitle;
use App\Models\AiSummaryTemplate;
use App\Models\AiAchievementTemplate;
use App\Models\AiSkill;
use App\Models\AiActionVerb;
use App\Models\AiPhrase;
use App\Models\AiCoverLetterTemplate;

class AiContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedIndustries();
        $this->seedJobTitles();
        $this->seedActionVerbs();
        $this->seedPhrases();
        $this->seedSummaryTemplates();
        $this->seedAchievementTemplates();
        $this->seedSkills();
        $this->seedCoverLetterTemplates();
    }

    private function seedIndustries(): void
    {
        $industries = [
            ['name' => 'Technology', 'description' => 'Software, IT, and technology companies'],
            ['name' => 'Healthcare', 'description' => 'Medical, pharmaceutical, and healthcare services'],
            ['name' => 'Finance', 'description' => 'Banking, investment, insurance, and financial services'],
            ['name' => 'Marketing', 'description' => 'Digital marketing, advertising, and brand management'],
            ['name' => 'Sales', 'description' => 'Sales, business development, and account management'],
            ['name' => 'Education', 'description' => 'Teaching, training, and educational services'],
            ['name' => 'Legal', 'description' => 'Law firms, legal services, and compliance'],
            ['name' => 'Design', 'description' => 'Graphic design, UX/UI, and creative services'],
            ['name' => 'Engineering', 'description' => 'Civil, mechanical, electrical, and other engineering'],
            ['name' => 'Human Resources', 'description' => 'HR, recruiting, and people operations'],
            ['name' => 'Operations', 'description' => 'Operations management, logistics, and supply chain'],
            ['name' => 'Customer Service', 'description' => 'Customer support and client relations'],
            ['name' => 'Manufacturing', 'description' => 'Production, quality control, and manufacturing'],
            ['name' => 'Hospitality', 'description' => 'Hotels, restaurants, tourism, and events'],
            ['name' => 'Real Estate', 'description' => 'Property management, real estate sales, and development'],
        ];

        foreach ($industries as $industry) {
            AiIndustry::firstOrCreate(
                ['slug' => Str::slug($industry['name'])],
                [
                    'name' => $industry['name'],
                    'description' => $industry['description'],
                ]
            );
        }
    }

    private function seedJobTitles(): void
    {
        $jobTitles = [
            // Technology
            'Technology' => [
                ['title' => 'Software Engineer', 'level' => 'mid', 'aliases' => ['Software Developer', 'Programmer', 'Developer']],
                ['title' => 'Senior Software Engineer', 'level' => 'senior', 'aliases' => ['Senior Developer', 'Lead Developer']],
                ['title' => 'Full Stack Developer', 'level' => 'mid', 'aliases' => ['Full-Stack Developer', 'Web Developer']],
                ['title' => 'Frontend Developer', 'level' => 'mid', 'aliases' => ['Front-End Developer', 'UI Developer']],
                ['title' => 'Backend Developer', 'level' => 'mid', 'aliases' => ['Back-End Developer', 'Server Developer']],
                ['title' => 'DevOps Engineer', 'level' => 'mid', 'aliases' => ['Site Reliability Engineer', 'SRE']],
                ['title' => 'Data Scientist', 'level' => 'mid', 'aliases' => ['ML Engineer', 'Machine Learning Engineer']],
                ['title' => 'Data Analyst', 'level' => 'mid', 'aliases' => ['Business Analyst', 'Analytics Specialist']],
                ['title' => 'Product Manager', 'level' => 'mid', 'aliases' => ['PM', 'Product Owner']],
                ['title' => 'Project Manager', 'level' => 'mid', 'aliases' => ['Technical Project Manager', 'Scrum Master']],
                ['title' => 'QA Engineer', 'level' => 'mid', 'aliases' => ['Quality Assurance', 'Test Engineer', 'SDET']],
                ['title' => 'CTO', 'level' => 'executive', 'aliases' => ['Chief Technology Officer', 'VP Engineering']],
                ['title' => 'IT Manager', 'level' => 'senior', 'aliases' => ['IT Director', 'Technology Manager']],
                ['title' => 'Junior Developer', 'level' => 'entry', 'aliases' => ['Entry Level Developer', 'Associate Developer']],
                ['title' => 'Mobile Developer', 'level' => 'mid', 'aliases' => ['iOS Developer', 'Android Developer', 'App Developer']],
                ['title' => 'Cloud Architect', 'level' => 'senior', 'aliases' => ['Solutions Architect', 'AWS Architect']],
                ['title' => 'Cybersecurity Analyst', 'level' => 'mid', 'aliases' => ['Security Engineer', 'Information Security']],
            ],
            // Healthcare
            'Healthcare' => [
                ['title' => 'Registered Nurse', 'level' => 'mid', 'aliases' => ['RN', 'Staff Nurse']],
                ['title' => 'Nurse Practitioner', 'level' => 'senior', 'aliases' => ['NP', 'Advanced Practice Nurse']],
                ['title' => 'Medical Assistant', 'level' => 'entry', 'aliases' => ['Clinical Assistant', 'MA']],
                ['title' => 'Healthcare Administrator', 'level' => 'senior', 'aliases' => ['Hospital Administrator', 'Health Services Manager']],
                ['title' => 'Pharmacist', 'level' => 'mid', 'aliases' => ['Clinical Pharmacist', 'Pharmacy Manager']],
                ['title' => 'Physical Therapist', 'level' => 'mid', 'aliases' => ['PT', 'Physiotherapist']],
                ['title' => 'Medical Technologist', 'level' => 'mid', 'aliases' => ['Lab Technician', 'Clinical Lab Scientist']],
            ],
            // Finance
            'Finance' => [
                ['title' => 'Financial Analyst', 'level' => 'mid', 'aliases' => ['Finance Analyst', 'Investment Analyst']],
                ['title' => 'Accountant', 'level' => 'mid', 'aliases' => ['Staff Accountant', 'CPA']],
                ['title' => 'Senior Accountant', 'level' => 'senior', 'aliases' => ['Lead Accountant', 'Accounting Manager']],
                ['title' => 'Investment Banker', 'level' => 'mid', 'aliases' => ['IB Analyst', 'Banking Associate']],
                ['title' => 'Financial Advisor', 'level' => 'mid', 'aliases' => ['Wealth Manager', 'Financial Planner']],
                ['title' => 'CFO', 'level' => 'executive', 'aliases' => ['Chief Financial Officer', 'VP Finance']],
                ['title' => 'Auditor', 'level' => 'mid', 'aliases' => ['Internal Auditor', 'External Auditor']],
                ['title' => 'Controller', 'level' => 'senior', 'aliases' => ['Financial Controller', 'Accounting Controller']],
            ],
            // Marketing
            'Marketing' => [
                ['title' => 'Marketing Manager', 'level' => 'mid', 'aliases' => ['Marketing Lead', 'Brand Manager']],
                ['title' => 'Digital Marketing Specialist', 'level' => 'mid', 'aliases' => ['Digital Marketer', 'Online Marketing']],
                ['title' => 'Content Marketing Manager', 'level' => 'mid', 'aliases' => ['Content Manager', 'Content Strategist']],
                ['title' => 'SEO Specialist', 'level' => 'mid', 'aliases' => ['SEO Manager', 'Search Engine Optimizer']],
                ['title' => 'Social Media Manager', 'level' => 'mid', 'aliases' => ['Social Media Specialist', 'Community Manager']],
                ['title' => 'CMO', 'level' => 'executive', 'aliases' => ['Chief Marketing Officer', 'VP Marketing']],
                ['title' => 'Marketing Coordinator', 'level' => 'entry', 'aliases' => ['Marketing Assistant', 'Marketing Associate']],
                ['title' => 'Growth Marketing Manager', 'level' => 'mid', 'aliases' => ['Growth Hacker', 'Acquisition Manager']],
            ],
            // Sales
            'Sales' => [
                ['title' => 'Sales Representative', 'level' => 'entry', 'aliases' => ['Sales Rep', 'Inside Sales Rep']],
                ['title' => 'Account Executive', 'level' => 'mid', 'aliases' => ['AE', 'Sales Executive']],
                ['title' => 'Sales Manager', 'level' => 'senior', 'aliases' => ['Sales Lead', 'Regional Sales Manager']],
                ['title' => 'Business Development Manager', 'level' => 'mid', 'aliases' => ['BDM', 'BD Manager']],
                ['title' => 'VP Sales', 'level' => 'executive', 'aliases' => ['Vice President Sales', 'Chief Revenue Officer']],
                ['title' => 'Account Manager', 'level' => 'mid', 'aliases' => ['Client Manager', 'Customer Success Manager']],
            ],
            // Human Resources
            'Human Resources' => [
                ['title' => 'HR Manager', 'level' => 'mid', 'aliases' => ['Human Resources Manager', 'People Manager']],
                ['title' => 'Recruiter', 'level' => 'mid', 'aliases' => ['Talent Acquisition Specialist', 'Headhunter']],
                ['title' => 'HR Coordinator', 'level' => 'entry', 'aliases' => ['HR Assistant', 'HR Administrator']],
                ['title' => 'HR Director', 'level' => 'senior', 'aliases' => ['VP HR', 'Chief People Officer']],
                ['title' => 'Compensation Analyst', 'level' => 'mid', 'aliases' => ['Benefits Analyst', 'Total Rewards Analyst']],
            ],
            // Design
            'Design' => [
                ['title' => 'UX Designer', 'level' => 'mid', 'aliases' => ['User Experience Designer', 'UX/UI Designer']],
                ['title' => 'UI Designer', 'level' => 'mid', 'aliases' => ['User Interface Designer', 'Visual Designer']],
                ['title' => 'Graphic Designer', 'level' => 'mid', 'aliases' => ['Visual Designer', 'Creative Designer']],
                ['title' => 'Product Designer', 'level' => 'mid', 'aliases' => ['Digital Product Designer']],
                ['title' => 'Creative Director', 'level' => 'senior', 'aliases' => ['Design Director', 'Art Director']],
                ['title' => 'Junior Designer', 'level' => 'entry', 'aliases' => ['Associate Designer', 'Design Assistant']],
            ],
            // Customer Service
            'Customer Service' => [
                ['title' => 'Customer Service Representative', 'level' => 'entry', 'aliases' => ['CSR', 'Customer Support Rep']],
                ['title' => 'Customer Success Manager', 'level' => 'mid', 'aliases' => ['CSM', 'Client Success Manager']],
                ['title' => 'Support Team Lead', 'level' => 'senior', 'aliases' => ['Customer Service Supervisor', 'Support Manager']],
                ['title' => 'Technical Support Specialist', 'level' => 'mid', 'aliases' => ['Tech Support', 'IT Support']],
            ],
            // Operations
            'Operations' => [
                ['title' => 'Operations Manager', 'level' => 'mid', 'aliases' => ['Ops Manager', 'Business Operations Manager']],
                ['title' => 'Operations Analyst', 'level' => 'mid', 'aliases' => ['Business Analyst', 'Process Analyst']],
                ['title' => 'COO', 'level' => 'executive', 'aliases' => ['Chief Operating Officer', 'VP Operations']],
                ['title' => 'Supply Chain Manager', 'level' => 'mid', 'aliases' => ['Logistics Manager', 'Procurement Manager']],
            ],
        ];

        foreach ($jobTitles as $industryName => $titles) {
            $industry = AiIndustry::where('name', $industryName)->first();
            if (!$industry) continue;

            foreach ($titles as $title) {
                AiJobTitle::firstOrCreate(
                    ['industry_id' => $industry->id, 'slug' => Str::slug($title['title'])],
                    [
                        'title' => $title['title'],
                        'level' => $title['level'],
                        'aliases' => $title['aliases'] ?? null,
                    ]
                );
            }
        }
    }

    private function seedActionVerbs(): void
    {
        $verbs = [
            // Leadership
            ['verb' => 'Led', 'category' => 'leadership', 'strength' => 9, 'synonyms' => ['Directed', 'Headed', 'Guided']],
            ['verb' => 'Managed', 'category' => 'leadership', 'strength' => 8, 'synonyms' => ['Oversaw', 'Supervised', 'Administered']],
            ['verb' => 'Spearheaded', 'category' => 'leadership', 'strength' => 10, 'synonyms' => ['Pioneered', 'Championed']],
            ['verb' => 'Mentored', 'category' => 'leadership', 'strength' => 7, 'synonyms' => ['Coached', 'Trained', 'Developed']],
            ['verb' => 'Orchestrated', 'category' => 'leadership', 'strength' => 9, 'synonyms' => ['Coordinated', 'Organized']],
            ['verb' => 'Established', 'category' => 'leadership', 'strength' => 8, 'synonyms' => ['Founded', 'Instituted', 'Created']],
            ['verb' => 'Transformed', 'category' => 'leadership', 'strength' => 10, 'synonyms' => ['Revolutionized', 'Overhauled']],

            // Technical
            ['verb' => 'Developed', 'category' => 'technical', 'strength' => 8, 'synonyms' => ['Built', 'Created', 'Engineered']],
            ['verb' => 'Implemented', 'category' => 'technical', 'strength' => 8, 'synonyms' => ['Deployed', 'Executed', 'Launched']],
            ['verb' => 'Designed', 'category' => 'technical', 'strength' => 8, 'synonyms' => ['Architected', 'Crafted', 'Formulated']],
            ['verb' => 'Optimized', 'category' => 'technical', 'strength' => 9, 'synonyms' => ['Enhanced', 'Improved', 'Streamlined']],
            ['verb' => 'Automated', 'category' => 'technical', 'strength' => 9, 'synonyms' => ['Mechanized', 'Systematized']],
            ['verb' => 'Integrated', 'category' => 'technical', 'strength' => 7, 'synonyms' => ['Merged', 'Consolidated', 'Unified']],
            ['verb' => 'Debugged', 'category' => 'technical', 'strength' => 6, 'synonyms' => ['Troubleshot', 'Resolved', 'Fixed']],
            ['verb' => 'Programmed', 'category' => 'technical', 'strength' => 7, 'synonyms' => ['Coded', 'Scripted']],
            ['verb' => 'Refactored', 'category' => 'technical', 'strength' => 7, 'synonyms' => ['Restructured', 'Reorganized']],

            // Communication
            ['verb' => 'Presented', 'category' => 'communication', 'strength' => 7, 'synonyms' => ['Delivered', 'Demonstrated']],
            ['verb' => 'Negotiated', 'category' => 'communication', 'strength' => 9, 'synonyms' => ['Mediated', 'Arbitrated']],
            ['verb' => 'Collaborated', 'category' => 'communication', 'strength' => 7, 'synonyms' => ['Partnered', 'Teamed']],
            ['verb' => 'Communicated', 'category' => 'communication', 'strength' => 6, 'synonyms' => ['Conveyed', 'Articulated']],
            ['verb' => 'Facilitated', 'category' => 'communication', 'strength' => 8, 'synonyms' => ['Enabled', 'Expedited']],
            ['verb' => 'Influenced', 'category' => 'communication', 'strength' => 9, 'synonyms' => ['Persuaded', 'Convinced']],

            // Analytical
            ['verb' => 'Analyzed', 'category' => 'analytical', 'strength' => 8, 'synonyms' => ['Examined', 'Assessed', 'Evaluated']],
            ['verb' => 'Researched', 'category' => 'analytical', 'strength' => 7, 'synonyms' => ['Investigated', 'Explored', 'Studied']],
            ['verb' => 'Identified', 'category' => 'analytical', 'strength' => 7, 'synonyms' => ['Discovered', 'Detected', 'Recognized']],
            ['verb' => 'Diagnosed', 'category' => 'analytical', 'strength' => 8, 'synonyms' => ['Determined', 'Pinpointed']],
            ['verb' => 'Forecasted', 'category' => 'analytical', 'strength' => 8, 'synonyms' => ['Predicted', 'Projected', 'Estimated']],
            ['verb' => 'Quantified', 'category' => 'analytical', 'strength' => 8, 'synonyms' => ['Measured', 'Calculated']],

            // Creative
            ['verb' => 'Created', 'category' => 'creative', 'strength' => 8, 'synonyms' => ['Produced', 'Generated', 'Crafted']],
            ['verb' => 'Conceptualized', 'category' => 'creative', 'strength' => 9, 'synonyms' => ['Envisioned', 'Devised']],
            ['verb' => 'Innovated', 'category' => 'creative', 'strength' => 10, 'synonyms' => ['Pioneered', 'Invented']],
            ['verb' => 'Revamped', 'category' => 'creative', 'strength' => 8, 'synonyms' => ['Redesigned', 'Modernized']],
            ['verb' => 'Customized', 'category' => 'creative', 'strength' => 7, 'synonyms' => ['Tailored', 'Personalized']],

            // Sales/Business
            ['verb' => 'Generated', 'category' => 'sales', 'strength' => 9, 'synonyms' => ['Produced', 'Created', 'Drove']],
            ['verb' => 'Exceeded', 'category' => 'sales', 'strength' => 9, 'synonyms' => ['Surpassed', 'Outperformed']],
            ['verb' => 'Acquired', 'category' => 'sales', 'strength' => 8, 'synonyms' => ['Secured', 'Obtained', 'Won']],
            ['verb' => 'Expanded', 'category' => 'sales', 'strength' => 8, 'synonyms' => ['Grew', 'Increased', 'Scaled']],
            ['verb' => 'Closed', 'category' => 'sales', 'strength' => 8, 'synonyms' => ['Secured', 'Finalized']],
            ['verb' => 'Cultivated', 'category' => 'sales', 'strength' => 7, 'synonyms' => ['Developed', 'Nurtured']],

            // General
            ['verb' => 'Achieved', 'category' => 'general', 'strength' => 8, 'synonyms' => ['Accomplished', 'Attained']],
            ['verb' => 'Delivered', 'category' => 'general', 'strength' => 8, 'synonyms' => ['Provided', 'Supplied']],
            ['verb' => 'Improved', 'category' => 'general', 'strength' => 7, 'synonyms' => ['Enhanced', 'Upgraded', 'Refined']],
            ['verb' => 'Reduced', 'category' => 'general', 'strength' => 8, 'synonyms' => ['Decreased', 'Minimized', 'Cut']],
            ['verb' => 'Increased', 'category' => 'general', 'strength' => 8, 'synonyms' => ['Boosted', 'Raised', 'Elevated']],
            ['verb' => 'Streamlined', 'category' => 'general', 'strength' => 9, 'synonyms' => ['Simplified', 'Optimized']],
            ['verb' => 'Launched', 'category' => 'general', 'strength' => 8, 'synonyms' => ['Initiated', 'Introduced', 'Rolled out']],
            ['verb' => 'Executed', 'category' => 'general', 'strength' => 7, 'synonyms' => ['Performed', 'Carried out']],
        ];

        foreach ($verbs as $verb) {
            AiActionVerb::firstOrCreate(
                ['verb' => $verb['verb']],
                [
                    'category' => $verb['category'],
                    'tense' => 'past',
                    'strength' => $verb['strength'],
                    'synonyms' => $verb['synonyms'] ?? null,
                ]
            );
        }
    }

    private function seedPhrases(): void
    {
        $phrases = [
            // Summary intro phrases
            ['context' => 'summary_intro', 'phrase' => 'Results-driven', 'tone' => 'professional'],
            ['context' => 'summary_intro', 'phrase' => 'Dynamic and accomplished', 'tone' => 'professional'],
            ['context' => 'summary_intro', 'phrase' => 'Highly motivated', 'tone' => 'professional'],
            ['context' => 'summary_intro', 'phrase' => 'Dedicated and detail-oriented', 'tone' => 'professional'],
            ['context' => 'summary_intro', 'phrase' => 'Strategic and innovative', 'tone' => 'executive'],
            ['context' => 'summary_intro', 'phrase' => 'Forward-thinking', 'tone' => 'executive'],
            ['context' => 'summary_intro', 'phrase' => 'Passionate and creative', 'tone' => 'creative'],
            ['context' => 'summary_intro', 'phrase' => 'Enthusiastic and adaptable', 'tone' => 'creative'],
            ['context' => 'summary_intro', 'phrase' => 'Accomplished', 'tone' => 'professional'],
            ['context' => 'summary_intro', 'phrase' => 'Seasoned', 'tone' => 'executive'],

            // Summary skills phrases
            ['context' => 'summary_skills', 'phrase' => 'Proven expertise in {skills}', 'tone' => 'professional'],
            ['context' => 'summary_skills', 'phrase' => 'Strong background in {skills}', 'tone' => 'professional'],
            ['context' => 'summary_skills', 'phrase' => 'Demonstrated proficiency in {skills}', 'tone' => 'professional'],
            ['context' => 'summary_skills', 'phrase' => 'Specializing in {skills}', 'tone' => 'professional'],
            ['context' => 'summary_skills', 'phrase' => 'Deep expertise in {skills}', 'tone' => 'executive'],
            ['context' => 'summary_skills', 'phrase' => 'Combining skills in {skills}', 'tone' => 'creative'],

            // Summary goal phrases
            ['context' => 'summary_goal', 'phrase' => 'Committed to delivering exceptional results and driving organizational success.', 'tone' => 'professional'],
            ['context' => 'summary_goal', 'phrase' => 'Seeking to leverage expertise to contribute to team success and company growth.', 'tone' => 'professional'],
            ['context' => 'summary_goal', 'phrase' => 'Dedicated to continuous improvement and exceeding performance expectations.', 'tone' => 'professional'],
            ['context' => 'summary_goal', 'phrase' => 'Focused on driving innovation and achieving strategic business objectives.', 'tone' => 'executive'],
            ['context' => 'summary_goal', 'phrase' => 'Passionate about creating impactful solutions and fostering collaborative environments.', 'tone' => 'creative'],
            ['context' => 'summary_goal', 'phrase' => 'Eager to contribute fresh perspectives and deliver meaningful results.', 'tone' => 'creative'],

            // Achievement result phrases
            ['context' => 'achievement_result', 'phrase' => 'resulting in significant cost savings', 'tone' => 'professional'],
            ['context' => 'achievement_result', 'phrase' => 'leading to improved efficiency', 'tone' => 'professional'],
            ['context' => 'achievement_result', 'phrase' => 'driving measurable business impact', 'tone' => 'executive'],
            ['context' => 'achievement_result', 'phrase' => 'contributing to revenue growth', 'tone' => 'professional'],
            ['context' => 'achievement_result', 'phrase' => 'enhancing team productivity', 'tone' => 'professional'],
            ['context' => 'achievement_result', 'phrase' => 'strengthening customer relationships', 'tone' => 'professional'],
        ];

        foreach ($phrases as $phrase) {
            AiPhrase::firstOrCreate(
                ['context' => $phrase['context'], 'phrase' => $phrase['phrase']],
                ['tone' => $phrase['tone']]
            );
        }
    }

    private function seedSummaryTemplates(): void
    {
        $templates = [
            // Entry level
            [
                'experience_level' => 'entry',
                'template' => '{level} {job_title} with {years}+ years of experience in {industry}. Eager to apply academic knowledge and internship experience to contribute to team success. Proficient in {skills_list} with a strong foundation in problem-solving and collaboration.',
                'tone' => 'professional',
                'priority' => 10,
            ],
            [
                'experience_level' => 'entry',
                'template' => 'Motivated {job_title} graduate with hands-on experience through internships and projects. Strong foundation in {top_skills} combined with excellent communication skills. Passionate about learning and growing in the {industry} field.',
                'tone' => 'professional',
                'priority' => 9,
            ],
            [
                'experience_level' => 'entry',
                'template' => 'Recent graduate and aspiring {job_title} with demonstrated abilities in {skills_list}. Quick learner with a proactive attitude and strong work ethic. Ready to contribute fresh perspectives and enthusiasm to a dynamic team.',
                'tone' => 'creative',
                'priority' => 8,
            ],

            // Mid level
            [
                'experience_level' => 'mid',
                'template' => 'Results-driven {job_title} with {years}+ years of progressive experience in {industry}. Proven track record of delivering high-quality work while meeting tight deadlines. Skilled in {skills_list} with a focus on continuous improvement and team collaboration.',
                'tone' => 'professional',
                'priority' => 10,
            ],
            [
                'experience_level' => 'mid',
                'template' => 'Dynamic {job_title} bringing {years} years of hands-on experience in {industry}. Successfully delivered multiple projects resulting in measurable business impact. Combines technical expertise in {top_skills} with strong stakeholder management abilities.',
                'tone' => 'professional',
                'priority' => 9,
            ],
            [
                'experience_level' => 'mid',
                'template' => 'Dedicated {job_title} with a solid {years}-year background in {industry}. Known for innovative problem-solving and ability to translate complex requirements into actionable solutions. Expert in {skills_list}.',
                'tone' => 'professional',
                'priority' => 8,
            ],
            [
                'experience_level' => 'mid',
                'template' => 'Accomplished {job_title} with {years} years of experience driving results in {industry}. Proven ability to lead cross-functional initiatives and mentor junior team members. Core competencies include {top_skills}.',
                'tone' => 'professional',
                'priority' => 7,
            ],

            // Senior level
            [
                'experience_level' => 'senior',
                'template' => 'Senior {job_title} with {years}+ years of extensive experience leading initiatives in {industry}. Demonstrated success in building and mentoring high-performing teams while delivering strategic projects. Expert in {skills_list} with a track record of exceeding organizational goals.',
                'tone' => 'professional',
                'priority' => 10,
            ],
            [
                'experience_level' => 'senior',
                'template' => 'Accomplished {job_title} and thought leader with {years} years of experience driving transformation in {industry}. Combines deep technical expertise with strategic vision to deliver exceptional results. Recognized for excellence in {top_skills} and cross-functional leadership.',
                'tone' => 'executive',
                'priority' => 9,
            ],
            [
                'experience_level' => 'senior',
                'template' => 'Strategic {job_title} with {years}+ years of progressive experience in {industry}. Proven leader in developing innovative solutions and building scalable processes. Expertise spans {skills_list} with focus on driving organizational growth.',
                'tone' => 'executive',
                'priority' => 8,
            ],

            // Executive level
            [
                'experience_level' => 'executive',
                'template' => 'Visionary {job_title} with {years}+ years of executive leadership experience in {industry}. Proven track record of driving multi-million dollar initiatives and transforming organizations. Strategic thinker with expertise in {top_skills}, known for building world-class teams and delivering sustainable growth.',
                'tone' => 'executive',
                'priority' => 10,
            ],
            [
                'experience_level' => 'executive',
                'template' => 'Transformational leader and {job_title} with {years} years of C-suite experience in {industry}. Successfully scaled organizations and delivered breakthrough results through strategic innovation. Recognized authority in {skills_list} with a passion for developing next-generation leaders.',
                'tone' => 'executive',
                'priority' => 9,
            ],
            [
                'experience_level' => 'executive',
                'template' => 'Strategic {job_title} executive with {years}+ years of experience driving organizational excellence in {industry}. Track record of P&L management, market expansion, and operational transformation. Expert in {top_skills} with proven ability to navigate complex business challenges.',
                'tone' => 'executive',
                'priority' => 8,
            ],
        ];

        foreach ($templates as $template) {
            AiSummaryTemplate::firstOrCreate(
                ['experience_level' => $template['experience_level'], 'template' => $template['template']],
                [
                    'tone' => $template['tone'],
                    'priority' => $template['priority'],
                ]
            );
        }
    }

    private function seedAchievementTemplates(): void
    {
        $templates = [
            // Leadership achievements
            ['category' => 'leadership', 'template' => '{verb} a team of {number} professionals to successfully deliver {percent} increase in department productivity', 'impact_type' => 'quantitative', 'priority' => 10],
            ['category' => 'leadership', 'template' => '{verb} cross-functional team of {number} members across multiple departments to achieve project milestones ahead of schedule', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'leadership', 'template' => '{verb} strategic initiatives that reduced operational costs by {dollar} annually while maintaining service quality', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'leadership', 'template' => '{verb} company-wide process improvements resulting in {percent} efficiency gains across all teams', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'leadership', 'template' => '{verb} talent development programs that improved employee retention by {percent}', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'leadership', 'template' => '{verb} and mentored {number} junior team members, with {percent} receiving promotions within 18 months', 'impact_type' => 'quantitative', 'priority' => 7],

            // Technical achievements
            ['category' => 'technical', 'template' => '{verb} scalable software solutions that improved system performance by {percent} and reduced load times', 'impact_type' => 'quantitative', 'priority' => 10],
            ['category' => 'technical', 'template' => '{verb} automated testing framework that increased code coverage to {percent} and reduced bugs in production by {percent}', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'technical', 'template' => '{verb} cloud migration strategy that reduced infrastructure costs by {dollar} annually', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'technical', 'template' => '{verb} RESTful APIs serving {number}+ daily requests with 99.9% uptime', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'technical', 'template' => '{verb} CI/CD pipeline reducing deployment time from days to hours and improving release frequency by {percent}', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'technical', 'template' => '{verb} database optimization strategies resulting in {percent} faster query performance', 'impact_type' => 'quantitative', 'priority' => 7],
            ['category' => 'technical', 'template' => '{verb} security protocols and vulnerability assessments, achieving {percent} reduction in security incidents', 'impact_type' => 'quantitative', 'priority' => 7],

            // Sales achievements
            ['category' => 'sales', 'template' => '{verb} {dollar} in new business revenue by identifying and closing strategic enterprise accounts', 'impact_type' => 'quantitative', 'priority' => 10],
            ['category' => 'sales', 'template' => '{verb} sales targets by {percent} consistently for {number} consecutive quarters', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'sales', 'template' => '{verb} client portfolio from {number} to {number} accounts while maintaining {percent} customer satisfaction', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'sales', 'template' => '{verb} average deal size by {percent} through strategic upselling and relationship building', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'sales', 'template' => '{verb} sales pipeline of {dollar}+ through targeted prospecting and lead nurturing campaigns', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'sales', 'template' => '{verb} customer retention rate to {percent} by implementing proactive account management strategies', 'impact_type' => 'quantitative', 'priority' => 7],

            // Communication achievements
            ['category' => 'communication', 'template' => '{verb} executive presentations to C-suite stakeholders, securing buy-in for {dollar} initiatives', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'communication', 'template' => '{verb} with {number}+ cross-functional stakeholders to align project objectives and deliverables', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'communication', 'template' => '{verb} training programs for {number} employees resulting in {percent} improvement in team performance', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'communication', 'template' => '{verb} vendor negotiations resulting in {percent} cost reduction while improving service levels', 'impact_type' => 'quantitative', 'priority' => 7],

            // Customer service achievements
            ['category' => 'customer_service', 'template' => '{verb} customer satisfaction scores from {number} to {number} through improved service processes', 'impact_type' => 'quantitative', 'priority' => 10],
            ['category' => 'customer_service', 'template' => '{verb} ticket resolution time by {percent} while handling {number}+ monthly customer inquiries', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'customer_service', 'template' => '{verb} customer complaint escalations by {percent} through proactive issue resolution', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'customer_service', 'template' => '{verb} NPS score improvement of {number} points within first year through enhanced customer experience initiatives', 'impact_type' => 'quantitative', 'priority' => 8],

            // Analytical achievements
            ['category' => 'analytical', 'template' => '{verb} data analytics framework that identified {dollar} in cost-saving opportunities', 'impact_type' => 'quantitative', 'priority' => 10],
            ['category' => 'analytical', 'template' => '{verb} market research insights that informed product strategy and increased market share by {percent}', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'analytical', 'template' => '{verb} financial models that improved forecasting accuracy by {percent}', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'analytical', 'template' => '{verb} KPI dashboards providing real-time visibility into {number}+ performance metrics', 'impact_type' => 'quantitative', 'priority' => 7],

            // General achievements
            ['category' => 'general', 'template' => '{verb} process improvements that reduced operational costs by {percent} annually', 'impact_type' => 'quantitative', 'priority' => 9],
            ['category' => 'general', 'template' => '{verb} project milestones {percent} ahead of schedule while staying {percent} under budget', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'general', 'template' => '{verb} new workflows that improved team efficiency by {percent} and reduced errors', 'impact_type' => 'quantitative', 'priority' => 8],
            ['category' => 'general', 'template' => '{verb} quality assurance processes resulting in {percent} reduction in defects', 'impact_type' => 'quantitative', 'priority' => 7],
            ['category' => 'general', 'template' => '{verb} documentation and training materials that reduced onboarding time by {percent}', 'impact_type' => 'quantitative', 'priority' => 7],
        ];

        foreach ($templates as $template) {
            AiAchievementTemplate::firstOrCreate(
                ['category' => $template['category'], 'template' => $template['template']],
                [
                    'impact_type' => $template['impact_type'],
                    'priority' => $template['priority'],
                ]
            );
        }
    }

    private function seedSkills(): void
    {
        // Technical Skills
        $technicalSkills = [
            'JavaScript', 'Python', 'Java', 'C++', 'C#', 'PHP', 'Ruby', 'Go', 'Swift', 'Kotlin', 'TypeScript', 'Rust', 'Scala',
            'React', 'Angular', 'Vue.js', 'Node.js', 'Django', 'Flask', 'Spring Boot', 'Laravel', 'Ruby on Rails', '.NET', 'Express.js', 'Next.js',
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Elasticsearch', 'Oracle', 'SQL Server', 'DynamoDB', 'Cassandra',
            'AWS', 'Azure', 'Google Cloud', 'Docker', 'Kubernetes', 'Jenkins', 'Terraform', 'Ansible', 'CI/CD', 'Git',
            'Machine Learning', 'Data Analysis', 'TensorFlow', 'PyTorch', 'Pandas', 'NumPy', 'Tableau', 'Power BI', 'SQL', 'ETL',
        ];

        $techIndustry = AiIndustry::where('slug', 'technology')->first();
        foreach ($technicalSkills as $index => $skill) {
            AiSkill::firstOrCreate(
                ['name' => $skill, 'category' => 'technical'],
                [
                    'industry_id' => $techIndustry?->id,
                    'popularity' => max(50, 100 - $index * 2),
                ]
            );
        }

        // Soft Skills
        $softSkills = [
            'Communication', 'Leadership', 'Problem Solving', 'Critical Thinking', 'Time Management',
            'Team Collaboration', 'Adaptability', 'Attention to Detail', 'Project Management', 'Strategic Planning',
            'Decision Making', 'Conflict Resolution', 'Emotional Intelligence', 'Creativity', 'Negotiation',
            'Presentation Skills', 'Customer Focus', 'Analytical Thinking', 'Mentoring', 'Cross-functional Collaboration',
        ];

        foreach ($softSkills as $index => $skill) {
            AiSkill::firstOrCreate(
                ['name' => $skill, 'category' => 'soft'],
                [
                    'industry_id' => null,
                    'popularity' => max(60, 100 - $index * 2),
                ]
            );
        }

        // Marketing Skills
        $marketingSkills = [
            'SEO', 'SEM', 'Google Analytics', 'Social Media Marketing', 'Content Marketing',
            'Email Marketing', 'Marketing Automation', 'HubSpot', 'Salesforce', 'A/B Testing',
            'Brand Strategy', 'Market Research', 'Google Ads', 'Facebook Ads', 'Copywriting',
        ];

        $marketingIndustry = AiIndustry::where('slug', 'marketing')->first();
        foreach ($marketingSkills as $index => $skill) {
            AiSkill::firstOrCreate(
                ['name' => $skill, 'category' => 'technical'],
                [
                    'industry_id' => $marketingIndustry?->id,
                    'popularity' => max(55, 95 - $index * 2),
                ]
            );
        }

        // Finance Skills
        $financeSkills = [
            'Financial Modeling', 'Excel', 'Financial Analysis', 'Budgeting', 'Forecasting',
            'GAAP', 'QuickBooks', 'SAP', 'Bloomberg Terminal', 'Risk Management',
            'Accounts Payable', 'Accounts Receivable', 'Tax Preparation', 'Audit', 'Compliance',
        ];

        $financeIndustry = AiIndustry::where('slug', 'finance')->first();
        foreach ($financeSkills as $index => $skill) {
            AiSkill::firstOrCreate(
                ['name' => $skill, 'category' => 'technical'],
                [
                    'industry_id' => $financeIndustry?->id,
                    'popularity' => max(55, 95 - $index * 2),
                ]
            );
        }

        // Design Skills
        $designSkills = [
            'Adobe Photoshop', 'Adobe Illustrator', 'Figma', 'Sketch', 'Adobe XD',
            'UI Design', 'UX Design', 'Wireframing', 'Prototyping', 'User Research',
            'Design Systems', 'Typography', 'Color Theory', 'Responsive Design', 'Accessibility',
        ];

        $designIndustry = AiIndustry::where('slug', 'design')->first();
        foreach ($designSkills as $index => $skill) {
            AiSkill::firstOrCreate(
                ['name' => $skill, 'category' => 'technical'],
                [
                    'industry_id' => $designIndustry?->id,
                    'popularity' => max(55, 95 - $index * 2),
                ]
            );
        }

        // Healthcare Skills
        $healthcareSkills = [
            'Patient Care', 'EMR/EHR Systems', 'HIPAA Compliance', 'Medical Terminology', 'Clinical Documentation',
            'Vital Signs Monitoring', 'Medication Administration', 'Patient Assessment', 'Care Coordination', 'CPR Certified',
        ];

        $healthcareIndustry = AiIndustry::where('slug', 'healthcare')->first();
        foreach ($healthcareSkills as $index => $skill) {
            AiSkill::firstOrCreate(
                ['name' => $skill, 'category' => 'technical'],
                [
                    'industry_id' => $healthcareIndustry?->id,
                    'popularity' => max(60, 95 - $index * 2),
                ]
            );
        }

        // Tools
        $tools = [
            'Microsoft Office', 'Google Workspace', 'Slack', 'Jira', 'Trello',
            'Asana', 'Notion', 'Confluence', 'Monday.com', 'Zoom',
        ];

        foreach ($tools as $index => $skill) {
            AiSkill::firstOrCreate(
                ['name' => $skill, 'category' => 'tools'],
                [
                    'industry_id' => null,
                    'popularity' => max(50, 90 - $index * 3),
                ]
            );
        }
    }

    private function seedCoverLetterTemplates(): void
    {
        $templates = [
            // General - Opening
            [
                'type' => 'general',
                'paragraph' => 'opening',
                'template' => 'I am writing to express my strong interest in the {job_title} position at {company}. With my background in {industry} and proven track record of delivering results, I am confident I would be a valuable addition to your team.',
                'tone' => 'professional',
                'priority' => 10,
            ],
            [
                'type' => 'general',
                'paragraph' => 'opening',
                'template' => 'I was excited to discover the {job_title} opening at {company}. Your company\'s reputation for innovation and excellence aligns perfectly with my career aspirations and professional values.',
                'tone' => 'professional',
                'priority' => 9,
            ],
            [
                'type' => 'general',
                'paragraph' => 'opening',
                'template' => 'The {job_title} position at {company} immediately caught my attention. Having followed your company\'s growth and achievements in {industry}, I am eager to contribute my skills to your continued success.',
                'tone' => 'creative',
                'priority' => 8,
            ],

            // General - Body Skills
            [
                'type' => 'general',
                'paragraph' => 'body_skills',
                'template' => 'Throughout my career, I have developed strong expertise in {skills}. These skills have enabled me to consistently exceed expectations, solve complex problems, and deliver measurable results in fast-paced environments.',
                'tone' => 'professional',
                'priority' => 10,
            ],
            [
                'type' => 'general',
                'paragraph' => 'body_skills',
                'template' => 'My professional toolkit includes proficiency in {skills}, which I have applied successfully across various projects and initiatives. I pride myself on staying current with industry trends and continuously expanding my capabilities.',
                'tone' => 'professional',
                'priority' => 9,
            ],

            // General - Body Experience
            [
                'type' => 'general',
                'paragraph' => 'body_experience',
                'template' => 'In my previous roles, I have demonstrated the ability to lead projects, collaborate with diverse teams, and deliver exceptional results under pressure. I am particularly proud of my contributions that have driven efficiency improvements and cost savings.',
                'tone' => 'professional',
                'priority' => 10,
            ],
            [
                'type' => 'general',
                'paragraph' => 'body_experience',
                'template' => 'My experience has taught me the importance of combining strategic thinking with hands-on execution. I have successfully managed multiple priorities while maintaining attention to detail and quality standards.',
                'tone' => 'professional',
                'priority' => 9,
            ],

            // General - Closing
            [
                'type' => 'general',
                'paragraph' => 'closing',
                'template' => 'I am excited about the opportunity to contribute to {company} and would welcome the chance to discuss how my background and skills align with your team\'s needs. Thank you for considering my application.',
                'tone' => 'professional',
                'priority' => 10,
            ],
            [
                'type' => 'general',
                'paragraph' => 'closing',
                'template' => 'I would be thrilled to bring my passion and expertise to {company}. I look forward to the opportunity to discuss how I can contribute to your team\'s success. Thank you for your time and consideration.',
                'tone' => 'professional',
                'priority' => 9,
            ],

            // Referral type
            [
                'type' => 'referral',
                'paragraph' => 'opening',
                'template' => 'I was referred to this {job_title} opportunity at {company} by a colleague who spoke highly of your team and company culture. After learning more about the role, I am confident that my skills and experience make me an excellent fit.',
                'tone' => 'professional',
                'priority' => 10,
            ],

            // Career change type
            [
                'type' => 'career_change',
                'paragraph' => 'opening',
                'template' => 'While my background may appear unconventional for the {job_title} role at {company}, I believe my transferable skills and fresh perspective would bring unique value to your team. My passion for {industry} has driven me to make this exciting career transition.',
                'tone' => 'professional',
                'priority' => 10,
            ],
            [
                'type' => 'career_change',
                'paragraph' => 'body_skills',
                'template' => 'My diverse background has equipped me with a unique combination of skills including {skills}. These transferable abilities, combined with my dedication to learning and growth, position me to make meaningful contributions in this new field.',
                'tone' => 'professional',
                'priority' => 10,
            ],
        ];

        foreach ($templates as $template) {
            AiCoverLetterTemplate::firstOrCreate(
                ['type' => $template['type'], 'paragraph' => $template['paragraph'], 'template' => $template['template']],
                [
                    'tone' => $template['tone'],
                    'priority' => $template['priority'],
                ]
            );
        }
    }
}
