@extends('layouts.dashboard')

@section('title', 'Expediente de Misión | ' . ($proyecto->pro_titulo_proyecto ?? 'Detalle'))

@section('sidebar-nav')
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic text-slate-400">OPERACIÓN ACADÉMICA</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item group {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Panel de Control</span>
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item group {{ request()->routeIs('aprendiz.proyectos*') ? 'active' : '' }}">
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
    
    <!-- HEADER SECTION -->
    <div class="space-y-8 px-4 italic">
        <div class="flex items-center gap-4 italic">
            <x-button variant="secondary" :href="route('aprendiz.postulaciones')" class="rounded-[1.5rem] px-8 py-4 border-4 border-slate-50 bg-white text-slate-400 font-black text-[10px] uppercase tracking-widest flex items-center gap-4 group shadow-xl italic active:scale-95 transition-all">
                <i class="fas fa-arrow-left group-hover:-translate-x-2 transition-transform italic text-emerald-500"></i>
                RETORNO AL PANEL
            </x-button>
        </div>
        
        <div class="space-y-4 italic">
            <div class="flex items-center gap-4 italic">
                <x-badge class="bg-emerald-500 text-white border-none px-6 py-1.5 rounded-full font-black tracking-[0.2em] text-[9px] uppercase italic italic shadow-lg shadow-emerald-500/20 italic">
                    EXPEDIENTE OPERATIVO
                </x-badge>
                <div class="h-1 w-12 bg-slate-100 rounded-full italic"></div>
                <span class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] italic">MODO: AUDITORÍA TÉCNICA</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">
                {{ $proyecto->pro_titulo_proyecto }}
            </h2>
            <p class="text-slate-400 font-black text-sm uppercase tracking-[0.3em] flex items-center gap-4 italic opacity-70 italic">
                Centro de Operaciones y Control de Entregas Estratégicas
            </p>
        </div>
    </div>

    <!-- BENTO GRID STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 px-4 italic">
        <x-card class="p-10 border-none shadow-2xl relative overflow-hidden group bg-white rounded-[3rem] italic" shadow="none">
            <div class="absolute top-0 left-0 w-3 h-full bg-emerald-500 italic"></div>
            <div class="space-y-6 italic">
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">ESTATUS DE MISIÓN</span>
                <div class="flex items-center justify-between italic">
                    <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic leading-none">{{ $proyecto->pro_estado }}</h3>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl italic shadow-inner italic rotate-12 group-hover:rotate-0 transition-transform italic">
                        <i class="fas fa-satellite italic font-bold"></i>
                    </div>
                </div>
            </div>
        </x-card>
        
        <x-card class="p-10 border-none shadow-2xl relative overflow-hidden group bg-white rounded-[3rem] italic" shadow="none">
            <div class="absolute top-0 left-0 w-3 h-full bg-slate-900 italic"></div>
            <div class="space-y-6 italic">
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">CORPORACIÓN ALIADA</span>
                <div class="flex items-center justify-between italic">
                    <h3 class="text-2xl font-black text-slate-700 uppercase italic tracking-tighter italic leading-none truncate pr-4">{{ $proyecto->emp_nombre }}</h3>
                    <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-900 flex items-center justify-center text-xl italic shadow-inner italic -rotate-12 group-hover:rotate-0 transition-transform italic">
                        <i class="fas fa-building-columns italic font-bold"></i>
                    </div>
                </div>
            </div>
        </x-card>

        <x-card class="p-10 border-none shadow-2xl relative overflow-hidden group bg-white rounded-[3rem] italic" shadow="none">
            <div class="absolute top-0 left-0 w-3 h-full bg-amber-500 italic"></div>
            <div class="space-y-6 italic">
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">SUPERVISOR TÉCNICO</span>
                <div class="flex items-center justify-between italic">
                    <h3 class="text-2xl font-black text-slate-700 uppercase italic tracking-tighter italic leading-none truncate pr-4 italic">{{ $proyecto->instructor_nombre }}</h3>
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl italic shadow-inner italic rotate-3 group-hover:rotate-0 transition-transform italic">
                        <i class="fas fa-user-shield italic font-bold"></i>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 px-4 italic">
        <!-- Main Info & Stages -->
        <div class="lg:col-span-2 space-y-16 italic">
            
            <!-- BRIEFING DOSSIER -->
            <x-card class="p-12 md:p-16 border-none shadow-2xl relative overflow-hidden bg-white rounded-[4rem] italic" shadow="none">
                <div class="absolute -right-20 -top-20 w-96 h-96 bg-slate-50 rounded-full blur-[100px] opacity-60 italic"></div>
                
                <div class="relative space-y-12 italic">
                    <div class="flex items-center justify-between border-b border-slate-50 pb-10 italic">
                        <div class="flex items-center gap-6 italic">
                            <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-2xl italic rotate-6">
                                <i class="fas fa-compass text-xl font-bold italic"></i>
                            </div>
                            <div class="italic">
                                <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic leading-none">Briefing de Misión</h3>
                                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3 italic opacity-60 italic">ESPECIFICACIONES DEL OBJETIVO</p>
                            </div>
                        </div>
                        <x-badge class="bg-emerald-50 text-emerald-600 border-none px-6 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest italic shadow-sm italic ring-1 ring-emerald-100 italic">
                            {{ strtoupper($proyecto->pro_categoria) }}
                        </x-badge>
                    </div>
                    
                    <p class="text-slate-500 font-bold text-xl leading-relaxed text-justify uppercase italic italic opacity-80 italic">
                        {{ $proyecto->pro_descripcion }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-slate-50 italic">
                        <div class="space-y-4 italic">
                            <h4 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] flex items-center gap-3 italic">
                                <i class="fas fa-list-check text-emerald-500 italic"></i> ESPECIFICACIONES
                            </h4>
                            <div class="bg-slate-50 p-6 rounded-[2rem] border-4 border-white shadow-xl italic">
                                <p class="text-sm font-black text-slate-700 uppercase italic tracking-tight italic">{{ $proyecto->pro_requisitos_especificos }}</p>
                            </div>
                        </div>
                        <div class="space-y-4 italic">
                            <h4 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] flex items-center gap-3 italic">
                                <i class="fas fa-brain-circuit text-blue-500 italic"></i> DOMINIOS TÉCNICOS
                            </h4>
                            <div class="bg-slate-50 p-6 rounded-[2rem] border-4 border-white shadow-xl italic">
                                <p class="text-sm font-black text-slate-700 uppercase italic tracking-tight italic">{{ $proyecto->pro_habilidades_requerida }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- ROADMAP OPERATIVO -->
            <div class="space-y-12 italic">
                <div class="flex items-center gap-8 italic">
                    <h3 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">HOJA DE RUTA OPERATIVA</h3>
                    <div class="h-2 flex-1 bg-slate-50 rounded-full italic shadow-inner"></div>
                </div>

                <div class="space-y-12 relative before:absolute before:left-12 before:top-4 before:bottom-4 before:w-1.5 before:bg-slate-50 before:rounded-full italic px-2 italic">
                    @forelse($etapas as $index => $etapa)
                        <x-card class="ml-6 p-10 md:p-14 border-none shadow-2xl relative group hover:shadow-emerald-500/5 transition-all bg-white rounded-[3.5rem] italic" shadow="none">
                            <div class="absolute -left-[3.75rem] top-6 w-14 h-14 rounded-2xl {{ $index == 0 ? 'bg-emerald-600 shadow-2xl shadow-emerald-500/30 text-white' : 'bg-white border-4 border-slate-50 shadow-xl text-slate-300' }} flex items-center justify-center text-xl font-black italic z-10 italic group-hover:rotate-12 transition-transform italic">
                                {{ str_pad($etapa->eta_orden, 2, '0', STR_PAD_LEFT) }}
                            </div>

                            <div class="space-y-10 italic">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 italic">
                                    <h4 class="text-2xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors uppercase italic tracking-tighter italic leading-none">{{ $etapa->eta_nombre }}</h4>
                                    <x-badge class="bg-slate-900 text-white border-none px-6 py-2 rounded-xl text-[9px] font-black uppercase tracking-[0.3em] italic shadow-2xl italic">FASE ACTIVA</x-badge>
                                </div>

                                <p class="text-slate-400 font-bold text-base leading-relaxed uppercase italic italic opacity-70 italic">{{ $etapa->eta_descripcion }}</p>

                                <!-- EVOLUTION HISTORY -->
                                @php $evidenciasEtapa = $evidencias->where('eta_id', $etapa->eta_id); @endphp
                                
                                @if($evidenciasEtapa->count())
                                    <div class="space-y-6 pt-10 border-t border-slate-50 italic">
                                        <h5 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] italic mb-6">HISTORIAL de TRANSMISIONES</h5>
                                        <div class="grid gap-4 italic font-bold">
                                            @foreach($evidenciasEtapa as $evid)
                                                <div class="flex items-center justify-between bg-white p-6 rounded-[2.5rem] border-4 border-slate-50 hover:bg-slate-50 transition-all shadow-xl group/evid italic italic">
                                                    <div class="flex items-center gap-6 italic">
                                                        <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white shadow-2xl flex items-center justify-center italic border-4 border-white italic">
                                                            <i class="fas fa-file-export italic font-bold"></i>
                                                        </div>
                                                        <div class="italic">
                                                            <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest italic leading-none">{{ \Carbon\Carbon::parse($evid->evid_fecha)->format('D, d M Y | H:i') }}</p>
                                                            @if($evid->evid_comentario)
                                                                <p class="text-[10px] font-black text-emerald-500 uppercase italic mt-3 opacity-60 italic truncate max-w-[200px]"><i class="fas fa-terminal text-[8px] mr-2 italic"></i> {{ $evid->evid_comentario }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-6 italic">
                                                        @switch($evid->evid_estado)
                                                            @case('Aprobada') <x-badge class="bg-emerald-500 text-white border-none py-2 px-5 rounded-xl text-[9px] font-black uppercase tracking-widest italic shadow-lg shadow-emerald-500/20 italic">VALIDADO</x-badge> @break
                                                            @case('Pendiente') <x-badge class="bg-slate-300 text-white border-none py-2 px-5 rounded-xl text-[9px] font-black uppercase tracking-widest italic italic">EN ESCANEO</x-badge> @break
                                                            @case('Rechazada') <x-badge class="bg-red-500 text-white border-none py-2 px-5 rounded-xl text-[9px] font-black uppercase tracking-widest italic shadow-lg shadow-red-500/20 italic">RECHAZADO</x-badge> @break
                                                        @endswitch
                                                        @if($evid->evid_archivo)
                                                            <a href="{{ asset('storage/' . $evid->evid_archivo) }}" target="_blank" class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-emerald-500 transition-all shadow-2xl active:scale-95 italic">
                                                                <i class="fas fa-download text-sm italic"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- CONSOLA de ENTREGA -->
                                <div class="pt-10 mt-10 border-t border-slate-50 italic">
                                    <form action="{{ route('aprendiz.evidencia.enviar', [$proyecto->pro_id, $etapa->eta_id]) }}" method="POST" enctype="multipart/form-data" class="space-y-8 italic">
                                        @csrf
                                        <div class="space-y-6 italic">
                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] block pl-4 italic">CONSOLA DE ACTIVACIÓN</label>
                                            <textarea name="descripcion" required placeholder="DESCRIBE LOS LOGROS TÉCNICOS ALCANZADOS EN ESTE HITO OPERATIVO..." 
                                                      class="w-full bg-slate-50 border-4 border-transparent rounded-[2.5rem] p-10 text-base font-black text-slate-900 placeholder:text-slate-200 focus:border-emerald-500/20 focus:bg-white transition-all outline-none min-h-[160px] shadow-inner uppercase italic tracking-tight italic"></textarea>
                                        </div>
                                        
                                        <div class="flex flex-col md:flex-row gap-6 italic">
                                            <div class="flex-1 relative group/file italic">
                                                <input type="file" name="archivo" required class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer italic">
                                                <div class="bg-slate-50 border-4 border-dashed border-slate-200 rounded-[2rem] p-6 flex items-center justify-center gap-6 group-hover/file:border-emerald-500/40 group-hover/file:bg-emerald-50 transition-all italic">
                                                    <i class="fas fa-cloud-upload-alt text-slate-300 group-hover/file:text-emerald-500 text-2xl transition-colors italic"></i>
                                                    <span class="text-[10px] font-black text-slate-400 group-hover/file:text-emerald-600 uppercase tracking-[0.3em] italic">CARGAR EXPEDIENTE (ZIP/PDF)</span>
                                                </div>
                                            </div>
                                            <x-button type="submit" variant="primary" shadow="emerald" class="py-6 px-12 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.2em] flex items-center justify-center gap-4 active:scale-95 transition-all italic italic shadow-2xl">
                                                EJECUTAR TRANSMISIÓN <i class="fas fa-paper-plane italic font-bold"></i>
                                            </x-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </x-card>
                    @empty
                        <div class="bg-slate-50 rounded-[4rem] border-8 border-white p-24 text-center space-y-10 shadow-inner italic">
                            <div class="w-32 h-32 rounded-[3.5rem] bg-white shadow-2xl flex items-center justify-center mx-auto text-slate-200 text-5xl italic rotate-12 italic">
                                <i class="fas fa-satellite-dish animate-pulse italic"></i>
                            </div>
                            <div class="space-y-4 italic">
                                <h4 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Ruta en Construcción</h4>
                                <p class="text-slate-400 font-bold uppercase italic text-sm tracking-widest max-w-sm mx-auto leading-relaxed italic opacity-70">El líder técnico está puliendo los hitos de esta misión. Vuelve pronto para iniciar operaciones.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- SIDEBAR: CRONOGRAMA & VISUAL -->
        <div class="space-y-12 sticky top-12 italic">
            
            <x-card class="p-10 border-none shadow-2xl relative overflow-hidden group bg-slate-900 rounded-[3.5rem] italic" shadow="none">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900/20 italic opacity-80"></div>
                <div class="relative space-y-8 italic">
                    <h4 class="text-[10px] font-black text-emerald-400/60 uppercase tracking-[0.4em] flex items-center gap-4 italic">
                        <i class="fas fa-eye italic text-emerald-500"></i> TRANSMISIÓN VISUAL
                    </h4>
                    <div class="relative rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white/5 group-hover:border-emerald-500/20 transition-all duration-700 italic">
                        @if($proyecto->pro_imagen_url)
                            <img src="{{ $proyecto->pro_imagen_url }}" class="w-full object-cover aspect-video group-hover:scale-110 transition-transform duration-[2000ms] italic">
                        @else
                            <div class="aspect-video bg-white/5 flex flex-col items-center justify-center text-white/10 p-12 space-y-6 italic">
                                <i class="fas fa-image-slash text-6xl italic"></i>
                                <p class="text-[9px] font-black uppercase tracking-[0.4em] italic text-center italic">SIN SEÑAL VISUAL</p>
                            </div>
                        @endif
                    </div>
                </div>
            </x-card>

            <x-card class="p-12 border-none shadow-2xl space-y-12 bg-white relative overflow-hidden rounded-[3.5rem] italic" shadow="none">
                <div class="absolute top-0 right-0 w-3 h-full bg-slate-900 italic"></div>
                
                <h4 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] italic flex items-center gap-4 italic leading-none">
                    <i class="fas fa-tower-broadcast text-emerald-500 italic"></i> CRONOGRAMA MAESTRO
                </h4>
                
                <div class="space-y-10 italic">
                    <div class="space-y-3 group/date italic">
                        <p class="text-[9px] text-slate-300 uppercase tracking-[0.3em] italic ml-2 italic">FECHA de LANZAMIENTO</p>
                        <div class="flex items-center gap-6 bg-slate-50 p-6 rounded-[2rem] border-4 border-white group-hover/date:border-emerald-500/10 transition-all shadow-xl italic italic">
                            <i class="fas fa-calendar-alt text-emerald-500 text-2xl italic font-bold"></i>
                            <span class="text-lg font-black text-slate-900 italic tracking-tighter italic">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d M, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-3 group/date italic">
                        <p class="text-[9px] text-red-400 uppercase tracking-[0.3em] italic ml-2 italic">CIERRE de EXPEDIENTE</p>
                        <div class="flex items-center gap-6 bg-red-50 p-6 rounded-[2rem] border-4 border-white group-hover/date:border-red-500/10 transition-all shadow-xl italic italic">
                            <i class="fas fa-calendar-check text-red-500 text-2xl italic font-bold"></i>
                            <span class="text-lg font-black text-red-600 italic tracking-tighter italic">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d M, Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 p-8 rounded-[2.5rem] space-y-6 shadow-2xl relative overflow-hidden group italic">
                    <div class="absolute -right-10 -bottom-10 text-white/5 text-9xl italic rotate-12 group-hover:scale-125 transition-all duration-1000 italic">
                        <i class="fas fa-triangle-exclamation italic"></i>
                    </div>
                    <div class="flex items-center gap-4 italic relative">
                        <i class="fas fa-shield-halved text-amber-500 italic font-bold"></i>
                        <span class="text-[9px] font-black text-white uppercase tracking-[0.3em] italic">Protocolo de Integridad</span>
                    </div>
                    <p class="text-[11px] font-bold text-slate-400 leading-relaxed uppercase italic italic relative opacity-80 italic">
                        Debe garantizar la integridad técnica de cada transmisión. Los plazos son improrrogables según el cronograma maestro radicado.
                    </p>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection