<?php

namespace App\Http\Controllers;

use App\Models\AdminEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminEmailController extends Controller
{
    protected $imapHost;
    protected $imapPort;
    protected $imapUser;
    protected $imapPassword;
    protected $smtpFrom;

    public function __construct()
    {
        $this->imapHost = config('mail.imap.host', 'mail.nyasacv.com');
        $this->imapPort = config('mail.imap.port', 993);
        $this->imapUser = config('mail.imap.username', config('mail.username'));
        $this->imapPassword = config('mail.imap.password', config('mail.password'));
        $this->smtpFrom = config('mail.from.address');
    }

    /**
     * Display inbox
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder', 'inbox');
        $search = $request->get('search');

        $query = AdminEmail::query();

        if ($folder === 'starred') {
            $query->starred();
        } else {
            $query->where('folder', $folder);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhere('from_email', 'like', "%{$search}%")
                    ->orWhere('from_name', 'like', "%{$search}%")
                    ->orWhere('body_text', 'like', "%{$search}%");
            });
        }

        $emails = $query->orderByDesc('received_at')->paginate(20);

        // Get counts for sidebar
        $counts = [
            'inbox' => AdminEmail::inbox()->count(),
            'unread' => AdminEmail::inbox()->unread()->count(),
            'sent' => AdminEmail::sent()->count(),
            'starred' => AdminEmail::starred()->count(),
            'trash' => AdminEmail::where('folder', 'trash')->count(),
        ];

        return view('admin.emails.index', compact('emails', 'folder', 'counts', 'search'));
    }

    /**
     * Show compose form
     */
    public function compose(Request $request)
    {
        $replyTo = null;
        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        if ($request->has('reply_to')) {
            $replyTo = AdminEmail::find($request->get('reply_to'));
        }

        return view('admin.emails.compose', compact('users', 'replyTo'));
    }

    /**
     * Send email
     */
    public function send(Request $request)
    {
        $request->validate([
            'to_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $toEmail = $request->input('to_email');
        $subject = $request->input('subject');
        $body = $request->input('body');
        $replyToId = $request->input('reply_to_id');

        try {
            // Send via Laravel Mail
            Mail::send([], [], function ($message) use ($toEmail, $subject, $body) {
                $message->to($toEmail)
                    ->subject($subject)
                    ->html($body);
            });

            // Store in database as sent
            $email = AdminEmail::create([
                'message_id' => '<' . Str::uuid() . '@nyasacv.com>',
                'from_email' => $this->smtpFrom,
                'from_name' => config('mail.from.name'),
                'to_email' => $toEmail,
                'subject' => $subject,
                'body_html' => $body,
                'body_text' => strip_tags($body),
                'folder' => 'sent',
                'is_read' => true,
                'sent_at' => now(),
                'parent_id' => $replyToId,
            ]);

            return redirect()->route('settings.admin-emails.index', ['folder' => 'sent'])
                ->with('success', 'Email sent successfully to ' . $toEmail);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * View single email
     */
    public function show(AdminEmail $adminEmail)
    {
        $adminEmail->markAsRead();

        // Get thread (parent and replies)
        $thread = collect([$adminEmail]);
        if ($adminEmail->parent_id) {
            $thread->prepend($adminEmail->parent);
        }
        $thread = $thread->merge($adminEmail->replies);

        return view('admin.emails.show', compact('adminEmail', 'thread'));
    }

    /**
     * Toggle star status
     */
    public function toggleStar(AdminEmail $adminEmail)
    {
        $adminEmail->toggleStar();
        return response()->json(['starred' => $adminEmail->is_starred]);
    }

    /**
     * Move to trash
     */
    public function trash(AdminEmail $adminEmail)
    {
        $adminEmail->moveToTrash();
        return back()->with('success', 'Email moved to trash');
    }

    /**
     * Restore from trash
     */
    public function restore(AdminEmail $adminEmail)
    {
        $adminEmail->restore();
        return back()->with('success', 'Email restored to inbox');
    }

    /**
     * Permanently delete
     */
    public function destroy(AdminEmail $adminEmail)
    {
        $adminEmail->delete();
        return back()->with('success', 'Email permanently deleted');
    }

    /**
     * Mark as read/unread
     */
    public function toggleRead(AdminEmail $adminEmail)
    {
        $adminEmail->update(['is_read' => !$adminEmail->is_read]);
        return response()->json(['is_read' => $adminEmail->is_read]);
    }

    /**
     * Fetch emails from IMAP server
     */
    public function fetchEmails()
    {
        try {
            $mailbox = $this->connectImap();
            if (!$mailbox) {
                return back()->with('error', 'Could not connect to mail server');
            }

            $emails = imap_search($mailbox, 'ALL');
            $fetched = 0;

            if ($emails) {
                rsort($emails); // Newest first
                $emails = array_slice($emails, 0, 50); // Fetch last 50

                foreach ($emails as $emailNumber) {
                    $header = imap_headerinfo($mailbox, $emailNumber);
                    $messageId = isset($header->message_id) ? $header->message_id : null;

                    // Skip if already exists
                    if ($messageId && AdminEmail::where('message_id', $messageId)->exists()) {
                        continue;
                    }

                    $structure = imap_fetchstructure($mailbox, $emailNumber);
                    $body = $this->getBody($mailbox, $emailNumber, $structure);

                    $fromEmail = isset($header->from[0]->mailbox, $header->from[0]->host)
                        ? $header->from[0]->mailbox . '@' . $header->from[0]->host
                        : 'unknown@unknown.com';

                    $fromName = isset($header->from[0]->personal)
                        ? $this->decodeMimeString($header->from[0]->personal)
                        : null;

                    $subject = isset($header->subject)
                        ? $this->decodeMimeString($header->subject)
                        : '(No Subject)';

                    $toEmail = isset($header->to[0]->mailbox, $header->to[0]->host)
                        ? $header->to[0]->mailbox . '@' . $header->to[0]->host
                        : $this->imapUser;

                    $receivedAt = isset($header->date) ? date('Y-m-d H:i:s', strtotime($header->date)) : now();

                    // Check for attachments
                    $hasAttachments = $this->hasAttachments($structure);

                    // Find parent email for threading
                    $parentId = null;
                    if (isset($header->in_reply_to)) {
                        $parent = AdminEmail::where('message_id', trim($header->in_reply_to))->first();
                        $parentId = $parent ? $parent->id : null;
                    }

                    AdminEmail::create([
                        'message_id' => $messageId,
                        'from_email' => $fromEmail,
                        'from_name' => $fromName,
                        'to_email' => $toEmail,
                        'subject' => $subject,
                        'body_html' => $body['html'],
                        'body_text' => $body['text'],
                        'in_reply_to' => isset($header->in_reply_to) ? $header->in_reply_to : null,
                        'references' => isset($header->references) ? $header->references : null,
                        'folder' => 'inbox',
                        'is_read' => false,
                        'has_attachments' => $hasAttachments,
                        'received_at' => $receivedAt,
                        'parent_id' => $parentId,
                    ]);

                    $fetched++;
                }
            }

            imap_close($mailbox);

            return back()->with('success', "Fetched {$fetched} new emails from mail server");

        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching emails: ' . $e->getMessage());
        }
    }

    /**
     * Connect to IMAP server
     */
    protected function connectImap()
    {
        $mailbox = '{' . $this->imapHost . ':' . $this->imapPort . '/imap/ssl}INBOX';

        try {
            return imap_open($mailbox, $this->imapUser, $this->imapPassword);
        } catch (\Exception $e) {
            \Log::error('IMAP Connection Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get email body (HTML and plain text)
     */
    protected function getBody($mailbox, $emailNumber, $structure)
    {
        $body = ['html' => '', 'text' => ''];

        if (!isset($structure->parts)) {
            // Simple message
            $content = imap_fetchbody($mailbox, $emailNumber, 1);
            $content = $this->decodeBody($content, $structure->encoding ?? 0);

            if (isset($structure->subtype) && strtoupper($structure->subtype) == 'HTML') {
                $body['html'] = $content;
                $body['text'] = strip_tags($content);
            } else {
                $body['text'] = $content;
                $body['html'] = nl2br(htmlspecialchars($content));
            }
        } else {
            // Multipart message
            foreach ($structure->parts as $index => $part) {
                $partNumber = $index + 1;

                if (isset($part->subtype)) {
                    $content = imap_fetchbody($mailbox, $emailNumber, $partNumber);
                    $content = $this->decodeBody($content, $part->encoding ?? 0);

                    if (strtoupper($part->subtype) == 'PLAIN' && empty($body['text'])) {
                        $body['text'] = $content;
                    } elseif (strtoupper($part->subtype) == 'HTML' && empty($body['html'])) {
                        $body['html'] = $content;
                    }
                }
            }

            // Generate HTML from text if no HTML part
            if (empty($body['html']) && !empty($body['text'])) {
                $body['html'] = nl2br(htmlspecialchars($body['text']));
            }

            // Generate text from HTML if no text part
            if (empty($body['text']) && !empty($body['html'])) {
                $body['text'] = strip_tags($body['html']);
            }
        }

        return $body;
    }

    /**
     * Decode body based on encoding
     */
    protected function decodeBody($body, $encoding)
    {
        switch ($encoding) {
            case 0: // 7BIT
            case 1: // 8BIT
                return $body;
            case 2: // BINARY
                return $body;
            case 3: // BASE64
                return base64_decode($body);
            case 4: // QUOTED-PRINTABLE
                return quoted_printable_decode($body);
            default:
                return $body;
        }
    }

    /**
     * Decode MIME encoded string
     */
    protected function decodeMimeString($string)
    {
        $elements = imap_mime_header_decode($string);
        $result = '';
        foreach ($elements as $element) {
            $result .= $element->text;
        }
        return $result;
    }

    /**
     * Check if email has attachments
     */
    protected function hasAttachments($structure)
    {
        if (isset($structure->parts)) {
            foreach ($structure->parts as $part) {
                if (isset($part->disposition) && strtoupper($part->disposition) == 'ATTACHMENT') {
                    return true;
                }
                if (isset($part->parts) && $this->hasAttachments($part)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'No emails selected');
        }

        switch ($action) {
            case 'read':
                AdminEmail::whereIn('id', $ids)->update(['is_read' => true]);
                return back()->with('success', 'Marked as read');
            case 'unread':
                AdminEmail::whereIn('id', $ids)->update(['is_read' => false]);
                return back()->with('success', 'Marked as unread');
            case 'trash':
                AdminEmail::whereIn('id', $ids)->update(['folder' => 'trash']);
                return back()->with('success', 'Moved to trash');
            case 'delete':
                AdminEmail::whereIn('id', $ids)->where('folder', 'trash')->delete();
                return back()->with('success', 'Permanently deleted');
            default:
                return back()->with('error', 'Unknown action');
        }
    }
}
