@extends('layouts.dashboard')

@section('title', 'Centro de Validación | ' . ($proyecto->pro_titulo_proyecto ?? 'Evidencias'))

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
<div class="max-w-6xl mx-auto space-y-12 pb-24 italic font-bold">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 px-4 italic">
        <div class="space-y-8 italic">
            <a href="{{ route('instructor.proyecto.detalle', $proyecto->pro_id) }}" class="inline-flex items-center text-[10px] font-black text-[#E65100] hover:text-orange-700 transition-all group uppercase tracking-[0.3em] italic">
                <i class="fas fa-chevron-left mr-4 group-hover:-translate-x-2 transition-transform italic font-bold"></i> VOLVER AL COMANDO CENTRAL
            </a>
            <div class="space-y-4 italic">
                <div class="flex items-center gap-4 italic font-bold">
                    <x-badge class="bg-blue-600 text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic shadow-2xl shadow-blue-500/20 italic">
                        LABORATORIO DE VALIDACIÓN
                    </x-badge>
                    <div class="h-1 w-12 bg-slate-100 rounded-full italic"></div>
                    <span class="text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] italic opacity-60 italic leading-none">AUDITORÍA TÉCNICA DE ENTREGABLES</span>
                </div>
                <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-[0.9] italic">
                    SENTENCIA DE <br> <span class="text-[#FF6B00] text-6xl md:text-8xl block mt-2">EVIDENCIAS</span>
                </h2>
                <p class="text-slate-400 font-black text-sm uppercase tracking-[0.4em] italic opacity-70 italic truncate italic">
                    SISTEMA: {{ strtoupper($proyecto->pro_titulo_proyecto) }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-6 italic">
            <div class="px-10 py-6 rounded-[2rem] bg-slate-900 text-orange-400 border-none text-[11px] font-black shadow-2xl flex items-center gap-5 uppercase italic tracking-widest animate-in fade-in slide-in-from-right duration-700 italic border-2 border-white/5">
                <i class="fas fa-satellite animate-pulse italic text-2xl font-bold"></i>
                <div class="italic">
                    <span class="block text-white text-3xl italic leading-none mb-1">{{ str_pad(count($evidencias), 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="block text-white/40 text-[8px] italic tracking-tighter">PENDIENTES EN RADAR</span>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mx-4 p-10 rounded-[3.5rem] bg-orange-50 border-4 border-white flex items-center gap-8 animate-in zoom-in-95 duration-700 italic shadow-2xl shadow-[#FF6B00]/10 italic">
            <div class="w-20 h-20 rounded-[1.5rem] bg-[#FF6B00] text-white flex items-center justify-center shadow-2xl shadow-[#FF6B00]/30 rotate-6 italic group-hover:rotate-0 transition-transform italic border-4 border-white italic">
                <i class="fas fa-check-double text-3xl italic font-bold"></i>
            </div>
            <div class="italic">
                <p class="font-black text-2xl text-orange-900 uppercase italic tracking-tighter italic leading-none">Protocolo Validado</p>
                <p class="text-[#E65100] font-black text-[10px] uppercase italic tracking-[0.3em] mt-3 italic opacity-60 italic">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="space-y-12 px-4 italic font-bold">
        @forelse($evidencias as $evidencia)
            <x-card class="p-0 overflow-hidden border-none shadow-2xl rounded-[4rem] bg-white group hover:shadow-[#FF6B00]/5 transition-all duration-700 italic" shadow="none">
                <!-- Header of the evidence card -->
                <div class="p-10 md:p-12 bg-slate-50 border-b-4 border-white flex flex-wrap justify-between items-center gap-10 italic">
                    <div class="flex items-center gap-10 italic">
                        <div class="relative italic">
                            <div class="w-20 h-20 rounded-[1.5rem] bg-white shadow-2xl flex items-center justify-center text-[#E65100] group-hover:rotate-12 transition-transform italic border-4 border-slate-50 italic">
                                <i class="fas fa-file-signature text-4xl italic font-bold"></i>
                            </div>
                            <span class="absolute -top-4 -right-4 w-12 h-12 rounded-2xl bg-slate-900 text-white border-8 border-slate-50 flex items-center justify-center font-black text-sm shadow-2xl italic leading-none italic">
                                {{ str_pad($evidencia->eta_orden, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <div class="min-w-0 italic">
                            <h4 class="text-3xl font-black text-slate-900 group-hover:text-[#E65100] transition-colors uppercase italic tracking-tighter leading-none mb-3 italic">HITO: {{ $evidencia->eta_nombre }}</h4>
                            <div class="flex items-center gap-4 text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] italic opacity-80 italic">
                                <i class="fas fa-user-astronaut text-[#FF6B00] italic font-bold"></i>
                                <span class="truncate italic">{{ strtoupper($evidencia->apr_nombre) }} {{ strtoupper($evidencia->apr_apellido) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-left md:text-right border-l-4 border-slate-200 pl-10 italic">
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] mb-3 italic opacity-60 italic leading-none italic">REGISTRO DE TRANSMISIÓN</p>
                        <p class="text-base font-black text-slate-900 italic uppercase italic leading-none">{{ \Carbon\Carbon::parse($evidencia->evid_fecha)->translatedFormat('d M, Y • h:i A') }}</p>
                    </div>
                </div>

                <!-- Body of the card -->
                <div class="p-12 md:p-16 italic">
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-16 italic">
                        
                        <!-- Left: Grading Form -->
                        <div class="lg:col-span-3 space-y-12 italic">
                            <form action="{{ route('instructor.evidencias.calificar', $evidencia->evid_id) }}" method="POST" class="space-y-12 italic">
                                @csrf
                                @method('PUT')
                                
                                <div class="space-y-8 italic">
                                    <label class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] block ml-4 italic opacity-80 italic leading-none italic">SENTENCIA TÉCNICA OPERATIVA</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 italic">
                                        <label class="relative group cursor-pointer italic">
                                            <input type="radio" name="estado" value="Aprobada" {{ $evidencia->evid_estado === 'Aprobada' ? 'checked' : '' }} required class="peer hidden">
                                            <div class="p-8 rounded-[2.5rem] border-4 border-slate-50 bg-slate-50 flex flex-col items-center gap-4 group-hover:bg-orange-50 peer-checked:border-[#FF6B00] peer-checked:bg-[#FF6B00] peer-checked:text-white transition-all shadow-xl active:scale-95 italic text-slate-400 italic">
                                                <i class="fas fa-check-circle text-3xl italic font-bold"></i>
                                                <span class="text-[10px] font-black uppercase tracking-[0.3em] italic leading-none">ALTA</span>
                                            </div>
                                        </label>
                                        <label class="relative group cursor-pointer italic">
                                            <input type="radio" name="estado" value="Pendiente" {{ $evidencia->evid_estado === 'Pendiente' ? 'checked' : '' }} required class="peer hidden">
                                            <div class="p-8 rounded-[2.5rem] border-4 border-slate-50 bg-slate-50 flex flex-col items-center gap-4 group-hover:bg-amber-50 peer-checked:border-amber-500 peer-checked:bg-amber-500 peer-checked:text-white transition-all shadow-xl active:scale-95 italic text-slate-400 italic">
                                                <i class="fas fa-tools text-3xl italic font-bold"></i>
                                                <span class="text-[10px] font-black uppercase tracking-[0.3em] italic leading-none">REVISIÓN</span>
                                            </div>
                                        </label>
                                        <label class="relative group cursor-pointer italic">
                                            <input type="radio" name="estado" value="Rechazada" {{ $evidencia->evid_estado === 'Rechazada' ? 'checked' : '' }} required class="peer hidden">
                                            <div class="p-8 rounded-[2.5rem] border-4 border-slate-50 bg-slate-50 flex flex-col items-center gap-4 group-hover:bg-red-50 peer-checked:border-red-500 peer-checked:bg-red-500 peer-checked:text-white transition-all shadow-xl active:scale-95 italic text-slate-400 italic">
                                                <i class="fas fa-ban text-3xl italic font-bold"></i>
                                                <span class="text-[10px] font-black uppercase tracking-[0.3em] italic leading-none">BAJA</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="space-y-6 italic">
                                    <label class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] block ml-4 italic opacity-80 italic leading-none italic">OBSERVACIONES DE AUDITORÍA</label>
                                    <textarea name="comentario" class="w-full min-h-[200px] p-10 rounded-[3rem] bg-slate-50 border-none focus:ring-8 focus:ring-[#FF6B00]/10 focus:bg-white focus:outline-none font-black text-sm text-slate-700 transition-all shadow-inner uppercase italic placeholder:text-slate-200 tracking-tight leading-relaxed italic" placeholder="ESPECIFIQUE HALLAZGOS TÉCNICOS Y REQUERIMIENTOS ESTRATÉGICOS PARA EL OPERADOR...">{{ $evidencia->evid_comentario }}</textarea>
                                </div>

                                <x-button variant="primary" size="lg" shadow="orange" class="w-full justify-center py-7 rounded-[2.5rem] text-[11px] font-black uppercase italic shadow-2xl shadow-[#FF6B00]/10 active:scale-95 transition-transform italic tracking-widest italic leading-none">
                                    <i class="fas fa-file-export mr-4 italic text-xl font-bold"></i> CONSOLIDAR SENTENCIA
                                </x-button>
                            </form>
                        </div>

                        <!-- Right: Deliverable Info -->
                        <div class="lg:col-span-2 space-y-10 italic">
                            <div class="p-10 rounded-[3.5rem] bg-slate-900 border-none space-y-10 italic shadow-2xl shadow-black/40 text-white relative overflow-hidden italic">
                                <div class="absolute -right-16 -top-16 text-[15rem] text-white/5 opacity-10 pointer-events-none transform rotate-12 italic">
                                    <i class="fas fa-briefcase italic font-bold"></i>
                                </div>

                                <h5 class="text-[10px] font-black text-white/40 uppercase tracking-[0.3em] border-b-2 border-white/5 pb-6 flex items-center gap-4 italic opacity-80 italic leading-none">
                                    <i class="fas fa-satellite-dish text-[#FF6B00] italic text-xl font-bold"></i> EXPEDIENTE TÉCNICO
                                </h5>
                                
                                <div class="space-y-6 italic">
                                    @if($evidencia->evid_archivo)
                                        <a href="{{ asset('storage/' . $evidencia->evid_archivo) }}" target="_blank" 
                                            class="flex items-center gap-6 p-8 bg-white/5 rounded-[2.5rem] border-4 border-white/5 hover:bg-white/10 hover:border-[#FF6B00]/40 hover:shadow-2xl hover:shadow-[#FF6B00]/10 transition-all group italic italic">
                                            <div class="w-16 h-16 rounded-2xl bg-[#FF6B00] text-white flex items-center justify-center text-3xl group-hover:scale-110 group-hover:rotate-12 transition-transform italic shadow-2xl shadow-[#FF6B00]/40 italic border-4 border-white/10 italic">
                                                <i class="fas fa-file-pdf italic font-bold"></i>
                                            </div>
                                            <div class="min-w-0 italic">
                                                <p class="text-[9px] font-black text-orange-400 uppercase tracking-[0.4em] mb-2 italic leading-none italic">DESCARGAR PROTOCOLO</p>
                                                <p class="text-sm font-black text-white truncate uppercase italic tracking-tighter italic leading-none italic">{{ strtoupper(pathinfo($evidencia->evid_archivo, PATHINFO_BASENAME)) }}</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="text-center py-16 px-8 border-4 border-dashed border-white/10 rounded-[3rem] bg-white/5 italic">
                                            <i class="fas fa-ghost text-6xl text-white/5 mb-8 block italic animate-pulse font-bold"></i>
                                            <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] italic leading-none">SIN PROTOCOLOS ADJUNTOS</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="space-y-6 pt-10 border-t-2 border-white/5 italic font-bold">
                                    <div class="flex justify-between items-center text-[9px] font-black uppercase tracking-[0.4em] text-white/30 italic">
                                        <span>CRONOS DE TRANSMISIÓN</span>
                                        <x-badge class="bg-[#FF6B00] text-white border-none py-1.5 px-4 rounded-lg text-[8px] font-black italic shadow-xl shadow-[#FF6B00]/20 italic">NOMINAL OK</x-badge>
                                    </div>
                                    <div class="h-3 w-full bg-white/5 rounded-full overflow-hidden italic shadow-inner border-2 border-white/5">
                                        <div class="h-full bg-[#FF6B00] shadow-[0_0_20px_rgba(16,185,129,0.5)] transition-all duration-1000 italic" style="width: 100%"></div>
                                    </div>
                                    <div class="p-6 rounded-2xl bg-white/5 border border-white/5 italic">
                                        <p class="text-[9px] font-black text-white/40 uppercase tracking-[0.2em] italic leading-relaxed italic text-center italic">
                                            ESTE ENTREGABLE FUE SINCRONIZADO DENTRO DE LOS PARÁMETROS TEMPORALES DEL PROTOCOLO ACADÉMICO.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        @empty
            <div class="py-48 text-center italic border-8 border-dashed border-slate-50 rounded-[5rem] group hover:border-[#FF6B00]/10 transition-all duration-1000 bg-slate-50/30 italic">
                <div class="relative inline-block italic">
                    <div class="absolute inset-0 bg-[#FF6B00]/10 rounded-full blur-[120px] animate-pulse italic"></div>
                    <div class="relative mb-12 inline-flex p-12 rounded-[4rem] bg-white text-orange-100 shadow-2xl ring-[30px] ring-white group-hover:scale-110 group-hover:rotate-12 transition-all duration-1000 italic">
                        <i class="fas fa-user-astronaut text-9xl text-[#FF6B00] italic drop-shadow-2xl font-bold"></i>
                    </div>
                </div>
                <h3 class="text-5xl font-black text-slate-800 tracking-tighter uppercase italic leading-none mb-6 italic">Radar Despejado</h3>
                <p class="text-slate-400 font-bold text-[11px] uppercase tracking-[0.4em] max-w-sm mx-auto italic opacity-70 italic leading-relaxed italic">TODAS LAS EVIDENCIAS HAN SIDO PROCESADAS Y VALIDADAS EN EL NODO CENTRAL. EXCELENTE DESPLIEGUE OPERATIVO.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
