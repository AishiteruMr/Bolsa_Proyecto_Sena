@extends('layouts.dashboard')

@section('title', 'Centro de Mando Corporativo | ' . (session('nombre') ?? 'Empresa'))

@section('sidebar-nav')
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic text-slate-400">OPERACIÓN TÉCNICA</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item group {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Centro de Mando</span>
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item group {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram group-hover:rotate-12 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Mis Proyectos</span>
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item group {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Lanzar Misión</span>
    </a>
    
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mt-6 mb-2 block italic text-slate-400">CONFIGURACIÓN</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item group {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building group-hover:rotate-12 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Perfil Corporativo</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-24 italic font-bold">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 px-4 italic font-bold">
        <div class="space-y-6 italic">
            <div class="flex items-center gap-4 italic font-bold">
                <x-badge class="bg-emerald-500 text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic shadow-2xl shadow-emerald-500/20 italic">
                    NODO ESTRATÉGICO
                </x-badge>
                <div class="h-1 w-12 bg-slate-100 rounded-full italic"></div>
                <span class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] italic opacity-60 italic leading-none">TERMINAL DE GESTIÓN CORPORATIVA</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black text-slate-900 tracking-tighter uppercase italic leading-[0.9] italic">
                CENTRO DE <br> <span class="text-emerald-500 text-6xl md:text-8xl block mt-2">ALIANZAS</span>
            </h2>
            <p class="text-slate-400 font-black text-sm uppercase tracking-[0.4em] italic opacity-70 italic truncate italic">
                BIENVENIDO/A: <span class="text-slate-900 font-black">{{ strtoupper(session('nombre')) }}</span>
            </p>
        </div>
        <x-button variant="primary" :href="route('empresa.proyectos.crear')" shadow="emerald" class="py-7 px-14 rounded-[2.5rem] group flex items-center gap-5 text-[11px] font-black uppercase italic shadow-2xl active:scale-95 transition-all text-white tracking-widest italic">
            <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform duration-500 italic text-xl"></i>
            LANZAR NUEVA MISIÓN
        </x-button>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 px-4 italic font-bold">
        <x-card class="p-10 bg-slate-900 text-white border-none shadow-2xl relative overflow-hidden group rounded-[3.5rem] italic" shadow="none">
            <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-1000 italic ring-8 ring-white/5 italic"></div>
            <div class="relative z-10 space-y-4 italic">
                <h3 class="text-6xl font-black italic tracking-tighter leading-none italic">{{ str_pad($totalProyectos, 2, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-[9px] font-black uppercase tracking-[0.4em] text-emerald-400 italic opacity-80 italic leading-none">MISIONES TOTALES</p>
            </div>
        </x-card>

        <x-card class="p-10 border-4 border-white bg-white shadow-2xl group hover:shadow-emerald-500/10 transition-all duration-700 rounded-[3.5rem] italic" shadow="none">
            <div class="space-y-4 italic font-bold">
                <h3 class="text-6xl font-black text-slate-900 tracking-tighter group-hover:text-emerald-600 transition-colors leading-none italic">{{ str_pad($proyectosActivos, 2, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-300 italic opacity-80 italic leading-none">EN EJECUCIÓN</p>
            </div>
        </x-card>

        <x-card class="p-10 border-4 border-white bg-white shadow-2xl group hover:shadow-blue-500/10 transition-all duration-700 rounded-[3.5rem] italic" shadow="none">
            <div class="space-y-4 italic font-bold">
                <h3 class="text-6xl font-black text-slate-900 tracking-tighter group-hover:text-blue-600 transition-colors leading-none italic">{{ str_pad($totalPostulaciones, 2, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-300 italic opacity-80 italic leading-none">CANDIDATOS REGISTRADOS</p>
            </div>
        </x-card>

        <x-card class="p-10 border-4 border-white bg-white shadow-2xl group hover:shadow-amber-500/10 transition-all duration-700 rounded-[3.5rem] italic" shadow="none">
            <div class="space-y-4 italic font-bold">
                <h3 class="text-6xl font-black text-amber-500 tracking-tighter leading-none italic">{{ str_pad($postulacionesPendientes, 2, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-300 italic opacity-80 italic leading-none">NUEVAS SOLICITUDES</p>
            </div>
        </x-card>
    </div>

    <!-- Recent Projects Section -->
    <div class="px-4 italic font-bold">
        <x-card class="p-0 border-none shadow-2xl rounded-[4rem] overflow-hidden bg-white group italic" shadow="none">
            <div class="p-10 md:p-14 bg-slate-50 border-b-4 border-white flex flex-col md:flex-row justify-between items-center gap-10 italic">
                <div class="flex items-center gap-8 italic font-bold">
                    <div class="w-16 h-16 rounded-[1.5rem] bg-emerald-500 text-white flex items-center justify-center text-3xl shadow-2xl shadow-emerald-500/30 rotate-6 group-hover:rotate-0 transition-transform italic border-4 border-white italic">
                        <i class="fas fa-rocket italic font-bold"></i>
                    </div>
                    <div class="italic">
                        <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter leading-none italic">Actividad de Misión</h3>
                        <p class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] mt-3 italic opacity-60 italic leading-none">GESTIÓN DEL IMPACTO CORPORATIVO</p>
                    </div>
                </div>
                <x-button variant="secondary" :href="route('empresa.proyectos')" class="text-[10px] font-black px-10 py-5 rounded-2xl border-4 border-white shadow-xl hover:bg-slate-900 hover:text-white transition-all uppercase tracking-widest italic leading-none italic">
                    AUDITAR PORTAFOLIO <i class="fas fa-arrow-right ml-4 group-hover:translate-x-2 transition-transform italic"></i>
                </x-button>
            </div>

            <div class="overflow-x-auto italic font-bold">
                <table class="w-full text-left italic">
                    <thead>
                        <tr class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] border-b-2 border-slate-50 italic">
                            <th class="px-12 py-8 italic font-bold">IDENTIFICADOR DE PROPUESTA</th>
                            <th class="px-10 py-8 italic font-bold">SECTOR</th>
                            <th class="px-10 py-8 text-center italic font-bold">ESTADO OPERATIVO</th>
                            <th class="px-10 py-8 text-center italic font-bold">ENGAGEMENT</th>
                            <th class="px-12 py-8 text-right italic font-bold">COMANDO</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-4 divide-slate-50 italic">
                        @forelse($proyectosRecientes as $p)
                            <tr class="group/row hover:bg-emerald-50/30 transition-all duration-500 italic">
                                <td class="px-12 py-10 italic">
                                    <div class="space-y-2 italic font-bold">
                                        <p class="font-black text-xl text-slate-900 group-hover/row:text-emerald-600 transition-colors leading-tight italic truncate max-w-[300px] uppercase tracking-tighter italic">
                                            {{ $p->pro_titulo_proyecto }}
                                        </p>
                                        <div class="flex items-center gap-4 text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] italic opacity-60 italic">
                                            <i class="far fa-calendar-alt text-emerald-500 italic font-bold"></i>
                                            <span>EMITIDO: {{ \Carbon\Carbon::parse($p->pro_fecha_publi)->translatedFormat('d M, Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-10 italic">
                                    <x-badge class="bg-white text-slate-500 border-none px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest italic shadow-sm italic leading-none italic">
                                        {{ strtoupper($p->pro_categoria) }}
                                    </x-badge>
                                </td>
                                <td class="px-10 py-10 text-center italic">
                                    @php
                                        $statusColor = match($p->pro_estado) {
                                            'Activo', 'Aprobado', 'Ejecución' => 'bg-emerald-500 shadow-emerald-500/20',
                                            'Pendiente' => 'bg-amber-500 shadow-amber-500/20',
                                            'Cerrado', 'Rechazado' => 'bg-red-500 shadow-red-500/20',
                                            default => 'bg-slate-500 shadow-slate-500/20'
                                        };
                                    @endphp
                                    <x-badge class="{{ $statusColor }} text-white border-none py-2 px-6 rounded-xl text-[9px] font-black italic shadow-2xl uppercase tracking-widest italic leading-none italic">
                                        {{ strtoupper($p->pro_estado) }}
                                    </x-badge>
                                </td>
                                <td class="px-10 py-10 text-center italic">
                                    <div class="inline-flex flex-col items-center italic font-bold">
                                        <span class="text-3xl font-black text-slate-900 group-hover/row:text-emerald-600 transition-colors italic tracking-tighter leading-none italic">{{ str_pad($p->postulaciones_count, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-[8px] font-black text-slate-300 uppercase tracking-[0.4em] mt-3 italic opacity-80 italic leading-none italic">TALENTOS</span>
                                    </div>
                                </td>
                                <td class="px-12 py-10 text-right italic font-bold">
                                    <a href="{{ route('empresa.proyectos.edit', $p->pro_id) }}" 
                                       class="inline-flex items-center justify-center w-12 h-12 rounded-[1.25rem] bg-white border-2 border-slate-50 text-slate-300 hover:border-emerald-500 hover:text-emerald-600 shadow-xl transition-all hover:scale-115 hover:rotate-6 active:scale-95 italic font-bold">
                                        <i class="fas fa-terminal text-lg italic font-bold"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-12 py-32 text-center italic font-bold">
                                    <div class="space-y-8 italic">
                                        <div class="relative inline-block italic">
                                            <div class="absolute inset-0 bg-slate-100 rounded-full blur-[80px] animate-pulse italic"></div>
                                            <div class="relative w-24 h-24 rounded-[2rem] bg-white border-4 border-slate-50 text-slate-200 flex items-center justify-center mx-auto shadow-2xl italic">
                                                <i class="fas fa-cube text-4xl italic font-bold opacity-30 italic"></i>
                                            </div>
                                        </div>
                                        <div class="space-y-4 italic">
                                            <p class="text-slate-300 font-black uppercase tracking-[0.4em] text-[10px] italic leading-none">SIN REGISTROS ACTIVOS</p>
                                            <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter leading-none italic">Su Bóveda de Actividad está Vacía</h3>
                                        </div>
                                        <x-button variant="primary" :href="route('empresa.proyectos.crear')" class="rounded-2xl px-12 py-6 text-[10px] font-black uppercase tracking-widest italic shadow-2xl shadow-emerald-500/10 italic">
                                            SITUAR PRIMER PROYECTO <i class="fas fa-rocket ml-4 italic"></i>
                                        </x-button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>
@endsection
