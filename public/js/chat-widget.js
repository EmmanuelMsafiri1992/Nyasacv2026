/**
 * Live Chat Widget
 * Handles user chat functionality with admin support
 */

class ChatWidget {
    constructor() {
        this.conversationId = null;
        this.lastMessageId = 0;
        this.pollInterval = null;
        this.isOpen = false;
        this.unreadCount = 0;
        this.requiresVerification = false;
        this.isAuthenticated = window.isAuthenticated || false;

        this.init();
    }

    init() {
        this.createWidget();
        this.attachEventListeners();

        // Initialize conversation when widget is first opened
        document.querySelector('.chat-toggle-button').addEventListener('click', () => {
            if (!this.isAuthenticated) {
                // Don't init conversation, will show login prompt
                return;
            }
            if (!this.isOpen && !this.conversationId && !this.requiresVerification) {
                this.initConversation();
            }
        });
    }

    createWidget() {
        const widget = document.createElement('div');
        widget.className = 'chat-widget';
        widget.innerHTML = `
            <button class="chat-toggle-button" aria-label="Toggle chat">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <span class="chat-unread-badge" style="display: none;">0</span>
            </button>

            <div class="chat-window">
                <div class="chat-header">
                    <div>
                        <h4>Live Chat Support</h4>
                        <div class="chat-header-info">We typically reply within minutes</div>
                    </div>
                    <button class="chat-close-button" aria-label="Close chat">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="chat-messages" id="chatMessages">
                    <div class="chat-loading">
                        <div class="chat-loading-spinner"></div>
                    </div>
                </div>

                <div class="chat-input-wrapper">
                    <form class="chat-input-form" id="chatForm">
                        <input type="text" class="chat-input" id="chatInput" placeholder="Type your message..." autocomplete="off" maxlength="1000">
                        <button type="submit" class="chat-send-button" id="chatSendButton">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        `;

        document.body.appendChild(widget);
    }

