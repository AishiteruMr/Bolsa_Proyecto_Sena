import axios from 'axios';

window.ajax = {
    post(url, data = {}, options = {}) {
        return axios.post(url, data, {
            headers: { 'Accept': 'application/json', ...options.headers },
            ...options
        });
    },

    put(url, data = {}, options = {}) {
        return axios.put(url, data, {
            headers: { 'Accept': 'application/json', ...options.headers },
            ...options
        });
    },

    del(url, options = {}) {
        return axios.delete(url, {
            headers: { 'Accept': 'application/json', ...options.headers },
            ...options
        });
    },

    get(url, params = {}, options = {}) {
        return axios.get(url, { params, ...options });
    },

    formPost(url, formData, options = {}) {
        return axios.post(url, formData, {
            headers: { 'Accept': 'application/json', 'Content-Type': 'multipart/form-data', ...options.headers },
            ...options
        });
    },

    showToast(type, message) {
        const container = document.getElementById('toast-container') || this.createToastContainer();
        const bgColor = type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6';
        const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-times-circle' : 'fa-info-circle';

        const toast = document.createElement('div');
        toast.style.cssText = `
            display:flex; align-items:center; gap:12px; background:white; border-radius:12px;
            padding:16px 20px; box-shadow:0 10px 40px rgba(0,0,0,0.15);
            border-left:4px solid ${bgColor}; min-width:320px; max-width:400px;
            transform:translateX(100%); opacity:0; transition:all 0.3s ease;
        `;
        toast.innerHTML = `
            <div style="width:36px;height:36px;border-radius:50%;background:${bgColor}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas ${icon}" style="color:${bgColor};font-size:14px;"></i>
            </div>
            <div style="flex:1;font-size:13px;font-weight:600;color:#1e293b;">${message}</div>
            <button onclick="this.parentElement.remove()" style="background:none;border:none;color:#94a3b8;cursor:pointer;padding:4px;">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(toast);
        requestAnimationFrame(() => { toast.style.transform = 'translateX(0)'; toast.style.opacity = '1'; });
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)'; toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    },

    createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.style.cssText = 'position:fixed;top:20px;right:20px;z-index:99999;display:flex;flex-direction:column;gap:10px;';
        document.body.appendChild(container);
        return container;
    },

    confirm(message) {
        return new Promise((resolve) => {
            const existing = document.querySelector('.ajax-confirm-overlay');
            if (existing) existing.remove();

            const overlay = document.createElement('div');
            overlay.className = 'ajax-confirm-overlay';
            overlay.style.cssText = `
                position:fixed;inset:0;z-index:100000;background:rgba(0,0,0,0.45);backdrop-filter:blur(4px);
                display:flex;align-items:center;justify-content:center;animation:fadeIn 0.2s ease;
            `;
            overlay.innerHTML = `
                <div style="background:white;border-radius:20px;padding:32px;max-width:400px;width:90%;text-align:center;box-shadow:0 24px 64px rgba(0,0,0,0.18);">
                    <div style="width:56px;height:56px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <i class="fas fa-exclamation-triangle" style="color:#ef4444;font-size:24px;"></i>
                    </div>
                    <h3 style="font-size:18px;font-weight:800;color:#1e293b;margin-bottom:8px;">${message}</h3>
                    <div style="display:flex;gap:12px;justify-content:center;margin-top:24px;">
                        <button class="cancel-btn" style="padding:10px 24px;border-radius:12px;border:1.5px solid #e2e8f0;background:white;color:#64748b;font-weight:700;cursor:pointer;">Cancelar</button>
                        <button class="confirm-btn" style="padding:10px 24px;border-radius:12px;border:none;background:#ef4444;color:white;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(239,68,68,0.3);">Confirmar</button>
                    </div>
                </div>
            `;
            document.body.appendChild(overlay);

            overlay.querySelector('.cancel-btn').onclick = () => { overlay.remove(); resolve(false); };
            overlay.querySelector('.confirm-btn').onclick = () => { overlay.remove(); resolve(true); };
            overlay.onclick = (e) => { if (e.target === overlay) { overlay.remove(); resolve(false); } };
        });
    },

    disableButton(btn, text = 'Procesando...') {
        if (!btn) return;
        btn._originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${text}`;
    },

    enableButton(btn) {
        if (!btn || !btn._originalHtml) return;
        btn.disabled = false;
        btn.innerHTML = btn._originalHtml;
    }
};
