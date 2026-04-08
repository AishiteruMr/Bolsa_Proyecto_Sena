/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

window.addNotificationToast = function(data) {
    const container = document.getElementById('toast-container') || createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = 'notification-toast';
    toast.innerHTML = `
        <div class="toast-icon"><i class="fas ${data.icon || 'fa-bell'}"></i></div>
        <div class="toast-content">
            <div class="toast-title">${data.titulo}</div>
            <div class="toast-message">${data.mensaje}</div>
        </div>
        <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
};

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.innerHTML = `
        <style>
            #toast-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 99999;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            .notification-toast {
                display: flex;
                align-items: center;
                gap: 12px;
                background: white;
                border-radius: 12px;
                padding: 16px 20px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                border-left: 4px solid var(--primary, #3eb489);
                min-width: 320px;
                max-width: 400px;
                transform: translateX(100%);
                opacity: 0;
                transition: all 0.3s ease;
            }
            .notification-toast.show {
                transform: translateX(0);
                opacity: 1;
            }
            .toast-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: linear-gradient(135deg, #3eb489, #2d9a75);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.1rem;
            }
            .toast-content {
                flex: 1;
            }
            .toast-title {
                font-weight: 700;
                font-size: 14px;
                color: #1a1a2e;
            }
            .toast-message {
                font-size: 12px;
                color: #6b7280;
                margin-top: 2px;
            }
            .toast-close {
                background: none;
                border: none;
                color: #9ca3af;
                cursor: pointer;
                padding: 4px;
                transition: color 0.2s;
            }
            .toast-close:hover {
                color: #374151;
            }
        </style>
    `;
    document.body.appendChild(container);
    return container;
}

if (typeof window.Echo !== 'undefined' && window.Laravel && window.Laravel.user) {
    window.Echo.private('user.' + window.Laravel.user.id)
        .listen('.notificacion', (data) => {
            window.addNotificationToast(data);
            
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                const count = parseInt(badge.textContent || '0') + 1;
                badge.textContent = count;
                badge.style.display = 'flex';
            }
        });
}