    attachEventListeners() {
        // Toggle chat window
        document.querySelector('.chat-toggle-button').addEventListener('click', () => {
            this.toggleChat();
        });

        // Close chat
        document.querySelector('.chat-close-button').addEventListener('click', () => {
            this.closeChat();
        });

        // Send message
        document.getElementById('chatForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.sendMessage();
        });
    }

    toggleChat() {
        this.isOpen = !this.isOpen;
        const chatWindow = document.querySelector('.chat-window');
        chatWindow.classList.toggle('active');

        if (this.isOpen) {
            if (!this.isAuthenticated) {
                this.showLoginPrompt();
            } else {
                document.getElementById('chatInput').focus();
                this.unreadCount = 0;
                this.updateUnreadBadge();
            }
        }
    }

    showLoginPrompt() {
        const container = document.getElementById('chatMessages');
        const loginUrl = window.loginUrl || '/login';
        container.innerHTML = `
            <div class="chat-verification-notice">
                <h4>Login Required</h4>
                <p>Please log in to use live chat support.</p>
                <a href="${loginUrl}" class="btn">Login to Chat</a>
            </div>
        `;
        // Hide input form for non-authenticated users
        document.querySelector('.chat-input-wrapper').style.display = 'none';
    }

    closeChat() {
        this.isOpen = false;
        document.querySelector('.chat-window').classList.remove('active');
    }

    async initConversation() {
        try {
            const response = await fetch('/chat/init', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.requires_verification) {
                this.requiresVerification = true;
                this.showVerificationNotice(data.message);
                return;
            }

            if (data.success) {
                this.conversationId = data.conversation_id;
                this.renderMessages(data.messages);
                this.startPolling();
            } else {
                this.showError(data.message || 'Failed to initialize chat');
            }
        } catch (error) {
            console.error('Chat initialization error:', error);
            this.showError('Failed to connect to chat. Please try again.');
        }
    }

    async sendMessage() {
        const input = document.getElementById('chatInput');
        const message = input.value.trim();

        if (!message || !this.conversationId) {
            return;
        }

        const sendButton = document.getElementById('chatSendButton');
        sendButton.disabled = true;

        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    conversation_id: this.conversationId,
                    message: message
                })
            });

            const data = await response.json();

            if (data.success) {
                input.value = '';
                this.addMessage(data.message);
                this.lastMessageId = Math.max(this.lastMessageId, data.message.id);
            } else {
                this.showError(data.message || 'Failed to send message');
            }
        } catch (error) {
            console.error('Send message error:', error);
            this.showError('Failed to send message. Please try again.');
        } finally {
            sendButton.disabled = false;
            input.focus();
        }
    }

    async pollMessages() {
        if (!this.conversationId) {
            return;
        }

        try {
            const response = await fetch(`/chat/${this.conversationId}/messages?last_message_id=${this.lastMessageId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success && data.messages.length > 0) {
                data.messages.forEach(message => {
                    this.addMessage(message);
                    this.lastMessageId = Math.max(this.lastMessageId, message.id);

                    // Show unread badge if chat is closed
                    if (!this.isOpen && message.sender_type === 'admin') {
                        this.unreadCount++;
                        this.updateUnreadBadge();
                    }
                });
            }
        } catch (error) {
            console.error('Poll messages error:', error);
        }
    }

    startPolling() {
        // Poll every 3 seconds
        this.pollInterval = setInterval(() => {
            this.pollMessages();
        }, 3000);
    }

    stopPolling() {
        if (this.pollInterval) {
            clearInterval(this.pollInterval);
            this.pollInterval = null;
        }
    }

    renderMessages(messages) {
        const container = document.getElementById('chatMessages');

        if (messages.length === 0) {
            container.innerHTML = `
                <div class="chat-empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <p>No messages yet. Start a conversation!</p>
                </div>
            `;
            return;
        }

        container.innerHTML = '';
        messages.forEach(message => {
            this.addMessage(message, false);
            this.lastMessageId = Math.max(this.lastMessageId, message.id);
        });

        this.scrollToBottom();
    }

    addMessage(message, scroll = true) {
        const container = document.getElementById('chatMessages');

        // Remove empty state if exists
        const emptyState = container.querySelector('.chat-empty-state');
        if (emptyState) {
            emptyState.remove();
        }

        const messageEl = document.createElement('div');
        messageEl.className = `chat-message ${message.sender_type}`;

        const time = this.formatTime(message.created_at);

        messageEl.innerHTML = `
            <div>
                <div class="chat-message-bubble">${this.escapeHtml(message.message)}</div>
                <div class="chat-message-time">${time}</div>
            </div>
        `;

        container.appendChild(messageEl);

        if (scroll) {
            this.scrollToBottom();
        }
    }

    showVerificationNotice(message) {
        const container = document.getElementById('chatMessages');
        container.innerHTML = `
            <div class="chat-verification-notice">
                <h4>Email Verification Required</h4>
                <p>${message}</p>
                <a href="/email/verify" class="btn">Verify Email Address</a>
            </div>
        `;
    }

    showError(message) {
        const container = document.getElementById('chatMessages');
        container.innerHTML = `
            <div class="chat-empty-state">
                <p style="color: #ff4757;">${message}</p>
            </div>
        `;
    }

    updateUnreadBadge() {
        const badge = document.querySelector('.chat-unread-badge');
        if (this.unreadCount > 0) {
            badge.textContent = this.unreadCount > 9 ? '9+' : this.unreadCount;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    scrollToBottom() {
        const container = document.getElementById('chatMessages');
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
        this.stopPolling();
        const widget = document.querySelector('.chat-widget');
        if (widget) {
            widget.remove();
        }
    }
}

// Initialize chat widget when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Always initialize the widget (it will handle authentication internally)
    if (document.querySelector('meta[name="csrf-token"]')) {
        window.chatWidget = new ChatWidget();
    }
});
