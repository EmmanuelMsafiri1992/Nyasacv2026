<?php

namespace App\Http\Controllers;

use App\Models\EmailCampaign;
use App\Models\EmailCampaignRecipient;
use App\Models\EmailReply;
use App\User;
use App\Notifications\MarketingEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class EmailCampaignController extends Controller
{
    /**
     * Display a listing of email campaigns.
     */
    public function index()
    {
        $campaigns = EmailCampaign::with('creator')
            ->withCount(['replies', 'unreadReplies'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('email-campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create()
    {
        $verifiedUsersCount = User::whereNotNull('email_verified_at')
            ->where('is_admin', false)
            ->count();

        $templates = \App\Models\EmailTemplate::active()
            ->orderBy('name')
            ->get();

        return view('email-campaigns.create', compact('verifiedUsersCount', 'templates'));
    }

    /**
     * Get selected users details (for AJAX request).
     */
    public function getSelectedUsers(Request $request)
    {
        $userIds = $request->input('user_ids', []);
        $users = User::whereIn('id', $userIds)
            ->whereNotNull('email_verified_at')
            ->where('is_admin', false)
            ->select('id', 'name', 'email')
            ->get();

        return response()->json(['users' => $users]);
    }

    /**
     * Store a newly created campaign.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'reply_to_email' => 'nullable|email',
            'selected_users' => 'nullable|json',
        ]);

        // Check if specific users were selected
        $selectedUserIds = $request->filled('selected_users')
            ? json_decode($request->selected_users, true)
            : null;

        if ($selectedUserIds && is_array($selectedUserIds) && count($selectedUserIds) > 0) {
            // Get selected verified users
            $verifiedUsers = User::whereIn('id', $selectedUserIds)
                ->whereNotNull('email_verified_at')
                ->where('is_admin', false)
                ->get();
        } else {
            // Get all verified users (excluding admins)
            $verifiedUsers = User::whereNotNull('email_verified_at')
                ->where('is_admin', false)
                ->get();
        }

        if ($verifiedUsers->count() === 0) {
            return redirect()->back()
                ->with('error', __('No verified users found to send emails to.'));
        }

        $campaign = EmailCampaign::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'message' => $request->message,
            'reply_to_email' => $request->reply_to_email,
            'status' => 'draft',
            'total_recipients' => $verifiedUsers->count(),
            'created_by' => Auth::id(),
        ]);

        // Create recipient records
        foreach ($verifiedUsers as $user) {
            EmailCampaignRecipient::create([
                'campaign_id' => $campaign->id,
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('settings.email-campaigns.show', $campaign)
            ->with('success', __('Campaign created successfully with :count recipients', [
                'count' => $verifiedUsers->count()
            ]));
    }

    /**
     * Display the specified campaign.
     */
    public function show(EmailCampaign $emailCampaign)
    {
        $emailCampaign->load([
            'creator',
            'recipients.user',
            'replies' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'replies.user'
        ]);

        $stats = [
            'total' => $emailCampaign->total_recipients,
            'sent' => $emailCampaign->recipients()->where('status', 'sent')->count(),
            'pending' => $emailCampaign->recipients()->where('status', 'pending')->count(),
            'failed' => $emailCampaign->recipients()->where('status', 'failed')->count(),
            'replies' => $emailCampaign->replies()->count(),
            'unread_replies' => $emailCampaign->unreadReplies()->count(),
        ];

        return view('email-campaigns.show', compact('emailCampaign', 'stats'));
    }

    /**
     * Send the campaign to all recipients.
     */
    public function send(EmailCampaign $emailCampaign)
    {
        if ($emailCampaign->status === 'sent') {
            return redirect()->back()
                ->with('error', __('This campaign has already been sent.'));
        }

        // Update campaign status
        $emailCampaign->update(['status' => 'sending']);

        // Get all pending recipients
        $recipients = $emailCampaign->recipients()
            ->where('status', 'pending')
            ->with('user')
            ->get();

        $sentCount = 0;
        $failedCount = 0;

        foreach ($recipients as $recipient) {
            try {
                // Send notification
                $recipient->user->notify(new MarketingEmail($emailCampaign));

                // Update recipient status
                $recipient->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);

                $sentCount++;
            } catch (\Exception $e) {
                // Log failure
                $recipient->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);

                $failedCount++;
            }
        }

        // Update campaign
        $emailCampaign->update([
            'status' => 'sent',
            'sent_at' => now(),
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
        ]);

        return redirect()->route('settings.email-campaigns.show', $emailCampaign)
            ->with('success', __('Campaign sent successfully. Sent: :sent, Failed: :failed', [
                'sent' => $sentCount,
                'failed' => $failedCount
            ]));
    }

    /**
     * Show campaign replies.
     */
    public function replies(EmailCampaign $emailCampaign)
    {
        $replies = $emailCampaign->replies()
            ->with('user')
            ->orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('email-campaigns.replies', compact('emailCampaign', 'replies'));
    }

    /**
     * Mark reply as read.
     */
    public function markReplyAsRead(EmailCampaign $emailCampaign, EmailReply $reply)
    {
        if ($reply->campaign_id !== $emailCampaign->id) {
            abort(404);
        }

        $reply->markAsRead();

        return redirect()->back()
            ->with('success', __('Reply marked as read.'));
    }

    /**
     * Delete a campaign.
     */
    public function destroy(EmailCampaign $emailCampaign)
    {
        $emailCampaign->delete();

        return redirect()->route('settings.email-campaigns.index')
            ->with('success', __('Campaign deleted successfully.'));
    }
}
