<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Industries table
        Schema::create('ai_industries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Job titles with industry mapping
        Schema::create('ai_job_titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained('ai_industries')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('level')->default('mid'); // entry, mid, senior, executive
            $table->json('aliases')->nullable(); // Alternative titles
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['industry_id', 'slug']);
        });

        // Professional summary templates
        Schema::create('ai_summary_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->nullable()->constrained('ai_industries')->onDelete('set null');
            $table->foreignId('job_title_id')->nullable()->constrained('ai_job_titles')->onDelete('set null');
            $table->string('experience_level'); // entry, mid, senior, executive
            $table->text('template'); // Template with placeholders like {years}, {job_title}, {industry}
            $table->string('tone')->default('professional'); // professional, creative, executive
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['experience_level', 'is_active']);
        });

        // Achievement/bullet point templates
        Schema::create('ai_achievement_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->nullable()->constrained('ai_industries')->onDelete('set null');
            $table->foreignId('job_title_id')->nullable()->constrained('ai_job_titles')->onDelete('set null');
            $table->string('category'); // leadership, technical, sales, customer_service, etc.
            $table->text('template'); // Template with placeholders
            $table->json('required_inputs')->nullable(); // What user needs to provide
            $table->string('impact_type')->nullable(); // quantitative, qualitative
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'is_active']);
        });

        // Skills database
        Schema::create('ai_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->nullable()->constrained('ai_industries')->onDelete('set null');
            $table->string('name');
            $table->string('category'); // technical, soft, tools, languages, certifications
            $table->json('related_job_titles')->nullable(); // Job title IDs this skill relates to
            $table->integer('popularity')->default(50); // 1-100 how commonly requested
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'popularity']);
        });

        // Action verbs for achievements
        Schema::create('ai_action_verbs', function (Blueprint $table) {
            $table->id();
            $table->string('verb');
            $table->string('category'); // leadership, communication, technical, creative, analytical
            $table->string('tense')->default('past'); // past, present
            $table->integer('strength')->default(5); // 1-10 impact strength
            $table->json('synonyms')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'strength']);
        });

        // Professional phrases by context
        Schema::create('ai_phrases', function (Blueprint $table) {
            $table->id();
            $table->string('context'); // summary_intro, summary_skills, summary_goal, achievement_result, etc.
            $table->text('phrase');
            $table->string('tone')->default('professional');
            $table->foreignId('industry_id')->nullable()->constrained('ai_industries')->onDelete('set null');
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['context', 'is_active']);
        });

        // Cover letter templates
        Schema::create('ai_cover_letter_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->nullable()->constrained('ai_industries')->onDelete('set null');
            $table->string('type'); // general, referral, cold_application, career_change
            $table->string('paragraph'); // opening, body_skills, body_experience, closing
            $table->text('template');
            $table->string('tone')->default('professional');
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['type', 'paragraph', 'is_active']);
        });

        // User AI generation history (for analytics and improving suggestions)
        Schema::create('ai_generation_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('type'); // summary, bullet, skills, cover_letter
            $table->json('input_data');
            $table->text('generated_content');
            $table->boolean('was_used')->default(false); // Did user accept the suggestion
            $table->integer('rating')->nullable(); // User rating 1-5
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_generation_logs');
        Schema::dropIfExists('ai_cover_letter_templates');
        Schema::dropIfExists('ai_phrases');
        Schema::dropIfExists('ai_action_verbs');
        Schema::dropIfExists('ai_skills');
        Schema::dropIfExists('ai_achievement_templates');
        Schema::dropIfExists('ai_summary_templates');
        Schema::dropIfExists('ai_job_titles');
        Schema::dropIfExists('ai_industries');
    }
};
