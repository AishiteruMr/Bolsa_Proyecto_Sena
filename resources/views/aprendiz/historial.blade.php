@extends('layouts.dashboard')

@section('title', 'Historial de Proyectos')

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
        <i class="fas fa-user-shield group-hover:text-[#FF6B00] transition-colors italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic">Mi Identidad</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-10 pb-16">
    
    <!-- Header Section -->
    <div class="space-y-4">
        <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
            Bitácora de <span class="text-[#FF6B00] underline decoration-[#FF6B00]/20 decoration-8 underline-offset-8">Operaciones</span>
        </h2>
        <p class="text-slate-400 font-bold text-sm uppercase tracking-widest flex items-center gap-3">
            <span class="w-12 h-px bg-slate-200"></span>
            Registro histórico de postulaciones y despliegues
        </p>
    </div>

    @if($proyectos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-bold text-slate-900">
            @foreach($proyectos as $proyecto)
                <x-card class="p-8 md:p-10 border-none ring-1 ring-slate-100 shadow-xl hover:shadow-2xl hover:ring-[#FF6B00]/30 transition-all group relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-slate-50 rounded-full blur-3xl opacity-50 transition-colors group-hover:bg-orange-50"></div>
                    
                    <div class="relative space-y-8">
                        <div class="flex justify-between items-start gap-4">
                            <div class="space-y-2 flex-1">
                                <h5 class="text-2xl font-black text-slate-900 tracking-tight uppercase italic group-hover:text-[#E65100] transition-colors leading-tight">{{ $proyecto->pro_titulo_proyecto }}</h5>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic flex items-center gap-2">
                                    <i class="fas fa-building text-[#FF6B00]"></i> {{ $proyecto->emp_nombre }}
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                @switch($proyecto->pos_estado)
                                    @case('Aprobada')
                                        <x-badge class="bg-[#FF6B00] text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-orange-100">ADMITIDO</x-badge>
                                        @break
                                    @case('Rechazada')
                                        <x-badge class="bg-red-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-red-100">FINALIZADO</x-badge>
                                        @break
                                    @default
                                        <x-badge class="bg-amber-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-amber-100 italic">PENDIENTE</x-badge>
                                @endswitch
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 py-6 border-y border-slate-50">
                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic block">CATEGORÍA</span>
                                    <p class="text-sm font-black text-slate-700 uppercase italic">{{ $proyecto->pro_categoria }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic block">POSTULACIÓN</span>
                                    <p class="text-sm font-black text-slate-700 uppercase italic">{{ \Carbon\Carbon::parse($proyecto->pos_fecha)->format('d M, Y') }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic block">TUTOR ASIGNADO</span>
                                    <p class="text-sm font-black text-slate-700 uppercase italic truncate">{{ $proyecto->instructor_nombre }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic block">LÍMITE DE ENTREGA</span>
                                    <p class="text-sm font-black text-red-500 uppercase italic">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-6 rounded-[2rem] flex items-center justify-between group/status font-bold">
                            @php
                                $dias_restantes = max(0, \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->diffInDays(now(), false));
                            @endphp
                            <div class="space-y-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic block">ESTADO OPERATIVO</span>
                                <h4 class="text-sm font-black text-slate-900 uppercase italic group-hover/status:text-[#E65100] transition-colors">{{ $proyecto->pro_estado }}</h4>
                            </div>
                            <div class="text-right">
                                @if($dias_restantes > 0)
                                    <span class="text-[10px] font-black text-amber-500 uppercase italic flex items-center gap-2">
                                        <i class="fas fa-clock animate-pulse"></i> {{ $dias_restantes }} DÍAS RESTANTES
                                    </span>
                                @else
                                    <span class="text-[10px] font-black text-[#FF6B00] uppercase italic flex items-center gap-2">
                                        <i class="fas fa-check-double"></i> CICLO COMPLETADO
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($proyecto->pos_estado === 'Aprobada')
                            <x-button :href="route('aprendiz.proyecto.detalle', $proyecto->pro_id)" variant="primary" shadow="orange" class="w-full py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] flex items-center justify-center gap-3 active:scale-95 transition-all group/btn">
                                GESTIONAR ENTREGAS <i class="fas fa-paper-plane group-hover/btn:translate-x-1 transition-transform italic text-lg"></i>
                            </x-button>
                        @else
                            <div class="w-full py-5 bg-slate-100 rounded-2xl flex items-center justify-center gap-3 text-slate-300 text-[10px] font-black uppercase tracking-widest italic border border-slate-200">
                                <i class="fas fa-lock opacity-20"></i> ACCESO RESTRINGIDO
                            </div>
                        @endif
                    </div>
                </x-card>
            @endforeach
        </div>
    @else
        <div class="py-32 bg-white rounded-[4rem] border-2 border-dashed border-slate-100 text-center space-y-10 shadow-inner">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-slate-200 rounded-full blur-3xl animate-pulse"></div>
                <div class="w-40 h-40 rounded-[3rem] bg-slate-900 flex items-center justify-center mx-auto text-white text-6xl italic relative shadow-2xl transform rotate-12">
                    <i class="fas fa-folder-open opacity-20"></i>
                </div>
            </div>
            
            <div class="space-y-4 max-w-lg mx-auto px-6 font-bold">
                <h4 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Bitácora Vacía</h4>
                <p class="text-slate-400 font-bold text-lg italic leading-relaxed">No se han registrado transmisiones ni postulaciones en la memoria del sistema. Comienza tu primera misión para generar registros.</p>
            </div>

            <div class="pt-6">
                <x-button :href="route('aprendiz.proyectos')" variant="primary" shadow="orange" class="px-12 py-5 rounded-3xl font-black text-xs uppercase tracking-[0.2em] flex items-center gap-4 mx-auto hover:scale-105 active:scale-95 transition-all group">
                    <i class="fas fa-rocket text-lg group-hover:rotate-45 transition-transform italic"></i> 
                    INICIAR OPERACIONES
                </x-button>
            </div>
        </div>
    @endif
</div>
@endsection
