@extends('layouts.dashboard')

@section('title', 'Nómina de Talento | ' . (session('nombre') ?? 'Instructor'))

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
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 px-4 italic">
        <div class="space-y-6 italic">
            <div class="flex items-center gap-4 italic font-bold">
                <x-badge class="bg-[#FF6B00] text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic shadow-2xl shadow-[#FF6B00]/20 italic">
                    AUDITORÍA DE TALENTO
                </x-badge>
                <div class="h-1 w-12 bg-slate-100 rounded-full italic"></div>
                <span class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] italic opacity-60 italic leading-none italic">SINCRONIZACIÓN DE EQUIPOS OPERATIVOS</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">
                NÓMINA DE <span class="text-[#FF6B00] block mt-2 text-6xl md:text-7xl">TALENTO</span>
            </h2>
        </div>

        <div class="flex items-center gap-6 italic">
            <div class="flex items-center gap-4 bg-slate-900 px-8 py-4 rounded-[1.5rem] shadow-2xl italic">
                <span class="text-4xl font-black text-white tracking-tighter italic leading-none italic">{{ str_pad($aprendices->count(), 2, '0', STR_PAD_LEFT) }}</span>
                <div class="h-10 w-px bg-white/10 italic"></div>
                <span class="text-[9px] font-black text-orange-400 uppercase tracking-[0.3em] italic leading-tight italic">TALENTOS <br>BAJO VIGILANCIA</span>
            </div>
        </div>
    </div>

    <!-- Learners Grid Dossier -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 px-4 italic">
        @forelse($aprendices as $a)
            <x-card class="group border-none shadow-2xl hover:shadow-[0_40px_80px_-20px_rgba(16,185,129,0.1)] transition-all duration-700 p-10 overflow-hidden bg-white text-center flex flex-col h-full items-center relative rounded-[3.5rem] italic" shadow="none">
                <!-- Operational Background Deco -->
                <div class="absolute -right-10 -top-10 text-[10rem] text-slate-50 opacity-10 group-hover:scale-125 group-hover:rotate-12 transition-all duration-1000 pointer-events-none italic">
                    <i class="fas fa-user-graduate italic"></i>
                </div>

                <div class="mb-10 flex justify-center relative italic">
                    <div class="w-32 h-32 rounded-[3rem] bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-2xl flex items-center justify-center font-black group-hover:rotate-6 group-hover:scale-110 transition-all duration-700 italic border-4 border-white italic">
                        <span class="text-5xl font-black italic tracking-tighter italic leading-none italic">{{ strtoupper(substr($a->apr_nombre ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-12 h-12 rounded-2xl bg-[#FF6B00] shadow-2xl flex items-center justify-center text-white border-4 border-white italic rotate-12 group-hover:rotate-0 transition-transform italic shadow-[#FF6B00]/20 italic">
                        <i class="fas fa-certificate text-xl italic font-bold"></i>
                    </div>
                </div>
                
                <h4 class="text-2xl font-black text-slate-900 group-hover:text-[#E65100] transition-colors uppercase italic tracking-tighter italic leading-none italic">{{ $a->apr_nombre }} <br> {{ $a->apr_apellido }}</h4>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] mt-5 italic transparency-60 italic leading-tight italic">{{ strtoupper($a->apr_programa ?? 'TÉCNICO OPERATIVO') }}</p>
                
                <div class="mt-10 pt-10 border-t border-slate-50 w-full space-y-5 italic font-bold">
                    <div class="flex items-center justify-center gap-4 bg-slate-50 p-4 rounded-2xl border-2 border-white italic">
                        <i class="fas fa-id-card text-[#FF6B00] italic font-bold"></i>
                        <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest italic leading-none italic">{{ $a->usr_documento }}</span>
                    </div>
                    <div class="flex items-center justify-center gap-4 text-[10px] text-slate-400 font-black lowercase tracking-widest italic opacity-60 italic">
                        <i class="fas fa-envelope text-[#FF6B00] italic font-bold"></i>
                        <span class="truncate max-w-[180px] italic leading-none italic">{{ $a->usr_correo ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="mt-auto pt-10 w-full italic">
                    <div class="p-6 rounded-[2rem] bg-slate-900 text-white text-[9px] font-black uppercase tracking-[0.3em] leading-relaxed group-hover:bg-[#E65100] transition-all italic shadow-2xl shadow-slate-200/50 italic border-2 border-white/5 italic">
                        <span class="block text-white/30 text-[8px] mb-2 italic opacity-50 italic">PROTOCOLO ACTIVO</span>
                        <span class="truncate block italic italic leading-none italic">{{ strtoupper($a->pro_titulo_proyecto ?? 'SIN ASIGNACIÓN') }}</span>
                    </div>
                </div>
            </x-card>
        @empty
            <div class="col-span-full py-48 italic text-center text-slate-200 font-black uppercase tracking-[0.4em] text-lg opacity-40 italic border-8 border-dashed border-slate-50 rounded-[4rem] bg-slate-50/50 italic">
                <div class="relative inline-block italic">
                    <div class="absolute inset-0 bg-[#FF6B00]/5 rounded-full blur-[100px] animate-pulse italic"></div>
                    <i class="fas fa-user-astronaut text-8xl mb-10 block italic animate-bounce italic font-bold"></i>
                </div>
                <h3 class="text-3xl font-black text-slate-300 uppercase italic tracking-tighter italic">Sin Señales en Radar</h3>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] mt-6 max-w-sm mx-auto italic opacity-60 italic leading-relaxed italic">SU NÓMINA DE TALENTO ESTÁ ACTUALMENTE VACANTE EN ESTE SECTOR OPERATIVO.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
