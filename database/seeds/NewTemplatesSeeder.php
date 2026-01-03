<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Adds 5 new modern CV/Resume templates without image requirements
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'category_id' => 2, // Resumes
                'name' => 'Minimalist Modern',
                'directory' => 'resume_minimalist_modern',
                'thumb' => 'minimalist_modern.png'
            ],
            [
                'category_id' => 2, // Resumes
                'name' => 'Gradient Accent',
                'directory' => 'resume_gradient_accent',
                'thumb' => 'gradient_accent.png'
            ],
            [
                'category_id' => 2, // Resumes
                'name' => 'Timeline Modern',
                'directory' => 'resume_timeline_modern',
                'thumb' => 'timeline_modern.png'
            ],
            [
                'category_id' => 2, // Resumes
                'name' => 'Sidebar Modern',
                'directory' => 'resume_sidebar_modern',
                'thumb' => 'sidebar_modern.png'
            ],
            [
                'category_id' => 2, // Resumes
                'name' => 'Bold Header',
                'directory' => 'resume_bold_header',
                'thumb' => 'bold_header.png'
            ]
        ];

        $baseDir = public_path('resume_public/resume_template/');

        foreach ($templates as $template) {
            $templatePath = $baseDir . $template['directory'] . '/template.blade.php';
            $stylePath = $baseDir . $template['directory'] . '/style.css';

            if (!file_exists($templatePath)) {
                $this->command->error("Template file not found: {$templatePath}");
                continue;
            }

            if (!file_exists($stylePath)) {
                $this->command->error("Style file not found: {$stylePath}");
                continue;
            }

            // Read template and style content
            $content = file_get_contents($templatePath);
            $style = file_get_contents($stylePath);

            // Remove DOCTYPE and html tags as per existing templates
            $content = preg_replace('/<\!DOCTYPE[^>]*>/i', '', $content);
            $content = preg_replace('/<\/?html[^>]*>/i', '', $content);
            $content = preg_replace('/<head>.*?<\/head>/is', '', $content);
            $content = preg_replace('/<\/?body[^>]*>/i', '', $content);
            $content = trim($content);

            // Check if template already exists
            $exists = DB::table('resume_templates')
                ->where('name', $template['name'])
                ->exists();

            if ($exists) {
                $this->command->warn("Template '{$template['name']}' already exists. Skipping...");
                continue;
            }

            // Insert into database
            DB::table('resume_templates')->insert([
                'category_id' => $template['category_id'],
                'name' => $template['name'],
                'thumb' => $template['thumb'],
                'content' => $content,
                'style' => $style,
                'active' => true,
                'is_premium' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->command->info("Template '{$template['name']}' inserted successfully!");
        }

        $this->command->info("Seeding completed! " . count($templates) . " new templates processed.");
        $this->command->warn("\nREMINDER: Create thumbnail images for each template:");
        foreach ($templates as $template) {
            $this->command->line("  - public/resume_public/resume_template/{$template['directory']}/{$template['thumb']}");
        }
    }
}
