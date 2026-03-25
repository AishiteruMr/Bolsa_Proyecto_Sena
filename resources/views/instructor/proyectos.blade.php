@extends('layouts.dashboard')

@section('title', 'Laboratorio de Proyectos | ' . (session('nombre') ?? 'Instructor'))

@section('sidebar-nav')
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic text-slate-400">OPERACIÓN TÉCNICA</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item group {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Centro de Mando</span>
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item group {{ request()->routeIs('instructor.proyectos') ? 'active' : '' }}">
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
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 px-4 italic font-bold">
        <div class="space-y-6 italic">
            <div class="flex items-center gap-4 italic font-bold">
                <x-badge class="bg-emerald-500 text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic shadow-2xl shadow-emerald-500/20 italic">
                    ORQUESTACIÓN OPERATIVA
                </x-badge>
                <div class="h-1 w-12 bg-slate-100 rounded-full italic"></div>
                <span class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] italic opacity-60 italic leading-none">GESTIÓN ESTRATÉGICA DE MISIONES ACTIVAS</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">
                MIS <span class="text-emerald-500 block mt-2 text-6xl md:text-7xl italic">PROYECTOS</span>
            </h2>
        </div>

        <div class="flex items-center gap-6 italic">
            <div class="bg-slate-900 px-8 py-5 rounded-[2rem] shadow-2xl flex items-center gap-5 border-2 border-white/5 italic">
                <span class="text-4xl font-black text-emerald-400 tracking-tighter leading-none italic">{{ str_pad($proyectos->count(), 2, '0', STR_PAD_LEFT) }}</span>
                <div class="h-10 w-px bg-white/10 italic"></div>
                <span class="text-[9px] font-black text-white/40 uppercase tracking-[0.4em] leading-tight italic">PROTOCOLOS <br>EN VIGOR</span>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 px-4 italic">
        @forelse($proyectos as $p)
            <x-card class="group border-none shadow-2xl hover:shadow-emerald-500/10 transition-all duration-700 p-0 overflow-hidden bg-white flex flex-col h-full rounded-[4rem] italic" shadow="none">
                <!-- Project Image/Banner with Bento Styling -->
                <div class="relative h-64 md:h-72 overflow-hidden italic">
                    <img src="{{ $p->imagen_url ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=800' }}" 
                         alt="{{ $p->pro_titulo_proyecto }}" 
                         class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110 group-hover:rotate-1 italic">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-90 italic"></div>
                    
                    <div class="absolute top-8 left-8 italic">
                        <x-badge class="bg-emerald-500/90 text-white backdrop-blur-xl border-none px-4 py-2 rounded-xl text-[10px] font-black uppercase shadow-2xl italic tracking-widest leading-none">
                            {{ strtoupper($p->pro_estado) }}
                        </x-badge>
                    </div>
                    
                    <div class="absolute bottom-8 left-8 right-8 italic">
                        <div class="flex items-center gap-3 text-white/50 text-[9px] font-black uppercase tracking-[0.3em] mb-2 italic">
                            <i class="fas fa-building text-emerald-400 italic"></i>
                            <span class="truncate italic">{{ strtoupper($p->empresa?->emp_nombre ?? 'CORPORACIÓN EXTERNA') }}</span>
                        </div>
                        <h4 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none truncate italic shadow-2xl">{{ $p->pro_titulo_proyecto }}</h4>
                    </div>
                </div>

                <div class="p-10 flex-1 flex flex-col space-y-8 italic font-bold">
                    <div class="flex flex-wrap gap-4 italic">
                        <x-badge class="bg-slate-50 text-slate-400 border-2 border-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest italic shadow-sm italic leading-none">
                            <i class="fas fa-tag mr-2 text-emerald-500 italic"></i> {{ strtoupper($p->pro_categoria ?? 'TÉCNICO') }}
                        </x-badge>
                        <x-badge class="bg-slate-50 text-slate-400 border-2 border-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest italic shadow-sm italic leading-none">
                            <i class="fas fa-calendar-alt mr-2 text-emerald-500 italic"></i> {{ \Carbon\Carbon::parse($p->pro_fecha_publi)->translatedFormat('d M, Y') }}
                        </x-badge>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mt-auto italic">
                        <div class="bg-slate-900 p-6 rounded-[2rem] border-4 border-slate-50 shadow-2xl italic group-hover:bg-emerald-600 transition-colors duration-700">
                            <span class="block text-3xl font-black text-emerald-400 group-hover:text-white italic tracking-tighter leading-none italic">{{ str_pad($p->total_aprendices ?? $p->postulaciones->count(), 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-[8px] text-white/30 font-black uppercase tracking-[0.3em] mt-2 block italic leading-none">TALENTOS</span>
                        </div>
                        <x-button href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" variant="primary" shadow="emerald" class="py-6 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.3em] shadow-2xl hover:scale-105 active:scale-95 transition-all italic leading-none flex items-center justify-center">
                            GESTIONAR <i class="fas fa-chevron-right ml-3 text-[9px] font-bold"></i>
                        </x-button>
                    </div>
                </div>
            </x-card>
        @empty
            <div class="col-span-full py-48 italic text-center text-slate-200 font-black uppercase tracking-[0.4em] text-lg opacity-40 italic border-8 border-dashed border-slate-50 rounded-[5rem] bg-slate-50/50 italic font-bold">
                <div class="relative inline-block italic">
                    <div class="absolute inset-0 bg-emerald-500/5 rounded-full blur-[100px] animate-pulse italic"></div>
                    <i class="fas fa-terminal text-9xl mb-12 block italic animate-bounce italic font-bold"></i>
                </div>
                <h3 class="text-4xl font-black text-slate-300 tracking-tighter uppercase italic leading-none mb-6">Sin Protocolos Activos</h3>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] max-w-sm mx-auto italic opacity-60 italic leading-relaxed">SU LABORATORIO ESTRATÉGICO NO REGISTRA MISIONES BAJO VIGILANCIA EN ESTE CICLO OPERATIVO.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection