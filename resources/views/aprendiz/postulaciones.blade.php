@extends('layouts.dashboard')

@section('title', 'Monitor de Candidaturas | ' . (session('nombre') ?? 'Aprendiz'))

@section('sidebar-nav')

    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic text-slate-400">OPERACIÓN ACADÉMICA</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item group {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Panel de Control</span>

    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item group {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase group-hover:rotate-12 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Explorar Misiones</span>
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item group {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Mis Candidaturas</span>
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item group {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history group-hover:rotate-12 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Archivo de Misión</span>
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item group {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Bitácora de Entregas</span>
    </a>
    
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mt-6 mb-2 block italic text-slate-400">CONFIGURACIÓN</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item group {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user group-hover:rotate-12 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Identidad Digital</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-24 italic font-bold">
    
    <!-- Header Section -->
    <div class="space-y-6 px-4 italic">
        <div class="flex items-center gap-6 italic">
            <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-2xl shadow-emerald-500/20 italic rotate-6">
                <i class="fas fa-paper-plane-o text-xl font-bold italic"></i>
            </div>
            <div class="italic">
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">
                    Rastreo de <span class="text-emerald-500">Candidaturas</span>
                </h2>
                <p class="text-slate-400 font-black text-[10px] uppercase tracking-[0.4em] mt-3 italic opacity-60 italic leading-none italic">
                    MONITOR DE ESTADO DE VINCULACIÓN A PROYECTOS ESTRATÉGICOS
                </p>
            </div>
        </div>
    </div>

    <!-- Postulaciones Dossier -->
    <div class="grid gap-8 px-4 italic">
        @forelse($postulaciones as $post)
            <x-card class="p-10 md:p-12 border-none shadow-2xl hover:shadow-[0_40px_80px_-20px_rgba(16,185,129,0.1)] transition-all duration-700 group overflow-hidden relative bg-white rounded-[3.5rem] italic" shadow="none">
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-slate-50 rounded-full blur-[100px] opacity-60 group-hover:bg-emerald-50 transition-all duration-[2000ms] italic"></div>
                
                <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-12 italic">
                    <div class="flex items-center gap-10 flex-1 italic">
                        <!-- Project Identity Unit -->
                        <div class="w-28 h-28 rounded-[2.5rem] overflow-hidden bg-slate-100 shadow-2xl border-4 border-white group-hover:rotate-6 transition-transform duration-700 flex-shrink-0 italic">
                            @if($post->pro_imagen_url)
                                <img src="{{ $post->pro_imagen_url }}" alt="" class="w-full h-full object-cover italic">
                            @else
                                <div class="w-full h-full bg-slate-900 flex items-center justify-center text-white text-4xl italic italic">
                                    <i class="fas fa-satellite animate-pulse italic"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Project Metadata -->
                        <div class="space-y-4 flex-1 min-w-0 italic">
                            <div class="flex items-center gap-4 italic">
                                <h4 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic truncate group-hover:text-emerald-600 transition-colors italic leading-none">{{ $post->pro_titulo_proyecto }}</h4>
                                <x-badge class="bg-slate-900 text-white border-none px-4 py-1.5 rounded-xl text-[8px] font-black uppercase tracking-[0.3em] italic shadow-2xl italic">
                                    {{ strtoupper($post->pro_categoria) }}
                                </x-badge>
                            </div>
                            
                            <div class="flex flex-wrap items-center gap-8 italic">
                                <div class="flex items-center gap-4 bg-slate-50 px-6 py-2.5 rounded-[1.5rem] border-2 border-white shadow-xl italic">
                                    <i class="fas fa-building text-xs italic text-emerald-500 font-bold"></i>
                                    <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest italic truncate max-w-[200px] italic">{{ $post->emp_nombre }}</span>
                                </div>
                                <div class="flex items-center gap-4 italic opacity-40 italic">
                                    <i class="fas fa-calendar-check text-blue-500 italic"></i>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] italic">RADICADO: {{ \Carbon\Carbon::parse($post->pos_fecha)->format('d M, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Orchestration -->
                    <div class="flex items-center gap-10 border-t lg:border-t-0 pt-10 lg:pt-0 border-slate-50 italic">
                        <div class="text-right space-y-3 italic">
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic block italic leading-none">PROTOCOLO</span>
                            @switch($post->pos_estado)
                                @case('Pendiente')
                                    <x-badge class="bg-amber-50 text-amber-600 border-none py-2 px-6 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] italic shadow-lg shadow-amber-500/5 ring-1 ring-amber-100 italic">
                                        <i class="fas fa-bolt shadow-sm mr-3 animate-pulse italic"></i> PENDIENTE
                                    </x-badge>
                                    @break
                                @case('Aprobada')
                                    <x-badge class="bg-emerald-500 text-white border-none py-2 px-6 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] italic shadow-2xl shadow-emerald-500/20 italic">
                                        <i class="fas fa-check-circle shadow-sm mr-3 italic"></i> ADMITIDO
                                    </x-badge>
                                    @break
                                @case('Rechazada')
                                    <x-badge class="bg-red-50 text-red-600 border-none py-2 px-6 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] italic ring-1 ring-red-100 italic">
                                        <i class="fas fa-times-circle shadow-sm mr-3 italic"></i> FINALIZADO
                                    </x-badge>
                                    @break
                            @endswitch
                        </div>

                        <div class="flex items-center italic">
                            @if($post->pos_estado === 'Aprobada')
                                <x-button :href="route('aprendiz.proyecto.detalle', $post->pro_id)" variant="primary" shadow="emerald" class="py-6 px-12 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.2em] flex items-center gap-4 group/btn hover:scale-105 active:scale-95 transition-all italic italic shadow-2xl">
                                    CENTRO DE ACCIÓN 
                                    <i class="fas fa-arrow-right group-hover/btn:translate-x-2 transition-transform italic text-white font-bold flex items-center justify-center"></i>
                                </x-button>
                            @else
                                <div class="w-16 h-16 rounded-[2rem] bg-slate-50 flex items-center justify-center text-slate-200 italic border-4 border-white shadow-xl italic rotate-12 opacity-50 italic">
                                    <i class="fas fa-lock text-xl opacity-20 italic"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>
        @empty
            <div class="py-40 bg-white rounded-[4rem] border-8 border-slate-50 text-center space-y-12 shadow-inner italic">
                <div class="relative inline-block italic">
                    <div class="absolute inset-0 bg-emerald-500/10 rounded-full blur-[80px] animate-pulse italic"></div>
                    <div class="w-48 h-48 rounded-[4rem] bg-slate-900 border-8 border-white flex items-center justify-center mx-auto text-white text-7xl italic relative shadow-2xl transform rotate-12 italic">
                        <i class="fas fa-paper-plane-o animate-bounce italic"></i>
                    </div>
                </div>
                
                <div class="space-y-6 max-w-lg mx-auto px-6 italic">
                    <h4 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">Inactividad Detectada</h4>
                    <p class="text-slate-400 font-bold text-lg uppercase italic leading-[1.6] opacity-70 italic">Tu panel de candidaturas está en silencio operativo. Es el momento perfecto para interceptar tu primer gran desafío táctico.</p>
                </div>

                <div class="pt-10 italic">
                    <x-button :href="route('aprendiz.proyectos')" variant="primary" shadow="emerald" class="px-16 py-7 rounded-[2.5rem] font-black text-xs uppercase tracking-[0.3em] flex items-center gap-6 mx-auto hover:scale-105 active:scale-95 transition-all group shadow-2xl italic italic">
                        <i class="fas fa-radar text-2xl group-hover:rotate-45 transition-transform italic text-white flex items-center justify-center font-bold"></i> 
                        ESCANEAR PROYECTOS
                    </x-button>
                </div>
            </div>
        @endforelse
    </div>

    @if($postulaciones->hasPages())
        <div class="mt-24 flex justify-center italic px-4">
            <div class="pagination-premium italic">
                {{ $postulaciones->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
