<?php

namespace App\Http\Controllers;

use App\ChatConversation;
use App\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Initialize conversation for user
     */
    public function initConversation(Request $request)
    {
        $user = Auth::user();

        // Check if email is verified
        if (!$user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email address before using live chat.',
                'requires_verification' => true
            ], 403);
        }

        // Get or create conversation
        $conversation = ChatConversation::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'active'],
            [
                'user_name' => $user->name,
                'user_email' => $user->email,
            ]
        );

        // Mark admin messages as read
        $conversation->markAdminMessagesRead();

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'messages' => $conversation->messages()->orderBy('created_at', 'asc')->get()
        ]);
    }

    /**
     * Send message from user
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:chat_conversations,id',
            'message' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $conversation = ChatConversation::findOrFail($request->conversation_id);

        // Verify user owns this conversation
        if ($conversation->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Create message
        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'sender_type' => 'user',
            'message' => $request->message,
            'is_read' => false
        ]);

        // Update conversation
        $conversation->increment('unread_admin_count');
        $conversation->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Get new messages
     */
    public function getMessages(Request $request, $conversationId)
    {
        $user = Auth::user();
        $conversation = ChatConversation::findOrFail($conversationId);

        // Verify user owns this conversation
        if ($conversation->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Get messages after the last known message
        $lastMessageId = $request->input('last_message_id', 0);
        $messages = $conversation->messages()
            ->where('id', '>', $lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark admin messages as read
        if ($messages->count() > 0) {
            $conversation->markAdminMessagesRead();
        }

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'unread_count' => 0
        ]);
    }

    /**
     * Admin: Get all conversations
     */
    public function adminGetConversations(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $conversations = ChatConversation::with(['user', 'latestMessage'])
            ->where('status', 'active')
            ->orderBy('last_message_at', 'desc')
            ->orderBy('unread_admin_count', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'conversations' => $conversations
        ]);
    }

    /**
     * Admin: Get conversation messages
     */
    public function adminGetMessages(Request $request, $conversationId)
    {
        if (!Auth::user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $conversation = ChatConversation::with('messages')->findOrFail($conversationId);

        // Mark user messages as read
        $conversation->markUserMessagesRead();

        return response()->json([
            'success' => true,
            'conversation' => $conversation,
            'messages' => $conversation->messages()->orderBy('created_at', 'asc')->get()
        ]);
    }

    /**
     * Admin: Send message
     */
    public function adminSendMessage(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'conversation_id' => 'required|exists:chat_conversations,id',
            'message' => 'required|string|max:1000'
        ]);

        $conversation = ChatConversation::findOrFail($request->conversation_id);

        // Create message
        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'sender_type' => 'admin',
            'message' => $request->message,
            'is_read' => false
        ]);

        // Update conversation
        $conversation->increment('unread_user_count');
        $conversation->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Admin: Close conversation
     */
    public function adminCloseConversation(Request $request, $conversationId)
    {
        if (!Auth::user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $conversation = ChatConversation::findOrFail($conversationId);
        $conversation->update(['status' => 'closed']);

        return response()->json([
            'success' => true,
            'message' => 'Conversation closed'
        ]);
    }
}
