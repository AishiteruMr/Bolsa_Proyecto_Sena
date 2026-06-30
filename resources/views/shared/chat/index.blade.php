@extends('layouts.dashboard')

@section('title', 'Mensajes - Inspírate SENA')
@section('page-title', 'Bandeja de Mensajes')

@section('sidebar-nav')
    @php
        $chatUnread = \App\Models\Conversation::whereHas('users', fn($q) => $q->where('user_id', session('usr_id')))
            ->withCount(['messages as unread_count' => function ($q) {
                $q->where('sender_id', '!=', session('usr_id'))->whereNull('read_at');
            }])->get()->sum('unread_count');
    @endphp
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
