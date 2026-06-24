@extends('layouts.dashboard')

@section('title', 'Mensajes - Inspírate SENA')
@section('page-title', 'Bandeja de Mensajes')

@section('sidebar-nav')
    @switch(session('rol'))
        @case(1)
            <span class="nav-label">Principal</span>
            <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> <span>Principal</span>
            </a>
            <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i> <span>Explorar Proyectos</span>
            </a>
            <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
                <i class="fas fa-paper-plane"></i> <span>Mis Postulaciones</span>
            </a>
            <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
                <i class="fas fa-history"></i> <span>Historial</span>
            </a>
            <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i> <span>Mis Entregas</span>
            </a>
            <span class="nav-label">Comunicación</span>
            <a href="{{ route('chat.index') }}" class="nav-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                <i class="fas fa-comment-dots"></i> Mensajes
                @php
                    $chatUnread = \App\Models\Conversation::whereHas('users', fn($q) => $q->where('user_id', session('usr_id')))
                        ->get()->sum(fn($c) => $c->unreadMessagesCount(session('usr_id')));
                @endphp
                @if($chatUnread > 0)
                    <span class="nav-badge">{{ $chatUnread > 99 ? '99+' : $chatUnread }}</span>
                @endif
            </a>
            <span class="nav-label">Cuenta</span>
            <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
                <i class="fas fa-user"></i> <span>Mi Perfil</span>
            </a>
            @break
        @case(2)
            <span class="nav-label">Principal</span>
            <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Principal
            </a>
            <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos') ? 'active' : '' }}">
                <i class="fas fa-project-diagram"></i> Mis Proyectos
            </a>
            <a href="{{ route('instructor.historial') }}" class="nav-item {{ request()->routeIs('instructor.historial') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Historial
            </a>
            <a href="{{ route('instructor.aprendices') }}" class="nav-item {{ request()->routeIs('instructor.aprendices') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Aprendices
            </a>
            <span class="nav-label">Comunicación</span>
            <a href="{{ route('chat.index') }}" class="nav-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                <i class="fas fa-comment-dots"></i> Mensajes
                @php
                    $chatUnread = \App\Models\Conversation::whereHas('users', fn($q) => $q->where('user_id', session('usr_id')))
                        ->get()->sum(fn($c) => $c->unreadMessagesCount(session('usr_id')));
                @endphp
                @if($chatUnread > 0)
                    <span class="nav-badge">{{ $chatUnread > 99 ? '99+' : $chatUnread }}</span>
                @endif
            </a>
            <span class="nav-label">Cuenta</span>
            <a href="{{ route('instructor.perfil') }}" class="nav-item {{ request()->routeIs('instructor.perfil') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Perfil
            </a>
            @break
        @case(3)
            <span class="nav-label">Portal Empresa</span>
            <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Principal
            </a>
            <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
                <i class="fas fa-project-diagram"></i> Mis Proyectos
            </a>
            <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i> Publicar Proyecto
            </a>
            <span class="nav-label">Comunicación</span>
            <a href="{{ route('chat.index') }}" class="nav-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                <i class="fas fa-comment-dots"></i> Mensajes
                @php
                    $chatUnread = \App\Models\Conversation::whereHas('users', fn($q) => $q->where('user_id', session('usr_id')))
                        ->get()->sum(fn($c) => $c->unreadMessagesCount(session('usr_id')));
                @endphp
                @if($chatUnread > 0)
                    <span class="nav-badge">{{ $chatUnread > 99 ? '99+' : $chatUnread }}</span>
                @endif
            </a>
            <span class="nav-label">Configuración</span>
            <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Perfil Empresa
            </a>
            @break
    @endswitch
@endsection

