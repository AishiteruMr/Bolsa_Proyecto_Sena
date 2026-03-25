@extends('layouts.dashboard')

@section('title', 'Nexo de Misiones | ' . (session('nombre') ?? 'Aprendiz'))

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
    
    <!-- SEARCH HERO SECTION -->
    <x-card class="bg-slate-900 border-none rounded-[4rem] p-12 md:p-24 text-center relative overflow-hidden shadow-2xl group text-white italic" shadow="none">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900/50 opacity-90 italic"></div>
        <div class="absolute -right-20 -top-20 w-[30rem] h-[30rem] bg-emerald-500/10 rounded-full blur-[120px] group-hover:bg-emerald-500/20 transition-all duration-[2000ms] italic"></div>
        <div class="absolute -left-20 -bottom-20 w-[30rem] h-[30rem] bg-blue-500/10 rounded-full blur-[120px] italic"></div>
        
        <div class="relative space-y-12 italic">
            <div class="space-y-6 italic">
                <x-badge class="bg-emerald-500 text-white border-none px-6 py-2 rounded-full font-black tracking-[0.3em] text-[10px] shadow-2xl shadow-emerald-500/40 uppercase italic italic">
                    NEXO DE INNOVACIÓN ESTRATÉGICA
                </x-badge>
                <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-none uppercase italic italic">
                    FORJA TU DESTINO <br>
                    <span class="text-emerald-500 text-6xl md:text-8xl block mt-2">PROFESIONAL</span>
                </h2>
                <p class="text-slate-400 font-bold text-xl max-w-2xl mx-auto leading-relaxed uppercase italic italic opacity-70">
                    Conéctate con las compañías más disruptivas y aplica tus conocimientos en desafíos de alto impacto.
                </p>
            </div>

            <!-- SEARCH BAR PROTOCOL -->
            <form action="{{ route('aprendiz.proyectos') }}" method="GET" class="max-w-4xl mx-auto relative group/search italic">
                <div class="relative flex items-center bg-white p-3 rounded-[3rem] shadow-2xl ring-4 ring-white/5 focus-within:ring-emerald-500/20 transition-all italic">
                    <div class="pl-8 text-slate-300">
                        <i class="fas fa-search text-2xl italic"></i>
                    </div>
                    <input type="text" name="buscar" value="{{ request('buscar') }}" 
                           placeholder="¿CUÁL ES TU PRÓXIMO LENGUAJE DE DOMINIO? (EJ. C# / IA / WEB)" 
                           class="w-full bg-transparent border-none py-6 px-8 text-slate-900 font-black placeholder:text-slate-200 focus:ring-0 outline-none text-xl uppercase italic italic tracking-tight italic">
                    <x-button type="submit" variant="primary" shadow="emerald" class="px-12 py-6 rounded-[2.5rem] font-black text-xs uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 italic italic shadow-2xl">
                        RASTREAR
                    </x-button>
                </div>
            </form>
        </div>
    </x-card>

    <!-- FILTERS AND CATEGORIES -->
    <div class="space-y-10 px-4 italic">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 italic border-b border-slate-100 pb-10 italic">
            <div class="flex items-center gap-6 italic">
                <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-2xl italic rotate-6">
                    <i class="fas fa-filter text-xl font-bold italic"></i>
                </div>
                <div class="italic">
                    <h4 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter italic leading-none">Ecosistemas Técnicos</h4>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3 italic opacity-60 italic">FILTRADO DE MISIONES POR SECTOR</p>
                </div>
            </div>
            
            @if(request()->anyFilled(['buscar', 'categoria']))
                <a href="{{ route('aprendiz.proyectos') }}" class="group px-8 py-4 rounded-[1.5rem] bg-red-50 text-red-500 font-black text-[10px] uppercase tracking-widest flex items-center gap-4 transition-all hover:bg-red-500 hover:text-white shadow-xl italic italic">
                    <i class="fas fa-trash-can group-hover:rotate-12 transition-transform italic"></i> PURGAR PROTOCOLO
                </a>
            @endif
        </div>
        
        <div class="flex flex-wrap gap-6 italic">
            <a href="{{ route('aprendiz.proyectos', array_merge(request()->all(), ['categoria' => ''])) }}" 
               class="px-10 py-5 rounded-[1.5rem] font-black text-[10px] tracking-widest transition-all border-4 uppercase italic {{ !request('categoria') ? 'bg-slate-900 text-white border-slate-900 shadow-2xl' : 'bg-white text-slate-400 border-slate-50 hover:border-emerald-500 hover:text-emerald-500 shadow-xl' }}">
                TODOS LOS HITOS
            </a>
            @foreach($categorias as $cat)
                <a href="{{ route('aprendiz.proyectos', array_merge(request()->all(), ['categoria' => $cat])) }}" 
                   class="px-10 py-5 rounded-[1.5rem] font-black text-[10px] tracking-widest transition-all border-4 uppercase italic {{ request('categoria') == $cat ? 'bg-emerald-500 text-white border-emerald-500 shadow-2xl shadow-emerald-500/40' : 'bg-white text-slate-400 border-slate-50 hover:border-emerald-500 hover:text-emerald-500 shadow-xl' }}">
                    {{ strtoupper($cat) }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- METRICS FEEDBACK -->
    <div class="flex items-center gap-6 px-4 italic">
        <div class="flex items-center gap-4 bg-slate-900 px-8 py-4 rounded-[1.5rem] shadow-2xl italic">
            <span class="text-3xl font-black text-white tracking-tighter italic leading-none">{{ str_pad($proyectos->total(), 2, '0', STR_PAD_LEFT) }}</span>
            <div class="h-8 w-px bg-white/10 italic"></div>
            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-[0.3em] italic leading-tight italic">CONTRATOS <br>RADICADOS</span>
        </div>
        @if(request('buscar'))
            <x-badge class="bg-emerald-50 text-emerald-600 border-4 border-white px-6 py-4 rounded-[1.5rem] font-black text-[10px] uppercase tracking-widest italic shadow-xl italic">
                ESCANEO: "{{ request('buscar') }}"
            </x-badge>
        @endif
    </div>

    <!-- PROJECT GRID Dossier -->
    @if($proyectos->isEmpty())
        <div class="py-32 bg-white rounded-[4rem] border-8 border-slate-50 shadow-inner text-center space-y-12 px-12 italic">
            <div class="w-32 h-32 rounded-[3.5rem] bg-slate-900 text-white shadow-2xl flex items-center justify-center mx-auto text-5xl rotate-12 italic group">
                <i class="fas fa-radar animate-pulse italic group-hover:scale-110 transition-transform italic"></i>
            </div>
            <div class="space-y-4 italic">
                <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic">Señal No Identificada</h3>
                <p class="text-slate-400 font-bold uppercase italic text-sm tracking-widest max-w-lg mx-auto leading-relaxed italic opacity-70">No hay misiones que coincidan con tu frecuencia de búsqueda actual. Re-calibra los filtros para captar nuevas transmisiones.</p>
            </div>
            <x-button :href="route('aprendiz.proyectos')" variant="secondary" class="bg-slate-900 text-white border-none rounded-[2rem] px-16 py-6 font-black text-[11px] uppercase tracking-widest hover:bg-emerald-600 transition-all italic italic shadow-2xl active:scale-95">
                REINICIAR ESCÁNER
            </x-button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 px-4 italic">
            @foreach($proyectos as $p)
                <x-card class="group flex flex-col border-none shadow-xl hover:shadow-[0_40px_80px_-20px_rgba(16,185,129,0.15)] hover:-translate-y-4 transition-all duration-700 rounded-[3.5rem] overflow-hidden bg-white italic" shadow="none">
                    <div class="relative h-72 overflow-hidden bg-slate-900 italic">
                        <img src="{{ $p->imagen_url }}" alt="" class="w-full h-full object-cover group-hover:scale-125 transition-transform duration-[3000ms] opacity-80 italic">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                        <div class="absolute top-8 right-8">
                            <x-badge class="bg-white/10 backdrop-blur-xl text-white border-2 border-white/20 font-black text-[9px] uppercase tracking-widest px-5 py-2.5 rounded-xl shadow-2xl italic">
                                {{ strtoupper($p->pro_categoria) }}
                            </x-badge>
                        </div>
                    </div>
                    
                    <div class="p-10 flex flex-1 flex-col space-y-8 italic">
                        <div class="space-y-4 italic">
                            <div class="flex items-center gap-4 italic opacity-60 italic">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-900 italic shadow-sm italic">
                                    <i class="fas fa-building text-xs italic font-bold"></i>
                                </div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic truncate italic">{{ $p->emp_nombre }}</span>
                            </div>
                            
                            <h3 class="text-2xl font-black text-slate-900 leading-[1.1] uppercase italic tracking-tighter group-hover:text-emerald-600 transition-colors italic h-20 overflow-hidden border-l-8 border-emerald-500 pl-6 italic">
                                {{ $p->pro_titulo_proyecto }}
                            </h3>
                        </div>

                        <!-- Technical Specs Bento -->
                        <div class="flex gap-6 border-t border-slate-50 pt-8 italic">
                            <div class="flex-1 bg-slate-50 p-4 rounded-2xl border-2 border-white shadow-sm text-center italic">
                                <span class="text-[9px] font-black text-slate-300 uppercase block mb-2 italic">DURACIÓN</span>
                                <span class="text-sm font-black text-slate-900 italic tracking-widest">{{ str_pad($p->pro_duracion_estimada, 2, '0', STR_PAD_LEFT) }}D</span>
                            </div>
                            <div class="flex-1 bg-slate-50 p-4 rounded-2xl border-2 border-white shadow-sm text-center italic">
                                <span class="text-[9px] font-black text-slate-300 uppercase block mb-2 italic">OPERADORES</span>
                                <span class="text-sm font-black text-slate-900 italic tracking-widest">{{ str_pad($p->postulados_count ?? 0, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>

                        <div class="pt-6 mt-auto italic">
                            @if(in_array($p->pro_id, $postulados))
                                <div class="w-full bg-emerald-600 text-white border-none py-6 rounded-2xl text-center font-black text-[10px] uppercase tracking-[0.3em] italic flex items-center justify-center gap-4 shadow-2xl shadow-emerald-500/20 italic">
                                    <i class="fas fa-shield-check text-xl italic font-bold"></i> MISIÓN RADICADA
                                </div>
                            @else
                                <form action="{{ route('aprendiz.postular', $p->pro_id) }}" method="POST" class="italic">
                                    @csrf
                                    <x-button type="submit" variant="primary" shadow="emerald" class="w-full py-6 rounded-[1.5rem] font-black text-[10px] uppercase tracking-[0.2em] flex items-center justify-center gap-4 group/btn italic italic shadow-2xl active:scale-95 transition-all">
                                        SOLICITAR ACCESO 
                                        <i class="fas fa-bolt group-hover/btn:rotate-12 transition-transform italic text-white flex items-center justify-center font-bold"></i>
                                    </x-button>
                                </form>
                            @endif
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>

        <!-- PAGINACIÓN PREMIUM -->
        <div class="mt-20 flex justify-center italic">
            <div class="pagination-premium italic">
                {{ $proyectos->withQueryString()->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
