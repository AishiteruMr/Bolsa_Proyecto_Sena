const CHAT_STORAGE_KEY = 'chat_active_conv';

document.addEventListener('DOMContentLoaded', () => {
    const usrId = window.Laravel?.user?.id;
    const userName = window.Laravel?.user?.nombre || '';
    if (!usrId) return;

    const echoAvailable = typeof window.Echo !== 'undefined';

    const chatForm = document.getElementById('chatForm');
    const msgContainer = document.getElementById('chatMessages');
    const msgInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const convId = chatForm?.dataset?.conversationId;

    if (chatForm && convId && msgContainer) {
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        let loadingMore = false;
        let nextPageUrl = loadMoreBtn?.dataset?.nextUrl || null;

        msgContainer.scrollTop = msgContainer.scrollHeight;

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', async () => {
                if (loadingMore || !nextPageUrl) return;
                loadingMore = true;
                loadMoreBtn.disabled = true;
                loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...';

                try {
                    const res = await fetch(nextPageUrl);
                    const html = await res.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const olderMsgs = doc.getElementById('chatMessages');
                    const olderBtn = doc.getElementById('loadMoreBtn');

                    if (olderMsgs) {
                        const scrollHeightBefore = msgContainer.scrollHeight;
                        const msgs = olderMsgs.querySelectorAll('.chat-msg');
                        msgs.forEach(m => {
                            msgContainer.insertBefore(m, msgContainer.firstChild);
                        });
                        msgContainer.scrollTop = msgContainer.scrollHeight - scrollHeightBefore;
                    }

                    if (olderBtn?.dataset?.nextUrl) {
                        nextPageUrl = olderBtn.dataset.nextUrl;
                        loadMoreBtn.style.display = 'flex';
                    } else {
                        nextPageUrl = null;
                        loadMoreBtn.style.display = 'none';
                    }
                } catch (e) {
                    console.warn('Error loading more messages', e);
                }

                loadingMore = false;
                loadMoreBtn.disabled = false;
                loadMoreBtn.innerHTML = '<i class="fas fa-chevron-up"></i> Cargar mensajes anteriores';
            });
        }

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const msg = msgInput.value.trim();
            if (!msg || sendBtn.disabled) return;

            sendBtn.disabled = true;
            const submitBtnHtml = sendBtn.innerHTML;
            sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            try {
                const res = await fetch(chatForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(chatForm),
                });

                if (!res.ok) throw new Error('Send failed');

                const data = await res.json();
                appendOwnMessage(data, usrId);
                msgInput.value = '';
                msgInput.style.height = 'auto';
                msgContainer.scrollTop = msgContainer.scrollHeight;

                updateSidebarConv(convId, data.message, data.created_at);
            } catch (err) {
                console.warn('Error sending message', err);
                showChatToast('error', 'Error al enviar mensaje');
            }

            sendBtn.disabled = false;
            sendBtn.innerHTML = submitBtnHtml;
        });

        msgInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (typeof chatForm.requestSubmit === 'function') {
                    chatForm.requestSubmit();
                } else {
                    chatForm.dispatchEvent(new Event('submit'));
                }
            }
        });

        msgInput.addEventListener('input', () => {
            msgInput.style.height = 'auto';
            msgInput.style.height = msgInput.scrollHeight + 'px';
        });

        if (echoAvailable) {
            window.Echo.private('conversation.' + convId)
                .listen('.message.sent', (data) => {
                    if (data.sender && data.sender.id !== usrId) {
                        appendReceivedMessage(data);
                        msgContainer.scrollTop = msgContainer.scrollHeight;
                        markConversationRead(convId);
                        updateSidebarConv(convId, data.message, data.created_at);
                        updateGlobalBadge();
                        updateSentMessageReadStatus(data.conversation_id, data.id);
                    }
                })
                .listen('.typing', (data) => {
                    const indicator = document.getElementById('typingIndicator');
                    const typingName = document.getElementById('typingName');
                    if (data.sender && data.sender.id !== usrId) {
                        if (indicator) indicator.style.display = 'flex';
                        if (typingName && data.sender.name) {
                            typingName.textContent = data.sender.name + ' ';
                        }
                        clearTimeout(window._typingTimeout);
                        window._typingTimeout = setTimeout(() => {
                            if (indicator) indicator.style.display = 'none';
                        }, 2500);
                    }
                });

            let typingLastSent = 0;
            const TYPING_INTERVAL = 2000;
            msgInput.addEventListener('input', () => {
                const now = Date.now();
                if (now - typingLastSent > TYPING_INTERVAL) {
                    typingLastSent = now;
                    window.Echo.private('conversation.' + convId)
                        .whisper('typing', { sender: { id: usrId, name: userName } });
                }
            });
        }

        const emptyState = msgContainer.querySelector('.chat-empty-state');
        if (emptyState) emptyState.remove();

        let lastMessageId = 0;
        const existingMsgs = msgContainer.querySelectorAll('.chat-msg');
        if (existingMsgs.length > 0) {
            lastMessageId = parseInt(existingMsgs[existingMsgs.length - 1].dataset.id) || 0;
        }

        setInterval(async () => {
            if (!convId) return;
            try {
                const res = await fetch(`/chat/${convId}/poll?after_id=${lastMessageId}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) return;
                const messages = await res.json();
                if (!messages || messages.length === 0) return;

                let hasNew = false;
                messages.forEach(data => {
                    if (document.querySelector(`.chat-msg[data-id="${data.id}"]`)) return;
                    if (data.sender.id === usrId) {
                        appendOwnMessage(data, usrId);
                        updateSentMessageReadStatus(data.conversation_id, data.id);
                    } else {
                        appendReceivedMessage(data);
                        markConversationRead(convId);
                    }
                    lastMessageId = Math.max(lastMessageId, data.id);
                    hasNew = true;
                });

                if (hasNew) {
                    msgContainer.scrollTop = msgContainer.scrollHeight;
                    updateSidebarConv(convId, messages[messages.length - 1].message, messages[messages.length - 1].created_at);
                    updateGlobalBadge();
                }
            } catch (e) {}
        }, 5000);
    }

    function updateGlobalBadge() {
        fetch('/chat/unread/count')
            .then(r => r.json())
            .then(data => {
                const navItems = document.querySelectorAll('.nav-item i.fa-comment-dots');
                navItems.forEach(icon => {
                    const parent = icon.closest('.nav-item');
                    if (!parent) return;
                    let badge = parent.querySelector('.nav-badge');
                    if (data.unread > 0) {
                        if (!badge) {
                            badge = document.createElement('span');
                            badge.className = 'nav-badge';
                            parent.appendChild(badge);
                        }
                        badge.textContent = data.unread > 99 ? '99+' : data.unread;
                    } else {
                        if (badge) badge.remove();
                    }
                });
            })
            .catch(() => {});
    }

    setInterval(updateGlobalBadge, 15000);

    if (!chatForm && echoAvailable && usrId) {
        fetch('/chat/unread/count')
            .then(r => r.json())
            .then(data => {
                if (data.unread > 0) updateGlobalBadge();
            })
            .catch(() => {});
    }

    function appendOwnMessage(data, usrId) {
        const div = document.createElement('div');
        div.className = 'chat-msg sent';
        div.dataset.id = data.id;
        div.dataset.convId = data.conversation_id;
        div.innerHTML = `
            <div>${escapeHtml(data.message).replace(/\n/g, '<br>')}</div>
            <span class="chat-msg-time">
                ${data.created_at}
                <i class="fas fa-check read-status" style="margin-left:4px;font-size:10px;"></i>
            </span>
        `;
        msgContainer.appendChild(div);
    }

    function appendReceivedMessage(data) {
        const div = document.createElement('div');
        div.className = 'chat-msg received';
        div.dataset.id = data.id;
        div.dataset.convId = data.conversation_id;
        const time = data.created_at || (data.created_at_iso ? new Date(data.created_at_iso).toLocaleTimeString('es-CO', { hour: '2-digit', minute: '2-digit' }) : '');
        const senderName = data.sender.name || data.sender.rol || 'Usuario';
        const senderRole = data.sender.rol ? `<span style="font-weight:600;font-size:10px;color:var(--text-lighter);margin-left:4px;">(${escapeHtml(data.sender.rol)})</span>` : '';
        div.innerHTML = `
            <div style="font-size:11px;font-weight:700;color:#3eb489;margin-bottom:4px;">${escapeHtml(senderName)} ${senderRole}</div>
            <div>${escapeHtml(data.message).replace(/\n/g, '<br>')}</div>
            <span class="chat-msg-time">${time}</span>
        `;
        msgContainer.appendChild(div);
    }

    function markConversationRead(convId) {
        fetch(`/chat/${convId}/read`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        }).catch(() => {});
    }

    function updateSentMessageReadStatus(convId, msgId) {
        const msgEl = document.querySelector(`.chat-msg[data-id="${msgId}"] .read-status`);
        if (msgEl) {
            msgEl.className = 'fas fa-check-double read-status';
            msgEl.style.marginLeft = '4px';
            msgEl.style.fontSize = '10px';
        }
    }

    function updateSidebarConv(convId, message, time) {
        const sidebarItem = document.querySelector(`.chat-conv-item[data-conv-id="${convId}"]`);
        if (!sidebarItem) return;

        const preview = sidebarItem.querySelector('.chat-conv-preview');
        const timeEl = sidebarItem.querySelector('.chat-conv-time');
        const badge = sidebarItem.querySelector('.chat-conv-badge');
        if (preview) preview.textContent = message.length > 40 ? message.substring(0, 40) + '...' : message;
        if (timeEl) timeEl.textContent = time;
        if (badge) badge.remove();

        const parent = sidebarItem.parentElement;
        if (parent) {
            parent.insertBefore(sidebarItem, parent.firstChild);
        }
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function showChatToast(type, message) {
        if (typeof window.showToast === 'function') {
            window.showToast(type, message);
        }
    }
});
