@extends('layouts.admin')

@section('title', __('Live Chat'))
@section('page-title', __('Live Chat Support'))

@section('content')
<style>
    .chat-admin-container {
        display: flex;
        height: calc(100vh - 200px);
        min-height: 600px;
        gap: 20px;
    }

    .conversations-panel {
        flex: 0 0 350px;
        display: flex;
        flex-direction: column;
    }

    .chat-panel {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .conversations-list {
        flex: 1;
        overflow-y: auto;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .conversation-item {
        padding: 16px;
        border-bottom: 1px solid #e2e8f0;
        cursor: pointer;
        transition: background 0.2s;
        position: relative;
    }

    .conversation-item:hover {
        background: #f8f9fa;
    }

    .conversation-item.active {
        background: #667eea;
        color: white;
    }

    .conversation-item.active .conversation-name,
    .conversation-item.active .conversation-email,
    .conversation-item.active .conversation-time {
        color: white !important;
    }

    .conversation-name {
        font-weight: 600;
        margin-bottom: 4px;
        color: #2d3748;
    }

    .conversation-email {
        font-size: 13px;
        color: #8b95a5;
        margin-bottom: 4px;
    }

    .conversation-preview {
        font-size: 13px;
        color: #64748b;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .conversation-time {
        position: absolute;
        top: 16px;
        right: 16px;
        font-size: 12px;
        color: #8b95a5;
    }

    .conversation-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        width: 8px;
        height: 8px;
        background: #ff4757;
        border-radius: 50%;
    }

    .conversation-unread {
        padding-left: 24px;
    }

    .chat-messages-container {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
    }

    .chat-message-admin {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
    }

    .chat-message-admin.user {
        flex-direction: row-reverse;
    }

    .chat-message-bubble-admin {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 14px;
        line-height: 1.5;
    }

    .chat-message-admin.user .chat-message-bubble-admin {
        background: #667eea;
        color: white;
        border-bottom-right-radius: 4px;
    }

    .chat-message-admin.admin .chat-message-bubble-admin {
        background: white;
        color: #2d3748;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .chat-message-time-admin {
        font-size: 11px;
        color: #8b95a5;
        margin-top: 4px;
    }

    .chat-input-container {
        padding: 16px;
        background: white;
        border-top: 1px solid #e2e8f0;
    }

    .chat-input-row {
        display: flex;
        gap: 12px;
    }

    .chat-input-admin {
        flex: 1;
        border: 2px solid #e2e8f0;
        border-radius: 24px;
        padding: 10px 16px;
        font-size: 14px;
        outline: none;
    }

    .chat-input-admin:focus {
        border-color: #667eea;
    }

    .chat-send-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 10px 24px;
        border-radius: 24px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .chat-send-btn:hover {
        transform: scale(1.05);
    }

    .chat-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #8b95a5;
        text-align: center;
        padding: 40px;
    }

    .chat-empty-state svg {
        width: 80px;
        height: 80px;
        opacity: 0.3;
        margin-bottom: 20px;
    }

    .conversation-actions {
        margin-top: 12px;
    }

    .btn-close-conversation {
        font-size: 12px;
        padding: 4px 12px;
    }
</style>

<div class="chat-admin-container">
    <!-- Conversations List -->
    <div class="conversations-panel">
        <div class="card mb-0" style="flex: 1; display: flex; flex-direction: column;">
            <div class="card-status bg-blue"></div>
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fe fe-message-square mr-2"></i> Active Conversations
                </h3>
            </div>
            <div class="card-body p-0" style="flex: 1; overflow: hidden;">
                <ul class="conversations-list" id="conversationsList">
                    <li class="conversation-item">
                        <div class="chat-empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            <p>Loading conversations...</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="chat-panel">
        <div class="card mb-0" style="flex: 1; display: flex; flex-direction: column;">
            <div class="card-status bg-green"></div>
            <div class="card-header">
                <h3 class="card-title" id="chatTitle">
                    <i class="fe fe-message-circle mr-2"></i> Select a conversation
                </h3>
                <div class="card-options" id="chatActions" style="display: none;">
                    <button class="btn btn-sm btn-danger btn-close-conversation" id="closeConversationBtn">
                        <i class="fe fe-x mr-1"></i> Close Conversation
                    </button>
                </div>
            </div>
            <div class="card-body p-0" style="flex: 1; overflow: hidden; display: flex; flex-direction: column;">
                <div class="chat-messages-container" id="chatMessagesContainer">
                    <div class="chat-empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <h4>No conversation selected</h4>
                        <p>Select a conversation from the list to start chatting</p>
                    </div>
                </div>
                <div class="chat-input-container" id="chatInputContainer" style="display: none;">
                    <form id="adminChatForm">
                        <div class="chat-input-row">
                            <input type="text" class="chat-input-admin" id="adminChatInput" placeholder="Type your message..." autocomplete="off" maxlength="1000">
                            <button type="submit" class="chat-send-btn">
                                <i class="fe fe-send mr-1"></i> Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script>
class AdminChat {
    constructor() {
        this.conversations = [];
        this.currentConversationId = null;
        this.lastMessageId = 0;
        this.pollInterval = null;

        this.init();
    }

    init() {
        this.loadConversations();
        this.attachEventListeners();

        // Poll for new conversations and messages every 5 seconds
        this.pollInterval = setInterval(() => {
            this.loadConversations();
            if (this.currentConversationId) {
                this.loadMessages(this.currentConversationId);
            }
        }, 5000);
    }

    attachEventListeners() {
        document.getElementById('adminChatForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.sendMessage();
        });

