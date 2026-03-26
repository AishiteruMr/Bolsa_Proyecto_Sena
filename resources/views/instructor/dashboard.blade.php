@extends('layouts.dashboard')

@section('title', 'Centro de Mando | ' . (session('nombre') ?? 'Instructor'))

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
            <div class="flex items-center gap-4 italic">
                <x-badge class="bg-[#FF6B00] text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic shadow-2xl shadow-[#FF6B00]/20 italic">
                    INSTRUCTOR ESTRATÉGICO SENA
                </x-badge>
                <div class="h-1 w-12 bg-slate-100 rounded-full italic"></div>
                <span class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] italic">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">
                PANEL DE <span class="text-[#FF6B00] block mt-2 text-6xl md:text-7xl">CONTROL</span>
            </h2>
            <p class="text-slate-400 font-bold text-lg max-w-2xl leading-relaxed uppercase italic italic opacity-70">
                Sincronización táctica de talento humano e industria tecnológica.
            </p>
        </div>
    </div>

    <!-- Stats Bento Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 px-4 italic">
        <!-- Projects Stat -->
        <x-card class="group bg-slate-900 border-none shadow-2xl p-10 relative overflow-hidden transition-all hover:shadow-[#FF6B00]/10 rounded-[3.5rem] italic" shadow="none">
            <div class="absolute -right-12 -bottom-12 text-[12rem] text-white/5 transform -rotate-12 group-hover:rotate-0 transition-transform duration-1000 pointer-events-none italic">
                <i class="fas fa-project-diagram italic"></i>
            </div>
            <div class="relative z-10 space-y-8 italic">
                <div class="w-16 h-16 rounded-[1.5rem] bg-[#FF6B00]/20 flex items-center justify-center text-orange-400 text-2xl italic shadow-inner border border-[#FF6B00]/10 italic">
                    <i class="fas fa-rocket italic font-bold"></i>
                </div>
                <div class="italic">
                    <h3 class="text-6xl font-black text-white italic tracking-tighter leading-none italic">{{ str_pad($proyectosAsignados, 2, '0', STR_PAD_LEFT) }}</h3>
                    <p class="text-[#FF6B00] font-black text-[10px] uppercase tracking-[0.4em] italic mt-4 italic opacity-80 italic">PROYECTOS VINCULADOS</p>
                </div>
            </div>
        </x-card>

        <!-- Aprendices Stat -->
        <x-card class="group border-none shadow-2xl p-10 relative overflow-hidden transition-all bg-white rounded-[3.5rem] italic" shadow="none">
            <div class="absolute -right-12 -bottom-12 text-[12rem] text-slate-50 transform -rotate-12 group-hover:rotate-0 transition-transform duration-1000 pointer-events-none italic opacity-50">
                <i class="fas fa-user-graduate italic"></i>
            </div>
            <div class="relative z-10 space-y-8 italic">
                <div class="w-16 h-16 rounded-[1.5rem] bg-slate-50 flex items-center justify-center text-slate-900 text-2xl italic shadow-sm border-4 border-white italic">
                    <i class="fas fa-users italic font-bold"></i>
                </div>
                <div class="italic">
                    <h3 class="text-6xl font-black text-slate-900 italic tracking-tighter leading-none italic">{{ str_pad($totalAprendices, 2, '0', STR_PAD_LEFT) }}</h3>
                    <p class="text-slate-400 font-black text-[10px] uppercase tracking-[0.4em] italic mt-4 italic opacity-60 italic">APRENDICES A CARGO</p>
                </div>
            </div>
        </x-card>

        <!-- Evidencias Stat -->
        <x-card class="group bg-[#E65100] border-none shadow-2xl shadow-[#FF6B00]/20 p-10 relative overflow-hidden transition-all hover:bg-orange-700 rounded-[3.5rem] italic" shadow="none">
            <div class="absolute -right-12 -bottom-12 text-[12rem] text-white/10 transform rotate-12 group-hover:rotate-6 transition-transform duration-1000 pointer-events-none italic">
                <i class="fas fa-file-signature italic"></i>
            </div>
            <div class="relative z-10 h-full flex flex-col justify-between italic">
                <div class="space-y-8 italic">
                    <div class="w-16 h-16 rounded-[1.5rem] bg-white/20 flex items-center justify-center text-white text-2xl shadow-inner backdrop-blur-md border border-white/10 italic">
                        <i class="fas fa-check-double italic font-bold"></i>
                    </div>
                    <div class="italic">
                        <h3 class="text-6xl font-black text-white italic tracking-tighter leading-none italic">{{ str_pad($evidenciasPendientes, 2, '0', STR_PAD_LEFT) }}</h3>
                        <p class="text-white/80 text-[10px] font-black uppercase tracking-[0.4em] italic mt-4 italic">EVIDENCIAS PENDIENTES</p>
                    </div>
                </div>
                <div class="pt-8 border-t border-white/10 mt-6 italic">
                    <a href="{{ route('instructor.proyectos') }}" class="text-[9px] font-black text-white uppercase tracking-[0.3em] flex items-center gap-4 group/link italic italic">
                        ACCIÓN REQUERIDA <i class="fas fa-arrow-right group-hover/link:translate-x-2 transition-transform italic"></i>
                    </a>
                </div>
            </div>
        </x-card>

        <!-- Active Stat -->
        <x-card class="group border-none shadow-2xl p-10 relative overflow-hidden transition-all bg-white rounded-[3.5rem] italic" shadow="none">
            <div class="relative z-10 space-y-10 italic">
                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic border-b border-slate-100 pb-4 italic">RESUMEN DE RADAR</p>
                <div class="space-y-6 italic">
                    <div class="flex justify-between items-center italic">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">NUEVOS HOY</span>
                        <x-badge class="bg-orange-50 text-[#E65100] border-none text-[10px] font-black rounded-lg px-3 py-1 italic italic">
                            +{{ str_pad($nuevasPostulaciones, 2, '0', STR_PAD_LEFT) }}
                        </x-badge>
                    </div>
                    <div class="flex justify-between items-center italic">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">PRÓXIMO CIERRE</span>
                        <span class="text-[10px] font-black text-slate-900 uppercase italic opacity-80 italic">
                            {{ $proximoCierre ? $proximoCierre->pro_fecha_finalizacion->diffForHumans() : 'NINGUNO' }}
                        </span>
                    </div>
                </div>
                <div class="pt-6 mt-auto italic">
                    <div class="w-full bg-slate-50 h-3 rounded-full overflow-hidden p-1 shadow-inner italic">
                        <div class="bg-[#FF6B00] h-full w-2/3 rounded-full shadow-lg shadow-[#FF6B00]/20 italic"></div>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Active Projects Section -->
    <div class="space-y-12 px-4 italic">
        <div class="flex items-center justify-between italic border-b border-slate-100 pb-10 italic">
            <div class="flex items-center gap-6 italic">
                <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-2xl italic rotate-6">
                    <i class="fas fa-project-diagram text-xl font-bold italic"></i>
                </div>
                <div class="italic">
                    <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic leading-none">Frente de Operaciones</h3>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3 italic opacity-60 italic">GESTIÓN DE PROYECTOS BAJO SUPERVISIÓN TÉCNICA</p>
                </div>
            </div>
            <a href="{{ route('instructor.proyectos') }}" class="group px-8 py-4 rounded-[1.5rem] bg-white border-4 border-slate-50 text-slate-400 font-black text-[10px] uppercase tracking-widest flex items-center gap-4 transition-all hover:bg-slate-900 hover:text-white shadow-xl italic italic">
                VER EL NEXO COMPLETO <i class="fas fa-external-link group-hover:rotate-12 transition-transform italic text-[#FF6B00]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 italic">
            @forelse($proyectos as $p)
                <x-card class="group border-none shadow-xl hover:shadow-2xl transition-all duration-700 p-0 overflow-hidden bg-white rounded-[3.5rem] italic" shadow="none">
                    <div class="p-10 space-y-10 italic">
                        <div class="flex justify-between items-start gap-6 italic">
                            <span class="bg-slate-900 text-white px-5 py-2 rounded-xl text-[9px] font-black tracking-widest uppercase italic shadow-2xl italic">PRO-{{ $p->pro_id }}</span>
                            <x-badge class="bg-orange-50 text-[#E65100] border-none py-2 px-5 text-[9px] font-black uppercase tracking-widest italic shadow-sm italic ring-1 ring-orange-100 italic">{{ strtoupper($p->pro_categoria) }}</x-badge>
                        </div>
                        
                        <div class="italic">
                            <h4 class="text-2xl font-black text-slate-900 uppercase tracking-tighter italic leading-none group-hover:text-[#E65100] transition-colors italic">{{ $p->pro_titulo_proyecto }}</h4>
                            <div class="flex items-center gap-4 mt-6 italic opacity-60 italic">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#FF6B00] italic shadow-sm italic">
                                    <i class="fas fa-building text-xs italic font-bold"></i>
                                </div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-black italic truncate italic">
                                    {{ $p->empresa?->emp_nombre ?? 'ASOCIACIÓN TÉCNICA' }}
                                </p>
                            </div>
                        </div>

                        <!-- Technical Specs Bento -->
                        <div class="grid grid-cols-2 gap-6 italic">
                            <div class="bg-slate-50 p-6 rounded-[2rem] border-4 border-white shadow-xl text-center italic transition-colors group-hover:bg-orange-50/30 italic">
                                <span class="block text-3xl font-black text-slate-900 italic leading-none italic">{{ str_pad($p->postulaciones->where('pos_estado', 'Aprobada')->count(), 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-[9px] text-slate-300 font-black uppercase tracking-widest mt-3 block italic opacity-60 italic">ADMITIDOS</span>
                            </div>
                            <div class="bg-slate-50 p-6 rounded-[2rem] border-4 border-white shadow-xl text-center italic transition-colors group-hover:bg-blue-50/30 italic">
                                <span class="block text-3xl font-black text-slate-900 italic leading-none italic">{{ str_pad($p->postulaciones->where('pos_estado', 'Pendiente')->count(), 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-[9px] text-slate-300 font-black uppercase tracking-widest mt-3 block italic opacity-60 italic">EN RADAR</span>
                            </div>
                        </div>

                        <x-button href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" variant="secondary" class="w-full py-6 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.2em] shadow-xl border-4 border-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white hover:border-slate-800 transition-all italic active:scale-95 italic italic">
                            COORDENADAS TÉCNICAS
                        </x-button>
                    </div>
                </x-card>
            @empty
                <div class="col-span-full py-40 italic text-center text-slate-200 font-black uppercase tracking-[0.4em] text-lg opacity-40 italic border-8 border-dashed border-slate-50 rounded-[4rem] bg-slate-50/50 italic">
                    <i class="fas fa-ghost text-8xl mb-8 block italic animate-pulse italic"></i>
                    Sin Misiones Bajo Supervisión
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
