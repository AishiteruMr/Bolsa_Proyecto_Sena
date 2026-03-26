@extends('layouts.dashboard')

@section('title', 'Centro de Operaciones | ' . (session('nombre') ?? 'Aprendiz'))

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
    
    <!-- Premium Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 px-4 italic">
        <div class="space-y-6 italic">
            <div class="flex items-center gap-4 italic">
                <x-badge class="bg-emerald-500 text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic shadow-2xl shadow-emerald-500/20 italic">
                    PASAPORTE AL ÉXITO PROFESIONAL
                </x-badge>
                <div class="h-1 w-12 bg-slate-100 rounded-full italic"></div>
                <span class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] italic">{{ now()->translatedFormat('l, d F') }}</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">
                IMPULSA TU CARRERA, <br>
                <span class="text-emerald-600 block mt-2 text-6xl md:text-7xl">{{ session('nombre') }}</span>
            </h2>
            <p class="text-slate-400 font-bold text-lg max-w-2xl leading-relaxed uppercase italic italic opacity-70">
                Sigue construyendo tu futuro profesional participando en desafíos reales del ecosistema SENA.
            </p>
        </div>
        
        <div class="hidden lg:flex items-center gap-6 bg-slate-50 p-4 rounded-[2.5rem] border-4 border-white shadow-2xl italic">
            <div class="px-10 py-6 bg-white rounded-[2rem] shadow-xl border border-slate-50 text-center italic">
                <span class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.4em] block mb-2 italic">TU RACHA DE OPERACIONES</span>
                <span class="text-4xl font-black text-slate-900 flex items-center justify-center gap-4 italic leading-none">
                    <i class="fas fa-fire text-orange-500 italic"></i>
                     00
                </span>
            </div>
        </div>
    </div>

    <!-- BENTO DASHBOARD -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 px-4 italic">
        <!-- Hero Stat Card -->
        <x-card class="lg:col-span-2 p-12 bg-slate-900 border-none shadow-2xl relative overflow-hidden group rounded-[4rem] italic" shadow="none">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900/40 opacity-90 italic"></div>
            <!-- Kinetic Abstract patterns -->
            <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-[80px] group-hover:scale-150 transition-transform duration-[2000ms] italic"></div>
            <div class="absolute -left-10 -top-10 w-48 h-48 bg-white/5 rounded-full blur-[60px] italic"></div>

            <div class="relative flex items-center justify-between text-white italic">
                <div class="space-y-8 italic">
                    <div class="w-20 h-20 rounded-[2rem] bg-white text-emerald-600 shadow-2xl flex items-center justify-center text-4xl italic rotate-6 group-hover:rotate-0 transition-transform italic">
                        <i class="fas fa-rocket italic text-emerald-500 font-bold flex items-center justify-center"></i>
                    </div>
                    <div class="italic">
                        <h3 class="text-7xl font-black tracking-tighter italic leading-none">{{ str_pad($postulacionesAprobadas, 2, '0', STR_PAD_LEFT) }}</h3>
                        <p class="text-emerald-400 font-black text-xs uppercase tracking-[0.3em] mt-6 italic opacity-80 italic">PROYECTOS EN LOS QUE ESTÁS <br>HACIENDO HISTORIA HOY.</p>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Deadline Sentinel -->
        <x-card class="p-10 border-none shadow-2xl flex flex-col justify-between group hover:shadow-emerald-500/5 transition-all bg-white rounded-[3.5rem] italic" shadow="none">
            <div class="space-y-8 italic">
                <div class="flex items-center justify-between italic">
                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">PRÓXIMO HITO</span>
                    <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center text-lg italic rotate-12 group-hover:rotate-0 transition-transform italic">
                        <i class="fas fa-clock italic font-bold"></i>
                    </div>
                </div>
                
                @if($proximoCierre)
                    <div class="italic">
                        <h4 class="text-3xl font-black text-red-500 tracking-tighter uppercase italic leading-[0.9] italic">
                            {{ \Carbon\Carbon::parse($proximoCierre->pro_fecha_finalizacion)->diffForHumans() }}
                        </h4>
                        <p class="text-slate-900 font-black text-[10px] mt-4 uppercase tracking-[0.15em] truncate italic opacity-60 italic">{{ $proximoCierre->pro_titulo_proyecto }}</p>
                    </div>
                @else
                    <div class="space-y-3 italic">
                        <h4 class="text-3xl font-black text-slate-200 tracking-tighter uppercase italic leading-[0.9] italic">CALMA TOTAL</h4>
                        <p class="text-slate-400 font-black text-[9px] uppercase tracking-[0.3em] italic italic">SIN ENTREGAS PENDIENTES</p>
                    </div>
                @endif
            </div>

            <div class="pt-10 italic">
                <x-button variant="secondary" :href="route('aprendiz.entregas')" class="w-full py-5 rounded-[1.5rem] border-4 border-slate-50 bg-white text-slate-400 font-black text-[10px] uppercase tracking-widest group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-800 transition-all italic italic shadow-xl">
                    CENTRO DE EVIDENCIAS
                </x-button>
            </div>
        </x-card>

        <!-- Metrics Card -->
        <x-card class="p-10 border-none shadow-2xl flex flex-col justify-between group bg-white rounded-[3.5rem] italic" shadow="none">
            <div class="space-y-8 italic">
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] block italic leading-none">ÍNDICE DE APLICACIÓN</span>
                <div class="space-y-6 italic">
                    <div class="flex items-baseline gap-4 italic">
                        <span class="text-6xl font-black text-slate-900 tracking-tighter italic leading-none">{{ str_pad($totalPostulaciones, 2, '0', STR_PAD_LEFT) }}</span>
                        <x-badge class="bg-emerald-50 text-emerald-600 border-none px-4 py-1.5 rounded-full font-black text-[9px] uppercase tracking-widest italic italic italic">ENVIADAS</x-badge>
                    </div>
                    <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden p-0.5 shadow-inner italic">
                        <div class="h-full bg-emerald-500 rounded-full shadow-lg transition-all duration-1000 relative italic" style="width: 75%">
                             <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer italic"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-10 italic">
                <x-button :href="route('aprendiz.postulaciones')" class="w-full bg-slate-900 text-white border-none font-black text-[10px] uppercase tracking-[0.2em] py-5 rounded-[1.5rem] hover:bg-emerald-600 transition-all italic italic shadow-2xl">
                    GESTIONAR CANDIDATURAS
                </x-button>
            </div>
        </x-card>
    </div>

    <!-- Featured Opportunities -->
    <div class="space-y-12 px-4 italic">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 italic border-b border-slate-100 pb-10 italic">
            <div class="flex items-center gap-6 italic">
                <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-2xl shadow-emerald-500/20 italic rotate-6">
                    <i class="fas fa-sparkles text-xl font-bold italic"></i>
                </div>
                <div class="italic">
                    <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic">Oportunidades de Misión</h3>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] italic opacity-60 italic">SELECCIONADAS PARA TU PERFIL {{ session('programa') ?? 'SENA' }}</p>
                </div>
            </div>
            <x-button :href="route('aprendiz.proyectos')" variant="secondary" class="rounded-[1.5rem] border-4 border-slate-50 bg-white px-8 py-4 font-black text-[10px] uppercase tracking-widest flex items-center gap-4 group shadow-xl italic">
                EXPLORAR EL NEXO 
                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform italic text-emerald-500"></i>
            </x-button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 italic">
            @forelse($proyectosRecientes as $p)
                <x-card class="group flex flex-col border-none shadow-xl hover:shadow-2xl hover:-translate-y-3 transition-all duration-700 rounded-[3.5rem] overflow-hidden bg-white italic" shadow="none">
                    <div class="relative h-64 overflow-hidden bg-slate-900 italic">
                        <img src="{{ $p->imagen_url }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2000ms] opacity-80 italic">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                        <div class="absolute top-6 right-6">
                            <x-badge class="bg-white/10 backdrop-blur-xl text-white border-2 border-white/20 font-black text-[9px] uppercase tracking-widest px-4 py-2 rounded-xl shadow-2xl italic">
                                {{ strtoupper($p->pro_categoria) }}
                            </x-badge>
                        </div>
                    </div>

                    <div class="p-10 flex flex-col flex-1 space-y-8 italic">
                        <div class="space-y-3 italic">
                            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.3em] italic italic">{{ $p->emp_nombre }}</p>
                            <h4 class="text-xl font-black text-slate-900 leading-[1.1] uppercase italic tracking-tight group-hover:text-emerald-500 transition-colors italic">
                                {{ $p->pro_titulo_proyecto }}
                            </h4>
                        </div>
                        
                        <div class="mt-auto pt-10 border-t border-slate-50 flex items-center justify-between italic">
                            <div class="flex items-center gap-4 italic opacity-60 italic">
                                <div class="flex -space-x-3 italic">
                                    <div class="w-8 h-8 rounded-xl border-4 border-white bg-slate-900 flex items-center justify-center text-[9px] font-black text-white italic rotate-3">S</div>
                                    <div class="w-8 h-8 rounded-xl border-4 border-white bg-emerald-500 flex items-center justify-center text-[9px] font-black text-white italic -rotate-3">A</div>
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-widest italic">+12 OPERATIVOS</span>
                            </div>
                            
                            @if(in_array($p->pro_id, $proyectosAprobados))
                                <x-button :href="route('aprendiz.proyecto.detalle', $p->pro_id)" variant="primary" shadow="emerald" class="rounded-2xl px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl italic italic flex items-center gap-3">
                                    CENTRO DE ACCIÓN
                                </x-button>
                            @else
                                <x-button :href="route('aprendiz.proyecto.detalle', $p->pro_id)" variant="secondary" class="rounded-2xl px-6 py-4 border-4 border-slate-50 bg-white text-slate-400 font-black text-[10px] uppercase tracking-widest shadow-xl italic italic active:scale-95 transition-all">
                                    VER EXPEDIENTE
                                </x-button>
                            @endif
                        </div>
                    </div>
                </x-card>
            @empty
                <div class="col-span-full py-32 bg-slate-50 rounded-[4rem] border-8 border-white shadow-inner text-center space-y-10 px-12 italic">
                    <div class="w-32 h-32 rounded-[3.5rem] bg-white shadow-2xl flex items-center justify-center mx-auto text-slate-200 text-5xl rotate-12 italic">
                        <i class="fas fa-satellite-dish animate-pulse italic"></i>
                    </div>
                    <div class="space-y-4 italic">
                        <h4 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic">Rastreando Misiones...</h4>
                        <p class="text-slate-400 font-bold uppercase italic text-sm tracking-widest max-w-md mx-auto leading-relaxed italic opacity-70">Sincronizando el nexo para descubrir nuevos desafíos que transformarán tu trayectoria técnica.</p>
                    </div>
                    <x-button variant="secondary" class="bg-white border-4 border-slate-50 rounded-[2rem] px-12 py-5 font-black text-[11px] uppercase tracking-widest text-slate-400 shadow-2xl active:scale-95 transition-all italic italic">
                        RE-SINCRONIZAR PANEL
                    </x-button>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