@section('styles')
    @vite(['resources/css/chat.css'])
    <style>
        :root { --chat-radius: 16px; --chat-msg-radius: 16px; }

        .chat-page {
            display: flex;
            height: calc(100vh - 200px);
            min-height: 480px;
            background: white;
            border-radius: var(--chat-radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        }
        .chat-sidebar {
            width: 340px;
            flex-shrink: 0;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            background: #fafbfc;
        }
        .chat-sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            background: white;
        }
        .chat-sidebar-header h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .chat-conversations {
            flex: 1;
            overflow-y: auto;
            padding: 8px;
        }
        .chat-conv-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: var(--text);
            margin-bottom: 2px;
        }
        .chat-conv-item:hover { background: rgba(62,180,137,0.08); }
        .chat-conv-item.active {
            background: rgba(62,180,137,0.12);
            border: 1px solid rgba(62,180,137,0.2);
        }
        .chat-conv-avatar {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 15px;
            flex-shrink: 0; color: white;
        }
        .chat-conv-info { flex: 1; min-width: 0; }
        .chat-conv-name {
            font-size: 13px; font-weight: 700;
            color: var(--text);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .chat-conv-preview {
            font-size: 11px; color: var(--text-light);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            margin-top: 2px;
        }
        .chat-conv-meta { text-align: right; flex-shrink: 0; }
        .chat-conv-time {
            font-size: 10px; color: var(--text-lighter); font-weight: 600;
        }
        .chat-conv-badge {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 20px; height: 20px; padding: 0 6px;
            border-radius: 10px; background: #3eb489; color: white;
            font-size: 10px; font-weight: 800; margin-top: 4px;
        }
        .chat-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .chat-main-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 14px;
            background: white;
        }
        .chat-main-header h4 {
            font-size: 15px; font-weight: 800; margin: 0; color: var(--text);
        }
        .chat-main-header span { font-size: 11px; color: var(--text-light); font-weight: 600; }
        .chat-messages {
            flex: 1; overflow-y: auto;
            padding: 20px 24px;
            display: flex; flex-direction: column; gap: 6px;
            background: #f8fafc;
        }
        .chat-msg {
            max-width: 75%;
            padding: 12px 18px;
            border-radius: var(--chat-msg-radius);
            font-size: 14px; line-height: 1.5;
            position: relative; word-wrap: break-word;
            animation: msgSlideIn 0.2s ease;
        }
        @keyframes msgSlideIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .chat-msg.sent {
            align-self: flex-end;
            background: linear-gradient(135deg, #3eb489, #2d9d74);
            color: white;
            border-bottom-right-radius: 4px;
        }
        .chat-msg.received {
            align-self: flex-start;
            background: white;
            color: var(--text);
            border: 1px solid var(--border);
            border-bottom-left-radius: 4px;
        }
        .chat-msg-time {
            font-size: 10px; opacity: 0.7;
            margin-top: 4px; display: block;
            text-align: right; font-weight: 600;
        }
        .chat-msg.sent .chat-msg-time { color: rgba(255,255,255,0.8); }
        .chat-msg.received .chat-msg-time { color: var(--text-lighter); }
        .chat-msg-date-separator {
            text-align: center; font-size: 11px; font-weight: 700;
            color: var(--text-lighter); padding: 8px 0;
            position: relative;
        }
        .chat-msg-date-separator::before,
        .chat-msg-date-separator::after {
            content: ''; position: absolute; top: 50%;
            width: 30%; height: 1px; background: var(--border);
        }
        .chat-msg-date-separator::before { left: 0; }
        .chat-msg-date-separator::after { right: 0; }

        .chat-empty {
            flex: 1; display: flex; align-items: center; justify-content: center;
            flex-direction: column; gap: 12px;
            color: var(--text-lighter); background: #f8fafc;
        }
        .chat-empty i { font-size: 48px; opacity: 0.4; }
        .chat-empty p { font-size: 14px; font-weight: 600; }

        .chat-input-area {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            background: white;
        }
        .chat-input-form { display: flex; gap: 12px; align-items: flex-end; }
        .chat-input-form textarea {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px; font-family: inherit;
            resize: none; outline: none;
            transition: border 0.2s, box-shadow 0.2s;
            min-height: 48px; max-height: 120px;
        }
        .chat-input-form textarea:focus {
            border-color: #3eb489;
            box-shadow: 0 0 0 3px rgba(62,180,137,0.1);
        }
        .chat-input-form button {
            align-self: flex-end;
            width: 48px; height: 48px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #3eb489, #2d9d74);
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .chat-input-form button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 16px rgba(62,180,137,0.3);
        }
        .chat-input-form button:disabled {
            opacity: 0.5; cursor: not-allowed; transform: none;
        }

        .typing-indicator {
            display: none; align-items: center; gap: 8px;
            padding: 6px 24px 2px;
            font-size: 11px; color: var(--text-light); font-weight: 600;
        }
        .typing-dots { display: flex; gap: 3px; }
        .typing-dots span {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--text-lighter);
            animation: typingBounce 1.4s infinite;
        }
        .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
        .typing-dots span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typingBounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-4px); }
        }

        .load-more-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 8px 16px; margin-bottom: 8px;
            background: white; border: 1px solid var(--border);
            border-radius: 20px; font-size: 11px; font-weight: 700;
            color: var(--text-light); cursor: pointer;
            transition: all 0.2s; align-self: center;
        }
        .load-more-btn:hover {
            border-color: #3eb489; color: #3eb489;
            box-shadow: 0 2px 8px rgba(62,180,137,0.1);
        }
        .load-more-btn:disabled { opacity: 0.5; cursor: not-allowed; }

        @media (max-width: 768px) {
            .chat-page { flex-direction: column; height: auto; min-height: auto; }
            .chat-sidebar { width: 100%; max-height: 240px; }
            .chat-messages { max-height: 400px; }
        }
    </style>