        document.getElementById('closeConversationBtn').addEventListener('click', () => {
            this.closeConversation();
        });
    }

    async loadConversations() {
        try {
            const response = await fetch('/settings/chat/conversations', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                this.conversations = data.conversations;
                this.renderConversations();
            }
        } catch (error) {
            console.error('Load conversations error:', error);
        }
    }

    renderConversations() {
        const container = document.getElementById('conversationsList');

        if (this.conversations.length === 0) {
            container.innerHTML = `
                <li class="conversation-item">
                    <div class="chat-empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 60px; height: 60px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <p>No active conversations</p>
                    </div>
                </li>
            `;
            return;
        }

        container.innerHTML = this.conversations.map(conv => {
            const hasUnread = conv.unread_admin_count > 0;
            const isActive = conv.id === this.currentConversationId;
            const lastMessage = conv.latest_message?.message || 'No messages yet';
            const time = conv.last_message_at ? this.formatTime(conv.last_message_at) : '';

            return `
                <li class="conversation-item ${hasUnread ? 'conversation-unread' : ''} ${isActive ? 'active' : ''}"
                    data-id="${conv.id}"
                    onclick="adminChat.selectConversation(${conv.id})">
                    ${hasUnread ? '<span class="conversation-badge"></span>' : ''}
                    <div class="conversation-name">${this.escapeHtml(conv.user_name)}</div>
                    <div class="conversation-email">${this.escapeHtml(conv.user_email)}</div>
                    <div class="conversation-preview">${this.escapeHtml(lastMessage)}</div>
                    <div class="conversation-time">${time}</div>
                </li>
            `;
        }).join('');
    }

    async selectConversation(conversationId) {
        this.currentConversationId = conversationId;
        this.lastMessageId = 0;

        const conversation = this.conversations.find(c => c.id === conversationId);
        if (conversation) {
            document.getElementById('chatTitle').innerHTML = `
                <i class="fe fe-message-circle mr-2"></i> ${this.escapeHtml(conversation.user_name)}
                <small class="ml-2" style="color: #8b95a5;">${this.escapeHtml(conversation.user_email)}</small>
            `;
        }

        document.getElementById('chatActions').style.display = 'block';
        document.getElementById('chatInputContainer').style.display = 'block';

        this.renderConversations(); // Update active state
        await this.loadMessages(conversationId);
    }

    async loadMessages(conversationId) {
        try {
            const response = await fetch(`/settings/chat/conversations/${conversationId}/messages`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                this.renderMessages(data.messages);
            }
        } catch (error) {
            console.error('Load messages error:', error);
        }
    }

    renderMessages(messages) {
        const container = document.getElementById('chatMessagesContainer');

        if (messages.length === 0) {
            container.innerHTML = `
                <div class="chat-empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p>No messages yet</p>
                </div>
            `;
            return;
        }

        container.innerHTML = messages.map(msg => {
            const time = this.formatTime(msg.created_at);
            return `
                <div class="chat-message-admin ${msg.sender_type}">
                    <div>
                        <div class="chat-message-bubble-admin">${this.escapeHtml(msg.message)}</div>
                        <div class="chat-message-time-admin">${time}</div>
                    </div>
                </div>
            `;
        }).join('');

        this.scrollToBottom();

        if (messages.length > 0) {
            this.lastMessageId = Math.max(...messages.map(m => m.id));
        }
    }

    async sendMessage() {
        if (!this.currentConversationId) return;

        const input = document.getElementById('adminChatInput');
        const message = input.value.trim();

        if (!message) return;

        try {
            const response = await fetch('/settings/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    conversation_id: this.currentConversationId,
                    message: message
                })
            });

            const data = await response.json();

            if (data.success) {
                input.value = '';
                await this.loadMessages(this.currentConversationId);
                await this.loadConversations(); // Refresh conversation list
            }
        } catch (error) {
            console.error('Send message error:', error);
            alert('Failed to send message. Please try again.');
        }
    }

    async closeConversation() {
        if (!this.currentConversationId) return;

        if (!confirm('Are you sure you want to close this conversation?')) {
            return;
        }

        try {
            const response = await fetch(`/settings/chat/conversations/${this.currentConversationId}/close`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                this.currentConversationId = null;
                this.lastMessageId = 0;
                document.getElementById('chatTitle').innerHTML = '<i class="fe fe-message-circle mr-2"></i> Select a conversation';
                document.getElementById('chatActions').style.display = 'none';
                document.getElementById('chatInputContainer').style.display = 'none';
                document.getElementById('chatMessagesContainer').innerHTML = `
                    <div class="chat-empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <h4>Conversation closed</h4>
                        <p>This conversation has been closed</p>
                    </div>
                `;
                await this.loadConversations();
            }
        } catch (error) {
            console.error('Close conversation error:', error);
            alert('Failed to close conversation. Please try again.');
        }
    }

    scrollToBottom() {
        const container = document.getElementById('chatMessagesContainer');
        container.scrollTop = container.scrollHeight;
    }

    formatTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const isToday = date.toDateString() === now.toDateString();

        const timeStr = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        if (isToday) {
            return timeStr;
        } else {
            return `${date.toLocaleDateString([], { month: 'short', day: 'numeric' })} ${timeStr}`;
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    destroy() {
        if (this.pollInterval) {
            clearInterval(this.pollInterval);
        }
    }
}

// Initialize admin chat
let adminChat;
document.addEventListener('DOMContentLoaded', function() {
    adminChat = new AdminChat();
});
</script>
@endpush
