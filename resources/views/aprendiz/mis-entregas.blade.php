@extends('layouts.dashboard')

@section('title', 'Mis Entregas')

@section('sidebar-nav')
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic">PRINCIPAL</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item group {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home group-hover:rotate-12 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic">Panel Central</span>
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item group {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-search group-hover:scale-110 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic">Banco de Retos</span>
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item group {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic">Mis Misiones</span>
    </a>
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mt-6 mb-2 block italic">CONFIGURACIÓN</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item group {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-shield group-hover:text-emerald-500 transition-colors italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic">Mi Identidad</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-16">
    <!-- Summary Bento -->
    @if($proyectos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-card class="p-8 border-none ring-1 ring-slate-100 shadow-xl bg-slate-900 relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
                <div class="relative flex flex-col justify-between h-full space-y-4">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic block">TOTAL EVIDENCIAS</span>
                    <h3 class="text-5xl font-black text-white italic group-hover:text-emerald-400 transition-colors">{{ $evidencias->count() }}</h3>
                </div>
            </x-card>
            <x-card class="p-8 border-none ring-1 ring-slate-100 shadow-xl bg-emerald-500 relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/20 rounded-full blur-3xl"></div>
                <div class="relative flex flex-col justify-between h-full space-y-4">
                    <span class="text-[10px] font-black text-emerald-900/40 uppercase tracking-widest italic block">MISIONES OK</span>
                    <h3 class="text-5xl font-black text-white italic group-hover:scale-110 origin-left transition-transform">{{ $evidencias->where('evid_estado', 'Aprobada')->count() }}</h3>
                </div>
            </x-card>
            <x-card class="p-8 border-none ring-1 ring-slate-100 shadow-xl bg-amber-500 relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/20 rounded-full blur-3xl"></div>
                <div class="relative flex flex-col justify-between h-full space-y-4">
                    <span class="text-[10px] font-black text-amber-900/40 uppercase tracking-widest italic block">EN REVISIÓN</span>
                    <h3 class="text-5xl font-black text-white italic group-hover:scale-110 origin-left transition-transform">{{ $evidencias->where('evid_estado', 'Pendiente')->count() }}</h3>
                </div>
            </x-card>
        </div>
    @endif

    <!-- Projects List -->
    <div class="space-y-12">
        @if($proyectos->count() > 0)
            @foreach($proyectos as $proyecto)
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-[1.5rem] bg-slate-900 text-emerald-500 flex items-center justify-center text-xl italic shadow-2xl transform -rotate-6">
                            <i class="fas fa-terminal"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight uppercase italic">{{ $proyecto->pro_titulo_proyecto }}</h3>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic flex items-center gap-2">
                                <i class="fas fa-building text-emerald-500"></i> {{ $proyecto->emp_nombre }} • {{ $proyecto->pro_categoria }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @php
                            $evidencias_proyecto = $evidencias->where('evid_pro_id', $proyecto->pro_id);
                        @endphp

                        @forelse($evidencias_proyecto as $evidencia)
                            <x-card class="p-6 md:p-8 border-none ring-1 ring-slate-100 shadow-lg hover:shadow-2xl hover:ring-emerald-500/20 transition-all group/evid flex items-center gap-6 relative overflow-hidden">
                                <div class="absolute right-0 top-0 w-24 h-full bg-slate-50 -mr-12 group-hover/evid:-mr-10 transition-all opacity-50"></div>
                                
                                <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center text-2xl italic text-slate-300 group-hover/evid:bg-emerald-50 group-hover/evid:text-emerald-500 transition-colors shadow-inner flex-shrink-0">
                                    {{ $evidencia->etapa->eta_orden ?? '!' }}
                                </div>

                                <div class="flex-1 space-y-3 relative">
                                    <div class="flex justify-between items-start">
                                        <div class="space-y-1">
                                            <h4 class="text-lg font-black text-slate-900 uppercase italic leading-tight group-hover/evid:text-emerald-600 transition-colors">{{ $evidencia->etapa->eta_nombre ?? 'Módulo Operativo' }}</h4>
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic font-bold">{{ \Carbon\Carbon::parse($evidencia->evid_fecha)->format('d M, Y • H:i') }}</span>
                                        </div>
                                        @switch($evidencia->evid_estado)
                                            @case('Aprobada')
                                                <x-badge class="bg-emerald-500 text-white border-none py-1 px-3 rounded-xl text-[8px] font-black uppercase shadow-lg shadow-emerald-100">VALIDADO</x-badge>
                                                @break
                                            @case('Rechazada')
                                                <x-badge class="bg-red-500 text-white border-none py-1 px-3 rounded-xl text-[8px] font-black uppercase shadow-lg shadow-red-100">AJUSTE</x-badge>
                                                @break
                                            @default
                                                <x-badge class="bg-amber-500 text-white border-none py-1 px-3 rounded-xl text-[8px] font-black uppercase shadow-lg shadow-amber-100">COLA</x-badge>
                                        @endswitch
                                    </div>

                                    @if($evidencia->evid_comentario)
                                        <p class="text-[10px] font-bold text-slate-500 italic leading-relaxed bg-white/50 p-3 rounded-xl border border-slate-50">{{ $evidencia->evid_comentario }}</p>
                                    @endif

                                    @if($evidencia->hasFile())
                                        <div class="pt-2">
                                            <x-button :href="$evidencia->getFileUrl()" target="_blank" variant="secondary" class="py-2.5 px-6 rounded-xl font-black text-[9px] uppercase tracking-widest flex items-center gap-2 hover:bg-slate-900 hover:text-white transition-colors">
                                                <i class="fas fa-paperclip text-xs italic"></i> DESCARGAR ARTEFACTO
                                            </x-button>
                                        </div>
                                    @endif
                                </div>
                            </x-card>
                        @empty
                            <div class="lg:col-span-2 py-10 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-100 flex flex-col items-center justify-center gap-4 text-slate-300 font-bold">
                                <i class="fas fa-ghost text-4xl opacity-20 italic"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest italic">Inactivo: Sin transmisiones detectadas</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        @else
            <div class="py-32 bg-white rounded-[4rem] border-2 border-dashed border-slate-100 text-center space-y-10 shadow-inner">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-slate-200 rounded-full blur-3xl animate-pulse"></div>
                    <div class="w-40 h-40 rounded-[3rem] bg-slate-900 flex items-center justify-center mx-auto text-white text-6xl italic relative shadow-2xl transform rotate-12">
                        <i class="fas fa-layer-group opacity-20"></i>
                    </div>
                </div>
                
                <div class="space-y-4 max-w-lg mx-auto px-6 font-bold text-slate-900">
                    <h4 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Sistema Latente</h4>
                    <p class="text-slate-400 font-bold text-lg italic leading-relaxed">No hay misiones activas vinculadas a tu identidad. Desbloquea retos en el Banco de Retos para iniciar transmisiones de evidencias.</p>
                </div>

                <div class="pt-6">
                    <x-button :href="route('aprendiz.proyectos')" variant="primary" shadow="emerald" class="px-12 py-5 rounded-3xl font-black text-xs uppercase tracking-[0.2em] flex items-center gap-4 mx-auto hover:scale-105 active:scale-95 transition-all group">
                        <i class="fas fa-rocket text-lg group-hover:animate-ping transition-transform italic"></i> 
                        ESCANEAR BANCO DE RETOS
                    </x-button>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