@endsection

@php $breadcrumbs = [['label' => 'Mensajes']]; @endphp

@section('content')
<div class="animate-fade-in">
    <div class="chat-page">
        {{-- Sidebar: Lista de conversaciones --}}
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <h3><i class="fas fa-comment-dots" style="color:#3eb489;"></i> Conversaciones</h3>
            </div>
            <div class="chat-conversations" id="chatConversations">
                @forelse($conversations as $conv)
                    @php
                        $otherUser = $conv->users->firstWhere('id', '!=', session('usr_id'));
                        $otherRole = $otherUser?->nombre_rol ?? '';
                        $otherName = $otherUser?->nombre ?: ($otherRole ?: 'Usuario');
                        $lastMsg = $conv->lastMessage;
                        $unread = $unreadCounts[$conv->id] ?? 0;
                        $isActive = isset($conversation) && $conversation->id === $conv->id;
                        $avatarColors = ['#3eb489','#3b82f6','#8b5cf6','#f59e0b','#f43f5e'];
                        $avatarColor = $avatarColors[crc32($otherName) % count($avatarColors)];
                    @endphp
                    <a href="{{ route('chat.show', $conv->id) }}"
                       class="chat-conv-item {{ $isActive ? 'active' : '' }}"
                       data-conv-id="{{ $conv->id }}">
                        <div class="chat-conv-avatar" style="background: linear-gradient(135deg, {{ $avatarColor }}, {{ $avatarColor }}cc);">
                            {{ strtoupper(substr($otherName, 0, 1)) }}
                        </div>
                        <div class="chat-conv-info">
                            <div class="chat-conv-name">
                                {{ $otherName }}
                                <span style="font-size:10px;color:var(--text-lighter);font-weight:600;margin-left:6px;">{{ $otherRole }}</span>
                            </div>
                            <div class="chat-conv-preview">
                                @if($lastMsg)
                                    {{ Str::limit($lastMsg->message, 40) }}
                                @else
                                    <span style="color:var(--text-lighter);font-style:italic;">Sin mensajes</span>
                                @endif
                            </div>
                        </div>
                        <div class="chat-conv-meta">
                            @if($lastMsg)
                                <div class="chat-conv-time">{{ $lastMsg->created_at->diffForHumans(null, true) }}</div>
                            @endif
                            @if($unread > 0)
                                <div class="chat-conv-badge">{{ $unread }}</div>
                            @endif
                        </div>
                    </a>
                @empty
                    <div style="padding:32px 16px;text-align:center;color:var(--text-lighter);">
                        <i class="fas fa-inbox" style="font-size:32px;opacity:0.4;margin-bottom:12px;display:block;"></i>
                        <p style="font-size:13px;font-weight:600;">No tienes conversaciones activas</p>
                        <p style="font-size:11px;margin-top:4px;">Los chats se crean desde la página de detalle del proyecto</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Main: Chat activo --}}
        @if(isset($conversation))
            @php
                $otherUser = $conversation->users->firstWhere('id', '!=', session('usr_id'));
                $otherRole = $otherUser?->nombre_rol ?? '';
                $otherName = $otherUser?->nombre ?: ($otherRole ?: 'Usuario');
                $proyectoTitle = $conversation->proyecto?->titulo ?? 'Proyecto';
            @endphp
            <div class="chat-main">
                <div class="chat-main-header">
                    @php
                        $avatarColors = ['#3eb489','#3b82f6','#8b5cf6','#f59e0b','#f43f5e'];
                        $avatarColor = $avatarColors[crc32($otherName) % count($avatarColors)];
                    @endphp
                    <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,{{ $avatarColor }},{{ $avatarColor }}cc);color:white;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;flex-shrink:0;">
                        {{ strtoupper(substr($otherName, 0, 1)) }}
                    </div>
                    <div>
                        <h4>{{ $otherName }} <span style="font-weight:600;font-size:11px;color:var(--text-light);">({{ $otherRole }})</span></h4>
                        <span><i class="far fa-folder-open" style="margin-right:4px;"></i>{{ Str::limit($proyectoTitle, 40) }}</span>
                    </div>
                </div>

                <div class="chat-messages" id="chatMessages">
                    @if($messages->hasMorePages())
                        <button class="load-more-btn" id="loadMoreBtn" data-next-url="{{ $messages->nextPageUrl() }}">
                            <i class="fas fa-chevron-up"></i> Cargar mensajes anteriores
                        </button>
                    @endif

                    @forelse($messages as $msg)
                        @php $isMine = $msg->sender_id === session('usr_id'); @endphp
                        <div class="chat-msg {{ $isMine ? 'sent' : 'received' }}" data-id="{{ $msg->id }}">
                            @if(!$isMine)
                                <div style="font-size:11px;font-weight:700;color:#3eb489;margin-bottom:4px;">{{ $msg->sender->nombre }}</div>
                            @endif
                            <div>{{ nl2br(e($msg->message)) }}</div>
                            <span class="chat-msg-time">
                                {{ $msg->created_at->format('H:i') }}
                                @if($isMine && $msg->read_at)
                                    <i class="fas fa-check-double" style="margin-left:4px;font-size:10px;"></i>
                                @elseif($isMine)
                                    <i class="fas fa-check" style="margin-left:4px;font-size:10px;"></i>
                                @endif
                            </span>
                        </div>
                    @empty
                        <div class="chat-empty-state" style="text-align:center;padding:40px 20px;color:var(--text-lighter);">
                            <i class="fas fa-comments" style="font-size:36px;opacity:0.3;margin-bottom:12px;display:block;"></i>
                            <p style="font-size:14px;font-weight:600;">No hay mensajes aún</p>
                            <p style="font-size:12px;">Envía el primer mensaje para iniciar la conversación</p>
                        </div>
                    @endforelse
                </div>

                {{-- Typing indicator --}}
                <div class="typing-indicator" id="typingIndicator">
                    <span id="typingName"></span>
                    <span>escribiendo</span>
                    <div class="typing-dots">
                        <span></span><span></span><span></span>
                    </div>
                </div>

                <div class="chat-input-area">
                    <form class="chat-input-form" id="chatForm"
                          action="{{ route('chat.send', $conversation->id) }}"
                          method="POST"
                          data-conversation-id="{{ $conversation->id }}">
                        @csrf
                        <textarea name="message" id="messageInput" rows="1"
                                  placeholder="Escribe un mensaje..." required maxlength="5000"></textarea>
                        <button type="submit" id="sendBtn" title="Enviar mensaje">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="chat-empty">
                <i class="fas fa-comment-dots"></i>
                <p>Selecciona una conversación para empezar</p>
                <span style="font-size:12px;color:var(--text-lighter);">O inicia un chat desde la página de detalle de un proyecto</span>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
@vite(['resources/js/chat.js'])
@endsection
