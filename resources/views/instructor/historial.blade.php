@extends('layouts.dashboard')

@section('title', 'Bóveda de Misiones | ' . (session('nombre') ?? 'Instructor'))

@section('sidebar-nav')

    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic text-slate-400">OPERACIÓN TÉCNICA</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item group {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Centro de Mando</span>

    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item group {{ request()->routeIs('instructor.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram group-hover:rotate-12 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Mis Proyectos</span>
    </a>
    <a href="{{ route('instructor.aprendices') }}" class="nav-item group {{ request()->routeIs('instructor.aprendices') ? 'active' : '' }}">
        <i class="fas fa-users group-hover:-translate-y-1 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Mis Aprendices</span>
    </a>
    <a href="{{ route('instructor.historial') }}" class="nav-item group {{ request()->routeIs('instructor.historial') ? 'active' : '' }}">
        <i class="fas fa-history group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Archivo Histórico</span>
    </a>
    
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mt-6 mb-2 block italic text-slate-400">CONFIGURACIÓN</span>
    <a href="{{ route('instructor.perfil') }}" class="nav-item group {{ request()->routeIs('instructor.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle group-hover:rotate-12 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Perfil Técnico</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-24 italic font-bold">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 px-4 italic">
        <div class="space-y-6 italic">
            <div class="flex items-center gap-4 italic font-bold">
                <x-badge class="bg-slate-900 text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic shadow-2xl shadow-black/20 italic">
                    ARCHIVOS CLASIFICADOS
                </x-badge>
                <div class="h-1 w-12 bg-slate-100 rounded-full italic"></div>
                <span class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] italic opacity-60 italic leading-none">TRAZABILIDAD DE MISIONES EJECUTADAS</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">
                BÓVEDA DE <span class="text-emerald-500 block mt-2 text-6xl md:text-7xl italic">MISIONES</span>
            </h2>
        </div>

        <div class="flex items-center gap-6 italic">
            <div class="flex items-center gap-4 bg-slate-50 px-8 py-4 rounded-[1.5rem] shadow-xl border-4 border-white italic">
                <span class="text-3xl font-black text-slate-900 tracking-tighter italic leading-none italic">{{ str_pad($proyectos->count(), 2, '0', STR_PAD_LEFT) }}</span>
                <div class="h-8 w-px bg-slate-200 italic"></div>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] italic leading-tight italic">REGISTROS <br>EN ARCHIVO</span>
            </div>
        </div>
    </div>

    @if($proyectos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 px-4 italic">
            @foreach($proyectos as $proyecto)
                <x-card class="group flex flex-col h-full border-none shadow-2xl hover:shadow-emerald-500/10 rounded-[4rem] bg-white transition-all duration-700 overflow-hidden italic" shadow="none">
                    <div class="p-12 md:p-14 space-y-10 flex-1 flex flex-col italic font-bold">
                        <div class="flex justify-between items-start gap-6 italic">
                            <div class="space-y-4 flex-1 italic">
                                <h3 class="text-3xl font-black text-slate-900 group-hover:text-emerald-500 transition-colors uppercase italic tracking-tighter leading-none italic font-bold">{{ $proyecto->pro_titulo_proyecto }}</h3>
                                <div class="flex items-center gap-4 text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] italic opacity-60 italic leading-none">
                                    <i class="fas fa-building text-emerald-500 italic font-bold"></i>
                                    <span class="truncate italic">{{ strtoupper($proyecto->emp_nombre) }}</span>
                                </div>
                            </div>
                            <x-badge class="{{ $proyecto->pro_estado === 'Activo' ? 'bg-emerald-500 text-white' : 'bg-slate-900 text-white' }} border-none px-6 py-2 rounded-xl text-[9px] font-black uppercase italic shadow-2xl shadow-black/20 italic">
                                {{ strtoupper($proyecto->pro_estado) }}
                            </x-badge>
                        </div>

                        <div class="grid grid-cols-2 gap-8 p-8 rounded-[2.5rem] bg-slate-50 border-4 border-white italic shadow-xl group-hover:bg-emerald-50/50 group-hover:border-emerald-500/10 transition-all italic font-bold">
                            <div class="text-center italic font-bold">
                                <p class="text-4xl font-black text-slate-900 italic tracking-tighter italic leading-none italic">{{ str_pad($proyecto->total_aprendices, 2, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic opacity-80 mt-3 italic leading-none italic">POSTULACIONES</p>
                            </div>
                            <div class="text-center pl-8 border-l-4 border-white italic font-bold">
                                <p class="text-4xl font-black text-emerald-500 italic tracking-tighter italic leading-none italic">{{ str_pad($proyecto->aprendices_aprobados, 2, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic opacity-80 mt-3 italic leading-none italic">APROBACIONES</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-8 pt-6 italic font-bold border-t border-slate-50 italic">
                            <div class="flex items-center gap-3 text-slate-400 text-[9px] font-black uppercase italic opacity-60 italic leading-none italic">
                                <i class="fas fa-tag text-emerald-500 italic font-bold"></i>
                                <span class="italic tracking-widest">{{ strtoupper($proyecto->pro_categoria) }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-400 text-[9px] font-black uppercase italic opacity-60 italic ml-auto leading-none italic">
                                <i class="fas fa-calendar-check text-emerald-500 italic font-bold"></i>
                                <span class="italic tracking-widest">LANZAMIENTO: {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->translatedFormat('d M, Y') }}</span>
                            </div>
                        </div>

                        <div class="pt-10 mt-auto italic font-bold">
                            <x-button variant="primary" shadow="emerald" class="w-full justify-center py-6 rounded-2xl text-[11px] font-black uppercase italic shadow-2xl hover:scale-105 transition-all active:scale-95 italic tracking-widest leading-none italic" onclick="window.location.href='{{ route('instructor.reporte', $proyecto->pro_id) }}'">
                                <i class="fas fa-clipboard-list mr-4 italic text-xl font-bold"></i> REPORTE DE GESTIÓN ANALÍTICA
                            </x-button>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    @else
        <div class="py-48 text-center italic border-8 border-dashed border-slate-50 rounded-[5rem] group hover:border-emerald-500/10 transition-all duration-1000 bg-slate-50/30 italic mx-4 italic">
            <div class="relative inline-block italic">
                <div class="absolute inset-0 bg-slate-900/5 rounded-full blur-[100px] animate-pulse italic"></div>
                <div class="relative mb-12 inline-flex p-12 rounded-[4rem] bg-white text-slate-100 shadow-2xl ring-[30px] ring-white group-hover:scale-110 group-hover:rotate-6 transition-all duration-1000 italic">
                    <i class="fas fa-hourglass-half text-9xl text-slate-300 italic drop-shadow-2xl font-bold"></i>
                </div>
            </div>
            <h3 class="text-5xl font-black text-slate-800 tracking-tighter uppercase italic leading-none mb-6 italic">Archivo Vacante</h3>
            <p class="text-slate-400 font-bold text-[11px] uppercase tracking-[0.4em] max-w-sm mx-auto italic opacity-70 italic leading-relaxed italic">SU BÓVEDA HISTÓRICA NO DISPONE DE REGISTROS HASTA QUE LAS MISIONES SEAN CONSOLIDADAS EN EL SISTEMA.</p>
        </div>
    @endif
</div>
@endsection
