<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') - Inspírate SENA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cards-enhanced.css') }}">
    @yield('styles')
    <script src="{{ asset('js/pdfjs/pdf.min.js') }}"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('js/pdfjs/pdf.worker.min.js') }}";
    </script>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('assets/logo.png') }}" alt="SENA">
            <span>Inspírate<br>SENA</span>
        </div>
        <nav class="sidebar-nav">
            @yield('sidebar-nav')
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(session('nombre', 'U'), 0, 1)) }}</div>
                <div class="user-details">
                    <div class="user-name">{{ session('nombre') }} {{ session('apellido') }}</div>
                    <div class="user-role">
                        @switch(session('rol'))
                            @case(1) Aprendiz @break
                            @case(2) Instructor @break
                            @case(3) Empresa @break
                            @case(4) Administrador @break
                        @endswitch
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Cerrar Sesión" style="background: hsla(0, 80%, 60%, 0.15); border:none; color:#ff4d4d; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor:pointer; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 4px 12px rgba(255, 77, 77, 0.15);">
                        <i class="fas fa-power-off" style="font-size: 16px;"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">
        <header class="topbar">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <span class="topbar-title">@yield('page-title', 'Principal')</span>
            <div class="topbar-right" style="display: flex; align-items: center; gap: 24px;">
                @php
                    $unreadCount = 0;
                    if(session()->has('usr_id')){
                        $usr = \App\Models\User::find(session('usr_id'));
                        if($usr) $unreadCount = $usr->unreadNotifications()->count();
                    }
                @endphp
                <a href="{{ route('notificaciones.index') }}" title="Notificaciones" style="position:relative; color:var(--text); text-decoration:none;">
                    <div style="width: 40px; height: 40px; background: #f8fafc; border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: all 0.3s; border: 1px solid var(--border);">
                        <i class="far fa-bell" style="font-size: 18px;"></i>
                    </div>
                    @if($unreadCount > 0)
                        <span style="position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; font-size: 10px; font-weight: 800; border-radius: 20px; padding: 2px 6px; border: 2px solid #fff;">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </a>

                <span style="font-size:13px; color: var(--text-light); font-weight: 600;">{{ now()->translatedFormat('d M, Y') }}</span>
            </div>
        </header>

        <div class="page-content">
            @yield('content')
        </div>
    </div>

    {{-- ── TOAST CONTAINER ──────────────────────────────────── --}}
    <div id="toast-container" style="position:fixed; bottom:28px; right:28px; z-index:9999; display:flex; flex-direction:column; gap:12px; pointer-events:none;"></div>

    {{-- ── CONFIRM MODAL ────────────────────────────────────── --}}
    <div id="confirm-modal" style="display:none; position:fixed; inset:0; z-index:10000; align-items:center; justify-content:center; background:rgba(0,0,0,0.45); backdrop-filter:blur(4px);">
        <div style="background:#fff; border-radius:24px; padding:40px 36px; max-width:420px; width:90%; box-shadow:0 24px 64px rgba(0,0,0,0.18); text-align:center;">
            <div style="width:60px; height:60px; border-radius:50%; background:#fff1f2; color:#ef4444; font-size:26px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
            <h3 id="confirm-title" style="font-size:20px; font-weight:800; color:#1e293b; margin-bottom:10px;">¿Estás seguro?</h3>
            <p id="confirm-msg" style="font-size:14px; color:#64748b; font-weight:500; margin-bottom:28px; line-height:1.6;">Esta acción no se puede deshacer.</p>
            <div style="display:flex; gap:12px; justify-content:center;">
                <button onclick="closeConfirm()" style="padding:12px 28px; border-radius:12px; border:1.5px solid #e2e8f0; background:#fff; color:#64748b; font-weight:700; font-size:14px; cursor:pointer;">Cancelar</button>
                <button id="confirm-ok" style="padding:12px 28px; border-radius:12px; border:none; background:#ef4444; color:#fff; font-weight:800; font-size:14px; cursor:pointer;">Confirmar</button>
            </div>
        </div>
    </div>

    <style>
    @keyframes slideInToast {
        from { opacity:0; transform:translateX(60px) scale(0.9); }
        to   { opacity:1; transform:translateX(0) scale(1); }
    }
    </style>

    <script>
    // ── TOAST ─────────────────────────────────────────────────────
    function showToast(type, message, title = null) {
        const icons   = { success:'fa-circle-check', error:'fa-circle-xmark', warning:'fa-triangle-exclamation' };
        const colors  = { success:'#22c55e', error:'#ef4444', warning:'#f59e0b' };
        const bgs     = { success:'#f0fdf4', error:'#fef2f2', warning:'#fffbeb' };
        const borders = { success:'#bbf7d0', error:'#fecaca', warning:'#fde68a' };
        const titles  = { success: '¡Éxito!', error: 'Error', warning: 'Atención' };
        const finalTitle = title || titles[type] || '';

        const toast = document.createElement('div');
        toast.style.cssText = `
            pointer-events:all; display:flex; align-items:flex-start; gap:14px;
            background:${bgs[type]}; color:#1e293b; border:1.5px solid ${borders[type]};
            border-left:4px solid ${colors[type]}; border-radius:16px;
            padding:16px 20px; min-width:300px; max-width:400px;
            box-shadow:0 8px 32px rgba(0,0,0,0.12);
            animation:slideInToast 0.4s cubic-bezier(0.34,1.56,0.64,1);
            font-family:'Outfit',sans-serif;
        `;
        
        // Sanitize message to prevent XSS
        const sanitize = (str) => {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        };
        
        toast.innerHTML = `
            <i class="fas ${icons[type]}" style="font-size:20px;color:${colors[type]};flex-shrink:0; margin-top: 2px;"></i>
            <div style="flex:1;">
                <div style="font-weight:800; font-size:14px; margin-bottom:2px;">${finalTitle}</div>
                <div style="font-size:13px; color:#475569; line-height: 1.4;">${sanitize(message)}</div>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:16px;padding:0;"><i class="fas fa-xmark"></i></button>
        `;
        document.getElementById('toast-container').appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.4s';
            setTimeout(() => toast.remove(), 400);
        }, 4500);
    }

    // ── AUTO FLASH ────────────────────────────────────────────────
    @if(session('success')) showToast('success', "{{ addslashes(session('success')) }}"); @endif
    @if(session('error'))   showToast('error',   "{{ addslashes(session('error')) }}"); @endif
    @if(session('warning')) showToast('warning', "{{ addslashes(session('warning')) }}"); @endif
    @if($errors->any()) @foreach($errors->all() as $e) showToast('error', "{{ addslashes($e) }}"); @endforeach @endif

    // ── CONFIRM MODAL ─────────────────────────────────────────────
    function openConfirm(title, msg, cb) {
        document.getElementById('confirm-title').textContent = title || '¿Estás seguro?';
        document.getElementById('confirm-msg').textContent   = msg   || 'Esta acción no se puede deshacer.';
        document.getElementById('confirm-ok').onclick = () => { closeConfirm(); if (cb) cb(); };
        document.getElementById('confirm-modal').style.display = 'flex';
    }
    function closeConfirm() {
        document.getElementById('confirm-modal').style.display = 'none';
    }

    // Auto-wire [data-confirm] buttons
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-confirm]').forEach(btn => {
            const title = btn.dataset.confirmTitle || '¿Confirmar acción?';
            const msg   = btn.dataset.confirm;
            const form  = btn.closest('form');
            btn.addEventListener('click', e => {
                e.preventDefault();
                openConfirm(title, msg, () => { form ? form.submit() : btn.click(); });
            });
        });
    });

    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('open');
    }
    </script>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    @yield('scripts')
</body>
</html>
