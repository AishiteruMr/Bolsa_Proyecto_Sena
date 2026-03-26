@extends('layouts.dashboard')

@section('title', 'Auditoría de Despliegue | ' . ($proyecto->pro_titulo_proyecto ?? 'Reporte'))

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
<div class="max-w-7xl mx-auto space-y-12 pb-24 italic font-bold print:p-0">
    
    <!-- HEADER SECTION -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 px-4 print:hidden italic">
        <div class="space-y-8 italic">
            <a href="{{ route('instructor.proyecto.detalle', $proyecto->pro_id) }}" class="inline-flex items-center text-[10px] font-black text-emerald-600 hover:text-emerald-700 transition-all group uppercase tracking-[0.3em] italic">
                <i class="fas fa-chevron-left mr-4 group-hover:-translate-x-2 transition-transform italic font-bold"></i> REPLEGAR A CONSOLA DE GESTIÓN
            </a>
            <div class="space-y-4 italic">
                <div class="flex items-center gap-4 italic font-bold">
                    <x-badge class="bg-emerald-500 text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic shadow-2xl shadow-emerald-500/20 italic">
                        AUDITORÍA ESTRATÉGICA
                    </x-badge>
                    <div class="h-1 w-12 bg-slate-100 rounded-full italic"></div>
                    <span class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] italic opacity-60 italic leading-none">ANÁLISIS LONGITUDINAL DE IMPACTO</span>
                </div>
                <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-[0.9] italic">
                    REPORTE DE <br> <span class="text-emerald-500 text-6xl md:text-8xl block mt-2">SEGUIMIENTO</span>
                </h2>
                <p class="text-slate-400 font-black text-sm uppercase tracking-[0.4em] italic opacity-70 italic truncate italic">
                    NODO: {{ strtoupper($proyecto->pro_titulo_proyecto) }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-6 italic">
            <x-button variant="primary" shadow="emerald" onclick="window.print()" class="bg-slate-900 text-white border-none px-12 py-6 rounded-[2rem] text-[11px] font-black uppercase italic shadow-2xl hover:scale-105 transition-all active:scale-95 italic">
                <i class="fas fa-file-pdf mr-4 italic text-xl font-bold"></i> EXPORTAR EXPEDIENTE PDF
            </x-button>
        </div>
    </div>

    <!-- ANALYTICS BENTO GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 px-4 print:grid-cols-4 italic">
        <x-card class="p-10 border-none shadow-2xl rounded-[3.5rem] bg-white flex flex-col justify-between group hover:shadow-blue-500/10 transition-all duration-700 italic h-64 italic" shadow="none">
            <div class="flex items-center justify-between italic">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl group-hover:rotate-12 transition-transform italic border-4 border-white shadow-xl italic">
                    <i class="fas fa-user-astronaut italic font-bold"></i>
                </div>
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">OPERADORES</span>
            </div>
            <div class="italic">
                <p class="text-6xl font-black text-slate-900 leading-none italic tracking-tighter italic">{{ str_pad($aprendices->count(), 2, '0', STR_PAD_LEFT) }}</p>
                <div class="mt-4 h-1.5 w-12 bg-blue-500 rounded-full italic"></div>
            </div>
        </x-card>
        
        <x-card class="p-10 border-none shadow-2xl rounded-[3.5rem] bg-white flex flex-col justify-between group hover:shadow-emerald-500/10 transition-all duration-700 italic h-64 italic" shadow="none">
            <div class="flex items-center justify-between italic">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl group-hover:-rotate-12 transition-transform italic border-4 border-white shadow-xl italic">
                    <i class="fas fa-satellite-dish italic font-bold"></i>
                </div>
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">TRANSMISIONES</span>
            </div>
            <div class="italic">
                <p class="text-6xl font-black text-slate-900 leading-none italic tracking-tighter italic">{{ str_pad($entregas->count(), 2, '0', STR_PAD_LEFT) }}</p>
                <div class="mt-4 h-1.5 w-12 bg-emerald-500 rounded-full italic"></div>
            </div>
        </x-card>

        <x-card class="p-10 border-none shadow-2xl rounded-[3.5rem] bg-white flex flex-col justify-between group hover:shadow-amber-500/10 transition-all duration-700 italic h-64 italic" shadow="none">
            <div class="flex items-center justify-between italic">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform italic border-4 border-white shadow-xl italic">
                    <i class="fas fa-certificate italic font-bold"></i>
                </div>
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">VALIDADOS</span>
            </div>
            <div class="italic">
                <p class="text-6xl font-black text-slate-900 leading-none italic tracking-tighter italic">{{ str_pad($evidencias->where('evid_estado', 'Aprobada')->count(), 2, '0', STR_PAD_LEFT) }}</p>
                <div class="mt-4 h-1.5 w-12 bg-amber-500 rounded-full italic"></div>
            </div>
        </x-card>

        <x-card class="p-10 border-none shadow-2xl rounded-[3.5rem] bg-white flex flex-col justify-between group hover:shadow-purple-500/10 transition-all duration-700 italic h-64 italic" shadow="none">
            <div class="flex items-center justify-between italic">
                <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-3xl group-hover:rotate-[15deg] transition-transform italic border-4 border-white shadow-xl italic">
                    <i class="fas fa-layer-group italic font-bold"></i>
                </div>
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">HITOS</span>
            </div>
            <div class="italic">
                <p class="text-6xl font-black text-slate-900 leading-none italic tracking-tighter italic">{{ str_pad($etapas->count(), 2, '0', STR_PAD_LEFT) }}</p>
                <div class="mt-4 h-1.5 w-12 bg-purple-500 rounded-full italic"></div>
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start px-4 italic">
        
        <div class="lg:col-span-2 space-y-16 italic">
            <!-- Apprentice Performance Matrix -->
            <x-card class="p-12 md:p-16 border-none shadow-2xl rounded-[4rem] bg-white overflow-hidden italic group italic" shadow="none">
                <div class="flex items-center justify-between mb-16 italic border-b border-slate-50 pb-10 italic">
                    <div class="flex items-center gap-6 italic">
                        <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-2xl italic rotate-6">
                            <i class="fas fa-tachometer-alt text-xl font-bold italic"></i>
                        </div>
                        <div class="italic">
                            <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic leading-none">Matriz de Rendimiento</h3>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3 italic opacity-60 italic">KPI DE DESPLIEGUE POR OPERADOR</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto -mx-12 md:-mx-16 italic font-bold">
                    <table class="w-full text-left border-separate border-spacing-y-6 px-12 md:px-16 italic">
                        <thead>
                            <tr class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic opacity-60">
                                <th class="pb-4 pl-6 italic">OPERADOR ASIGNADO</th>
                                <th class="pb-4 text-center italic">CUOTA DE TRANSMISIÓN</th>
                                <th class="pb-4 text-right pr-6 italic">KPI OPERATIVO</th>
                            </tr>
                        </thead>
                        <tbody class="italic">
                            @foreach($aprendices as $aprendiz)
                                @php
                                    $e_count = $entregas->where('ene_apr_id', $aprendiz->apr_id)->count();
                                    $a_count = $evidencias->where('evid_apr_id', $aprendiz->apr_id)->where('evid_estado', 'Aprobada')->count();
                                    $progreso = $etapas->count() > 0 ? ($a_count / $etapas->count()) * 100 : 0;
                                @endphp
                                <tr class="group/row italic">
                                    <td class="p-8 bg-slate-50 rounded-l-[2.5rem] border-none group-hover/row:bg-emerald-50 transition-all duration-500 italic">
                                        <div class="flex items-center gap-6 italic">
                                            <div class="w-16 h-16 rounded-2xl bg-white shadow-2xl flex items-center justify-center font-black text-emerald-600 italic border-4 border-white group-hover/row:scale-110 group-hover/row:rotate-6 transition-all italic">
                                                {{ strtoupper(substr($aprendiz->apr_nombre, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0 italic">
                                                <p class="text-base font-black text-slate-900 truncate uppercase italic tracking-tighter italic leading-none">{{ $aprendiz->apr_nombre }}</p>
                                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest truncate italic opacity-60 mt-2 italic leading-none">{{ $aprendiz->usr_correo }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-8 bg-slate-50 border-none text-center group-hover/row:bg-emerald-50 transition-all duration-500 italic">
                                        <span class="inline-flex px-6 py-2.5 rounded-xl bg-slate-900 text-white shadow-2xl text-[10px] font-black italic border-2 border-white/5 uppercase tracking-widest italic font-bold">
                                            {{ str_pad($e_count, 2, '0', STR_PAD_LEFT) }} / {{ str_pad($etapas->count(), 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="p-8 bg-slate-50 rounded-r-[2.5rem] border-none group-hover/row:bg-emerald-50 transition-all duration-500 italic">
                                        <div class="flex items-center justify-end gap-6 italic">
                                            <div class="w-40 hidden md:block italic">
                                                <div class="h-4 w-full bg-white rounded-full overflow-hidden shadow-inner p-1 italic border border-slate-100">
                                                    <div class="h-full rounded-full bg-emerald-500 shadow-xl transition-all duration-1000 italic" style="width: {{ $progreso }}%"></div>
                                                </div>
                                            </div>
                                            <span class="text-3xl font-black text-emerald-600 min-w-[80px] italic tracking-tighter italic leading-none">{{ round($progreso) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- BITÁCORA DE SEGUIMIENTO -->
            <div class="space-y-10 italic">
                <div class="flex items-center gap-8 italic">
                    <h3 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none italic">BITÁCORA DE SEGUIMIENTO</h3>
                    <div class="h-2 flex-1 bg-slate-50 rounded-full italic shadow-inner"></div>
                </div>

                <div class="space-y-10 italic font-bold">
                    @foreach($etapas as $etapa)
                        <div class="group/stage border-none rounded-[3.5rem] overflow-hidden bg-slate-50 hover:bg-white hover:shadow-2xl transition-all duration-700 italic border-4 border-transparent hover:border-emerald-500/10 italic">
                            <div class="p-10 cursor-pointer flex items-center justify-between italic" onclick="this.nextElementSibling.classList.toggle('hidden')">
                                <div class="flex items-center gap-10 italic">
                                    <div class="w-16 h-16 rounded-2xl bg-white shadow-2xl flex items-center justify-center font-black text-2xl text-emerald-500 italic group-hover/stage:rotate-12 transition-transform italic border-4 border-slate-50">
                                        {{ str_pad($etapa->eta_orden, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="min-w-0 italic">
                                        <h4 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic leading-none mb-3 italic">{{ $etapa->eta_nombre }}</h4>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] italic opacity-60 italic leading-none italic">{{ str_pad(count($entregas->where('ene_eta_id', $etapa->eta_id)), 2, '0', STR_PAD_LEFT) }} ENTREGAS REGISTRADAS EN ENTRADA</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down text-slate-300 group-hover/stage:text-emerald-500 transition-all italic text-2xl italic font-bold"></i>
                            </div>
                            <div class="hidden border-t-4 border-slate-100 bg-white p-12 animate-in fade-in slide-in-from-top-6 duration-700 italic">
                                <div class="space-y-16 italic">
                                    <div class="p-10 rounded-[2.5rem] bg-slate-900 text-white/50 font-black text-base italic border-none shadow-2xl leading-relaxed uppercase tracking-tight italic">
                                        &ldquo;{{ $etapa->eta_descripcion }}&rdquo;
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 italic">
                                        <div class="space-y-10 italic">
                                            <h5 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.4em] border-b-4 border-blue-50 pb-6 flex items-center gap-4 italic font-bold">
                                                <i class="fas fa-satellite text-2xl italic animate-pulse font-bold"></i> TRANSMISIONES RECIBIDAS
                                            </h5>
                                            <div class="grid gap-5 italic font-bold">
                                                @forelse($entregas->where('ene_eta_id', $etapa->eta_id) as $e)
                                                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-[2rem] border-4 border-white group/mini hover:bg-blue-50 transition-all shadow-xl italic italic">
                                                        <span class="text-sm font-black text-slate-900 uppercase italic tracking-tighter group-hover/mini:text-blue-700 transition-colors italic leading-none">{{ $e->apr_nombre }}</span>
                                                        <x-badge class="bg-blue-600 text-white border-none py-2.5 px-6 rounded-xl text-[9px] font-black uppercase tracking-widest italic shadow-lg shadow-blue-500/20 italic">RECIBIDO</x-badge>
                                                    </div>
                                                @empty
                                                    <div class="text-center py-16 opacity-30 italic">
                                                        <i class="fas fa-ghost text-6xl mb-6 block italic animate-pulse font-bold"></i>
                                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] italic leading-none">SIN REGISTROS OPERATIVOS</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                        <div class="space-y-10 italic">
                                            <h5 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.4em] border-b-4 border-emerald-50 pb-6 flex items-center gap-4 italic font-bold">
                                                <i class="fas fa-check-double text-2xl italic font-bold"></i> ESTATUS DE SENTENCIA
                                            </h5>
                                            <div class="grid gap-5 italic font-bold">
                                                @forelse($evidencias->where('evid_eta_id', $etapa->eta_id) as $ev)
                                                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-[2rem] border-4 border-white group/mini hover:bg-emerald-50 transition-all shadow-xl italic italic">
                                                        <span class="text-sm font-black text-slate-900 uppercase italic tracking-tighter group-hover/mini:text-emerald-700 transition-colors italic leading-none">{{ $ev->apr_nombre }}</span>
                                                        <x-badge class="{{ $ev->evid_estado === 'Aprobada' ? 'bg-emerald-500' : 'bg-red-500' }} text-white border-none py-2.5 px-6 rounded-xl text-[9px] font-black uppercase tracking-widest italic shadow-lg shadow-emerald-500/20 italic">
                                                            {{ strtoupper($ev->evid_estado) }}
                                                        </x-badge>
                                                    </div>
                                                @empty
                                                    <div class="text-center py-16 opacity-30 italic font-bold">
                                                        <i class="fas fa-file-signature text-6xl mb-6 block italic font-bold"></i>
                                                        <p class="text-[10px] font-black text-amber-500 uppercase tracking-[0.4em] italic leading-none">PENDIENTE DE VALIDACIÓN</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Meta Info Sidebar -->
        <div class="space-y-12 lg:sticky lg:top-12 print:hidden italic">
            <x-card class="p-12 border-none shadow-2xl rounded-[3.5rem] bg-white relative overflow-hidden group italic" shadow="none">
                <div class="absolute top-0 right-0 w-32 h-32 bg-slate-900/5 rounded-bl-[120px] transition-transform duration-1000 group-hover:scale-125 italic"></div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-12 border-b-4 border-slate-50 pb-6 flex items-center gap-4 italic opacity-60 italic leading-none">
                    <i class="fas fa-microchip text-emerald-600 italic font-bold"></i> FICHA TÉCNICA
                </h4>
                <div class="space-y-12 italic font-bold">
                    <div class="space-y-4 italic">
                        <p class="text-[9px] font-black text-emerald-800/40 uppercase tracking-[0.3em] italic leading-none px-2 italic">ESTADO DEL NODO ESTRATÉGICO</p>
                        <div class="px-8 py-5 rounded-[2rem] bg-slate-900 text-white font-black text-[10px] text-center shadow-2xl shadow-emerald-500/10 italic tracking-widest uppercase italic border-2 border-white/5 italic">
                            {{ strtoupper($proyecto->pro_estado) ?? 'OPERATIVO' }} • ID: {{ str_pad($proyecto->pro_id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                    <div class="space-y-4 italic">
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] italic leading-none px-2 italic">ALIADO CORPORATIVO</p>
                        <div class="flex items-center gap-5 p-6 rounded-[2rem] bg-slate-50 border-4 border-white shadow-xl italic italic">
                            <i class="fas fa-building text-3xl text-emerald-500 italic font-bold"></i>
                            <p class="text-base font-black text-slate-900 italic tracking-tighter uppercase leading-none italic truncate">{{ strtoupper($proyecto->empresa?->emp_nombre ?? 'CORP. EXTERNA') }}</p>
                        </div>
                    </div>
                    <div class="pt-10 border-t-4 border-slate-50 italic">
                        <p class="text-[9px] font-black text-slate-300 uppercase mb-8 tracking-[0.3em] italic leading-none px-2 italic">PROTOCOLO DE CIERRE</p>
                        <div class="flex justify-between items-center p-8 rounded-[2.5rem] bg-slate-900 text-white shadow-2xl italic border-2 border-white/5 italic">
                            <i class="fas fa-calendar-check text-4xl text-emerald-500 italic group-hover:rotate-12 transition-transform italic font-bold"></i>
                            <div class="text-right italic">
                                <span class="block text-[8px] font-black text-white/30 uppercase tracking-[0.4em] italic mb-2 italic">CIERRE NOMINAL</span>
                                <span class="block text-xl font-black text-emerald-500 italic tracking-tighter uppercase leading-none italic">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->translatedFormat('d M, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card class="p-14 bg-slate-900 text-white border-none shadow-2xl rounded-[4rem] relative group overflow-hidden italic" shadow="none">
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-emerald-500/10 rounded-full group-hover:scale-150 transition-transform duration-1000 italic"></div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-emerald-400 opacity-40 mb-12 italic leading-none">GRADE DE AUDITORÍA</h4>
                <div class="flex flex-col items-center justify-center space-y-8 relative z-10 italic">
                    <div class="w-40 h-40 rounded-[3rem] bg-white/5 backdrop-blur-2xl border-4 border-white/10 flex items-center justify-center shadow-2xl shadow-black/60 group-hover:scale-110 group-hover:rotate-6 transition-all italic italic">
                        <span class="text-7xl font-black italic tracking-tighter text-emerald-400 drop-shadow-[0_0_20px_rgba(16,185,129,0.6)]">S+</span>
                    </div>
                    <div class="text-center italic">
                        <p class="text-[11px] font-black uppercase tracking-[0.4em] text-emerald-400 italic mb-3 italic">EXCELENCIA ACADÉMICA</p>
                        <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.2em] italic leading-none italic">MÉTRICA DE GESTIÓN INSTITUCIONAL SENA</p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
