<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of email templates.
     */
    public function index()
    {
        $templates = EmailTemplate::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('email-templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new template.
     */
    public function create()
    {
        $categories = ['Promotional', 'Newsletter', 'Announcement', 'Welcome', 'Update', 'Other'];
        return view('email-templates.create', compact('categories'));
    }

    /**
     * Store a newly created template.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        EmailTemplate::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'message' => $request->message,
            'category' => $request->category,
            'is_active' => $request->filled('is_active') ? true : false,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('settings.email-templates.index')
            ->with('success', __('Email template created successfully.'));
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        $categories = ['Promotional', 'Newsletter', 'Announcement', 'Welcome', 'Update', 'Other'];
        return view('email-templates.edit', compact('emailTemplate', 'categories'));
    }

    /**
     * Update the specified template.
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $emailTemplate->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'message' => $request->message,
            'category' => $request->category,
            'is_active' => $request->filled('is_active') ? true : false,
        ]);

        return redirect()->route('settings.email-templates.index')
            ->with('success', __('Email template updated successfully.'));
    }

    /**
     * Remove the specified template.
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return redirect()->route('settings.email-templates.index')
            ->with('success', __('Email template deleted successfully.'));
    }

    /**
     * Get template details via AJAX.
     */
    public function show(EmailTemplate $emailTemplate)
    {
        return response()->json([
            'id' => $emailTemplate->id,
            'name' => $emailTemplate->name,
            'subject' => $emailTemplate->subject,
            'message' => $emailTemplate->message,
            'category' => $emailTemplate->category,
        ]);
    }
}
