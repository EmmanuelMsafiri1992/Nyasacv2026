<?php

namespace App\Http\Controllers;

use App\Services\ResumeAiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ResumeAiController extends Controller
{
    protected ResumeAiService $aiService;

    public function __construct(ResumeAiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Generate professional summary
     */
    public function generateSummary(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'years_experience' => 'required|integer|min:0|max:50',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'tone' => 'nullable|string|in:professional,creative,executive',
            'count' => 'nullable|integer|min:1|max:5',
        ]);

        $summaries = $this->aiService->generateSummary($validated);

        // Log generation for analytics
        if (Auth::check()) {
            $this->aiService->logGeneration(
                Auth::id(),
                'summary',
                $validated,
                json_encode($summaries)
            );
        }

        return response()->json([
            'success' => true,
            'data' => $summaries,
        ]);
    }

    /**
     * Generate achievement bullet points
     */
    public function generateBulletPoints(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'category' => 'nullable|string|in:leadership,technical,communication,analytical,creative,sales,customer_service,general',
            'context' => 'nullable|array',
            'count' => 'nullable|integer|min:1|max:10',
            'include_metrics' => 'nullable|boolean',
        ]);

        $bullets = $this->aiService->generateBulletPoints($validated);

        if (Auth::check()) {
            $this->aiService->logGeneration(
                Auth::id(),
                'bullet',
                $validated,
                json_encode($bullets)
            );
        }

        return response()->json([
            'success' => true,
            'data' => $bullets,
        ]);
    }

    /**
     * Suggest skills based on job title
     */
    public function suggestSkills(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'existing_skills' => 'nullable|array',
            'existing_skills.*' => 'string|max:100',
            'count' => 'nullable|integer|min:1|max:20',
        ]);

        $skills = $this->aiService->suggestSkills($validated);

        return response()->json([
            'success' => true,
            'data' => $skills,
        ]);
    }

    /**
     * Enhance a bullet point
     */
    public function enhanceBulletPoint(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:1000',
            'job_title' => 'nullable|string|max:255',
            'add_metrics' => 'nullable|boolean',
        ]);

        $enhancements = $this->aiService->enhanceBulletPoint($validated);

        if (Auth::check()) {
            $this->aiService->logGeneration(
                Auth::id(),
                'enhance',
                $validated,
                json_encode($enhancements)
            );
        }

        return response()->json([
            'success' => true,
            'data' => $enhancements,
        ]);
    }

    /**
     * Generate cover letter
     */
    public function generateCoverLetter(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'type' => 'nullable|string|in:general,referral,cold_application,career_change',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'experience' => 'nullable|array',
            'tone' => 'nullable|string|in:professional,creative,executive',
            'recipient_name' => 'nullable|string|max:255',
        ]);

        $coverLetter = $this->aiService->generateCoverLetter($validated);

        if (Auth::check()) {
            $this->aiService->logGeneration(
                Auth::id(),
                'cover_letter',
                $validated,
                json_encode($coverLetter)
            );
        }

        return response()->json([
            'success' => true,
            'data' => $coverLetter,
        ]);
    }

    /**
     * Get available industries
     */
    public function getIndustries(): JsonResponse
    {
        $industries = $this->aiService->getIndustries();

        return response()->json([
            'success' => true,
            'data' => $industries,
        ]);
    }

    /**
     * Get job titles (optionally by industry)
     */
    public function getJobTitles(Request $request): JsonResponse
    {
        $industryId = $request->input('industry_id');
        $jobTitles = $this->aiService->getJobTitles($industryId);

        return response()->json([
            'success' => true,
            'data' => $jobTitles,
        ]);
    }

    /**
     * Search job titles
     */
    public function searchJobTitles(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $jobTitles = $this->aiService->searchJobTitles($validated['q']);

        return response()->json([
            'success' => true,
            'data' => $jobTitles,
        ]);
    }

    /**
     * Mark a generation as used (for analytics)
     */
    public function markUsed(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'log_id' => 'required|integer|exists:ai_generation_logs,id',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $success = $this->aiService->markAsUsed($validated['log_id'], $validated['rating'] ?? null);

        return response()->json([
            'success' => $success,
        ]);
    }

    /**
     * AI Assistant page view
     */
    public function index()
    {
        $industries = $this->aiService->getIndustries();

        return view('resume.ai-assistant', [
            'industries' => $industries,
        ]);
    }
}
