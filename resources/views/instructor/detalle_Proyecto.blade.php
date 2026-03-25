@extends('layouts.dashboard')

@section('title', 'Consola de Comando | ' . ($proyecto->pro_titulo_proyecto ?? 'Detalle'))

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
    
    <!-- PROJECT HERO & MAIN INFO -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start px-4 italic">
        
        <!-- Main Management Pillar -->
        <div class="lg:col-span-2 space-y-12 italic">
            
            <!-- Project Hero Card -->
            <x-card class="p-0 overflow-hidden border-none shadow-2xl group rounded-[4rem] bg-white italic" shadow="none">
                <div class="relative h-[450px] md:h-[550px] overflow-hidden italic">
                    <img src="{{ $proyecto->imagen_url ?? 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=1200' }}" 
                         alt="{{ $proyecto->pro_titulo_proyecto }}" 
                         class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110 group-hover:rotate-1 italic">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent italic"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-12 md:p-16 space-y-8 italic">
                        <div class="flex flex-wrap items-end justify-between gap-8 italic">
                            <div class="space-y-6 flex-1 min-w-[350px] italic">
                                <div class="flex items-center gap-4 italic font-bold">
                                    <x-badge class="bg-emerald-500 text-white border-none py-2 px-6 rounded-xl text-[10px] font-black uppercase italic shadow-2xl shadow-emerald-500/40 italic">
                                        {{ strtoupper($proyecto->pro_categoria) }}
                                    </x-badge>
                                    <div class="h-1 w-12 bg-white/20 rounded-full italic"></div>
                                    <span class="text-white/60 text-[10px] font-black uppercase tracking-[0.3em] italic">IDENTIFICACIÓN: #{{ str_pad($proyecto->pro_id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-[0.9] uppercase italic drop-shadow-2xl italic">
                                    {{ $proyecto->pro_titulo_proyecto }}
                                </h1>
                                <p class="text-emerald-400 font-black text-sm uppercase tracking-[0.4em] flex items-center gap-4 italic opacity-80 italic">
                                    <i class="fas fa-building text-2xl italic font-bold"></i> 
                                    {{ strtoupper($proyecto->empresa?->emp_nombre ?? 'CORP. ASOCIADA') }}
                                </p>
                            </div>
                            <x-button variant="secondary" class="bg-white/10 backdrop-blur-xl border-2 border-white/20 text-white hover:bg-white hover:text-slate-900 text-[10px] font-black uppercase py-5 px-10 rounded-2xl italic shadow-2xl shadow-black/40 transition-all active:scale-95 italic" onclick="document.getElementById('uploadForm').classList.toggle('hidden')">
                                <i class="fas fa-camera mr-3 italic"></i> CAMBIAR PORTADA
                            </x-button>
                        </div>
                    </div>
                </div>

                <div id="uploadForm" class="hidden p-12 bg-slate-900 border-b border-white/5 animate-in slide-in-from-top duration-700 italic">
                    <form action="{{ route('instructor.proyectos.imagen', $proyecto->pro_id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-8 italic font-bold">
                        @csrf
                        <div class="flex-1 relative italic">
                            <input type="file" name="imagen" accept="image/*" required 
                                class="w-full px-8 py-6 rounded-2xl border-4 border-dashed border-white/10 bg-white/5 font-black text-white/40 text-sm focus:border-emerald-500/40 transition-all cursor-pointer hover:border-emerald-500/20 uppercase italic italic">
                        </div>
                        <x-button variant="primary" type="submit" shadow="emerald" class="px-12 py-6 text-[10px] font-black uppercase italic shadow-2xl">EJECUTAR ACTUALIZACIÓN</x-button>
                    </form>
                </div>

                <div class="p-12 md:p-16 space-y-16 italic">
                    <!-- Quick Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 italic font-bold">
                        <div class="p-8 rounded-[2.5rem] bg-slate-50 border-4 border-white shadow-xl space-y-4 group/stat hover:bg-emerald-50 transition-all italic">
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic group-hover/stat:text-emerald-600 transition-colors italic leading-none">FECHA DE LANZAMIENTO</p>
                            <p class="text-2xl font-black text-slate-900 italic uppercase italic leading-none">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->translatedFormat('d M, Y') }}</p>
                        </div>
                        <div class="p-8 rounded-[2.5rem] bg-slate-50 border-4 border-white shadow-xl space-y-4 group/stat hover:bg-blue-50 transition-all italic">
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic group-hover/stat:text-blue-600 transition-colors italic leading-none">DURACIÓN ESTIMADA</p>
                            <p class="text-2xl font-black text-slate-900 italic uppercase italic leading-none">{{ str_pad($proyecto->pro_duracion_estimada, 2, '0', STR_PAD_LEFT) }} DÍAS</p>
                        </div>
                        <div class="p-8 rounded-[2.5rem] bg-slate-50 border-4 border-white shadow-xl space-y-4 group/stat hover:bg-amber-50 transition-all italic">
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic group-hover/stat:text-amber-600 transition-colors italic leading-none">SECTOR IMPACTO</p>
                            <p class="text-2xl font-black text-slate-900 italic uppercase italic leading-none truncate italic">{{ strtoupper($proyecto->pro_ubicacion ?? 'GLOBAL') }}</p>
                        </div>
                    </div>

                    <div class="space-y-8 italic">
                        <div class="flex items-center gap-6 italic">
                            <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-2xl italic rotate-6">
                                <i class="fas fa-file-invoice text-xl font-bold italic"></i>
                            </div>
                            <div class="italic">
                                <h4 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic leading-none">Protocolos del Proyecto</h4>
                                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3 italic opacity-60 italic">MEMORÁNDUM DE ESPECIFICACIONES TÉCNICAS</p>
                            </div>
                        </div>
                        <div class="text-slate-500 leading-relaxed text-lg font-bold uppercase italic tracking-tight opacity-80 whitespace-pre-line italic border-l-8 border-emerald-500 pl-10 italic">
                            {{ $proyecto->pro_description ?? $proyecto->pro_descripcion }}
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Working Plan (Stages) -->
            <x-card class="p-12 md:p-16 border-none shadow-2xl rounded-[4rem] bg-slate-900 relative overflow-hidden italic" shadow="none">
                <div class="absolute -right-20 -top-20 text-[20rem] text-white/5 opacity-10 pointer-events-none transform -rotate-12 italic">
                    <i class="fas fa-route italic"></i>
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-10 mb-20 relative z-10 italic">
                    <div class="space-y-4 italic">
                        <h3 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase italic leading-none italic">Mapa de Ruta <span class="text-emerald-500">Técnica</span></h3>
                        <p class="text-white/40 font-black text-[10px] uppercase tracking-[0.4em] italic leading-none italic">ORQUESTACIÓN DE EVIDENCIAS Y HITOS OPERATIVOS</p>
                    </div>
                    <x-button variant="primary" shadow="emerald" class="px-10 py-5 rounded-[1.5rem] text-[10px] font-black uppercase italic shadow-2xl hover:scale-105 transition-all active:scale-95 italic" onclick="document.getElementById('stageForm').classList.toggle('hidden')">
                        <i class="fas fa-plus mr-3 italic font-bold"></i> INCORPORAR ETAPA
                    </x-button>
                </div>

                <div id="stageForm" class="hidden mb-16 p-12 bg-white/5 rounded-[3rem] border-4 border-dashed border-white/5 animate-in zoom-in-95 duration-700 relative z-10 italic">
                    <form action="{{ route('instructor.etapas.crear', $proyecto->pro_id) }}" method="POST" class="space-y-10 italic font-bold">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 italic">
                            <div class="space-y-4 italic">
                                <label class="text-[9px] font-black text-white/40 uppercase tracking-[0.4em] ml-4 italic">SECUENCIA</label>
                                <input type="number" name="orden" placeholder="IDX" required class="w-full px-8 py-6 rounded-2xl bg-white/5 border-none text-white font-black focus:ring-4 focus:ring-emerald-500/20 italic placeholder:text-white/10 uppercase italic">
                            </div>
                            <div class="md:col-span-3 space-y-4 italic">
                                <label class="text-[9px] font-black text-white/40 uppercase tracking-[0.4em] ml-4 italic">DENOMINACIÓN DE LA FASE</label>
                                <input type="text" name="nombre" placeholder="EJ: ANÁLISIS DE SISTEMAS" required class="w-full px-8 py-6 rounded-2xl bg-white/5 border-none text-white font-black focus:ring-4 focus:ring-emerald-500/20 italic placeholder:text-white/10 uppercase italic tracking-tighter">
                            </div>
                        </div>
                        <div class="space-y-4 italic">
                            <label class="text-[9px] font-black text-white/40 uppercase tracking-[0.4em] ml-4 italic">ESPECIFICACIONES TÉCNICAS (ENTREGABLES)</label>
                            <textarea name="descripcion" placeholder="DETALLE LAS EVIDENCIAS REQUERIDAS PARA ESTA ETAPA OPERATIVA..." required class="w-full px-8 py-8 rounded-2xl bg-white/5 border-none text-white font-black focus:ring-4 focus:ring-emerald-500/20 italic placeholder:text-white/10 min-h-[160px] uppercase italic tracking-tight"></textarea>
                        </div>
                        <div class="flex justify-end gap-6 italic">
                            <x-button variant="outline" type="button" class="border-white/10 text-white/40 hover:bg-white/10 text-[9px] font-black uppercase italic py-4 px-8 rounded-xl italic" onclick="document.getElementById('stageForm').classList.add('hidden')">ABORTAR</x-button>
                            <x-button variant="primary" type="submit" shadow="emerald" class="py-5 px-12 text-[10px] font-black uppercase italic shadow-2xl italic">PUBLICAR FASE ACADÉMICA</x-button>
                        </div>
                    </form>
                </div>

                <div class="space-y-10 relative before:absolute before:left-12 before:top-4 before:bottom-4 before:w-1.5 before:bg-white/5 before:rounded-full italic px-2 italic">
                    @forelse($etapas as $index => $etapa)
                        <div class="group relative bg-white pb-10 pt-10 px-12 rounded-[3.5rem] shadow-2xl hover:shadow-emerald-500/10 transition-all duration-700 italic border-4 border-transparent hover:border-emerald-500/10 italic">
                            <div class="absolute -left-[4.25rem] md:-left-[5.25rem] top-10 w-16 h-16 rounded-[1.5rem] {{ $index == 0 ? 'bg-emerald-500 text-white shadow-2xl shadow-emerald-500/40' : 'bg-slate-800 text-white shadow-2xl shadow-black/40' }} border-8 border-slate-900 shadow-xl flex items-center justify-center font-black text-2xl z-20 transition-all duration-700 group-hover:scale-110 group-hover:rotate-12 italic">
                                {{ str_pad($etapa->eta_orden, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            
                            <div class="flex justify-between items-start gap-10 italic">
                                <div class="space-y-6 flex-1 italic">
                                    <h4 class="text-3xl font-black text-slate-900 group-hover:text-emerald-500 transition-colors uppercase italic tracking-tighter italic leading-none">{{ $etapa->eta_nombre }}</h4>
                                    <p class="text-slate-400 font-bold text-base uppercase tracking-tight leading-relaxed italic opacity-80 italic italic">{{ $etapa->eta_descripcion }}</p>
                                </div>
                                <form action="{{ route('instructor.etapas.eliminar', $etapa->eta_id) }}" method="POST" id="delete-stage-form-{{ $etapa->eta_id }}" class="shrink-0 italic">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @click="$dispatch('open-modal-delete-stage-{{ $etapa->eta_id }}')" class="w-16 h-16 rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-500 flex items-center justify-center shadow-xl italic active:scale-95 italic">
                                        <i class="fas fa-trash-alt text-xl italic font-bold"></i>
                                    </button>
                                </form>

                                <x-confirm-modal 
                                    id="delete-stage-{{ $etapa->eta_id }}"
                                    title="Eliminar Etapa"
                                    message="¿Deseas eliminar esta fase académica? Esta acción borrará todas las evidencias y calificaciones vinculadas a esta etapa."
                                    confirmText="ELIMINAR FASE"
                                    action="{{ route('instructor.etapas.eliminar', $etapa->eta_id) }}"
                                    method="DELETE"
                                />
                            </div>
                        </div>
                    @empty
                        <div class="py-32 text-center bg-white/5 rounded-[4rem] border-8 border-dashed border-white/5 italic">
                            <div class="mb-10 inline-flex p-10 rounded-[2.5rem] bg-white/5 text-white/10 shadow-inner italic rotate-12 italic group hover:rotate-0 transition-transform italic">
                                <i class="fas fa-terminal text-6xl italic font-bold"></i>
                            </div>
                            <h4 class="text-2xl font-black text-white uppercase italic tracking-widest italic leading-none">Sin Misiones Operativas</h4>
                            <p class="text-white/30 mt-6 max-w-sm mx-auto text-[10px] font-black uppercase tracking-[0.3em] italic leading-relaxed italic">CONECTE EL DESPLIEGUE OPERATIVO PARA QUE EL EQUIPO PUEDA INICIAR LA CARGA DE PROTOCOLOS TÉCNICOS.</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>

        <!-- Sidebar Management Pillar -->
        <div class="space-y-12 lg:sticky lg:top-12 font-bold italic">
            
            <!-- Quick Stats & Status -->
            <x-card class="p-12 text-center border-none shadow-2xl rounded-[3.5rem] overflow-hidden relative bg-white italic" shadow="none">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-bl-[120px] italic"></div>
                
                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] mb-10 italic opacity-60 italic leading-none">ESTADO DEL DESPLIEGUE</p>
                <div class="inline-flex items-center gap-4 px-10 py-5 rounded-[2rem] bg-emerald-50 text-emerald-600 font-black text-[10px] uppercase tracking-[0.2em] border-2 border-emerald-100 mb-12 shadow-xl italic shadow-emerald-500/5 italic">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-ping italic"></span>
                    {{ strtoupper($proyecto->pro_estado) }}
                </div>
                
                <div class="grid grid-cols-2 gap-10 border-t border-slate-50 pt-12 italic">
                    <div class="space-y-3 italic">
                        <p class="text-5xl font-black text-slate-900 italic tracking-tighter leading-none italic">{{ str_pad($integrantes->count(), 2, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic opacity-60 italic">OPERADORES</p>
                    </div>
                    <div class="space-y-3 border-l border-slate-50 italic">
                        <p class="text-5xl font-black text-emerald-500 italic tracking-tighter leading-none italic">{{ str_pad($etapas->count(), 2, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic opacity-60 italic">HITOS</p>
                    </div>
                </div>
            </x-card>

            <!-- Management Suite -->
            <div class="grid grid-cols-1 gap-6 italic font-bold">
                <x-button href="{{ route('instructor.reporte', $proyecto->pro_id) }}" variant="primary" shadow="emerald" class="w-full justify-center py-7 rounded-[2.5rem] group shadow-2xl shadow-emerald-500/10 italic text-[11px] uppercase tracking-widest italic">
                    <i class="fas fa-chart-bar mr-4 group-hover:rotate-12 transition-transform italic font-bold"></i> REPORTE DE GESTIÓN
                </x-button>
                <x-button href="{{ route('instructor.evidencias.ver', $proyecto->pro_id) }}" variant="secondary" shadow="blue" class="w-full justify-center py-7 rounded-[2.5rem] bg-blue-600 hover:bg-blue-700 group border-none text-white italic shadow-2xl shadow-blue-500/20 text-[11px] uppercase tracking-widest italic">
                    <i class="fas fa-microscope mr-4 group-hover:scale-110 transition-transform italic font-bold"></i> VALIDAR EVIDENCIAS
                </x-button>
            </div>

            <!-- Postulations Pool -->
            <x-card class="p-0 border-none shadow-2xl rounded-[3.5rem] overflow-hidden bg-white italic font-bold" shadow="none">
                <div class="p-10 bg-slate-50 border-b border-slate-100 flex items-center justify-between italic">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic opacity-80 italic leading-none">RADAR DE ASPIRANTES</h4>
                    <x-badge class="bg-amber-500 text-white border-none py-2 px-5 text-[9px] font-black rounded-xl italic shadow-2xl shadow-amber-500/30 italic">
                        {{ $postulaciones->where('pos_estado', 'Pendiente')->count() }} PENDIENTES
                    </x-badge>
                </div>
                <div class="p-10 space-y-6 max-h-[550px] overflow-y-auto custom-scrollbar italic">
                    @forelse($postulaciones->where('pos_estado', 'Pendiente') as $p)
                        <div class="p-8 rounded-[3rem] bg-white border-4 border-slate-50 shadow-xl space-y-8 hover:shadow-emerald-500/5 hover:border-emerald-500/10 transition-all group italic font-bold">
                            <div class="flex items-center gap-6 italic">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-black text-2xl shadow-2xl shadow-emerald-500/20 group-hover:rotate-12 transition-transform italic border-4 border-white italic">
                                    {{ substr($p->aprendiz->apr_nombre ?? 'A', 0, 1) }}
                                </div>
                                <div class="min-w-0 italic">
                                    <p class="text-base font-black text-slate-900 truncate uppercase italic tracking-tighter italic leading-none">{{ $p->aprendiz->apr_nombre }}</p>
                                    <p class="text-[9px] font-black text-slate-400 truncate uppercase tracking-[0.3em] italic opacity-60 mt-2 italic">{{ strtoupper($p->aprendiz->apr_programa ?? 'TÉCNICO OPERATIVO') }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 italic font-bold">
                                <!-- ALTA -->
                                <x-confirm-modal 
                                    id="modal-alta-{{ $p->pos_id }}"
                                    title="ALTA OPERATIVA"
                                    message="¿Confirmas el alta de {{ $p->aprendiz->apr_nombre }}? Esta acción integrará al aprendiz al equipo operativo del proyecto."
                                    confirm-text="CONFIRMAR ALTA"
                                    variant="success">
                                    <form action="{{ route('instructor.postulaciones.estado', $p->pos_id) }}" method="POST" class="italic">
                                        @csrf
                                        <input type="hidden" name="estado" value="Aprobada">
                                        <button type="button" @click="$dispatch('open-confirm-modal-modal-alta-{{ $p->pos_id }}')" 
                                            class="w-full py-4 rounded-2xl bg-emerald-50 text-emerald-700 font-black text-[10px] hover:bg-emerald-600 hover:text-white transition-all uppercase tracking-widest italic shadow-sm active:scale-95">ALTA</button>
                                    </form>
                                </x-confirm-modal>

                                <!-- BAJA -->
                                <x-confirm-modal 
                                    id="modal-baja-{{ $p->pos_id }}"
                                    title="DECLINAR SOLICITUD"
                                    message="¿Confirmas la baja de la solicitud de {{ $p->aprendiz->apr_nombre }}? Esta acción es irreversible."
                                    confirm-text="CONFIRMAR BAJA"
                                    variant="danger">
                                    <form action="{{ route('instructor.postulaciones.estado', $p->pos_id) }}" method="POST" class="italic">
                                        @csrf
                                        <input type="hidden" name="estado" value="Rechazada">
                                        <button type="button" @click="$dispatch('open-confirm-modal-modal-baja-{{ $p->pos_id }}')" 
                                            class="w-full py-4 rounded-2xl bg-red-50 text-red-600 font-black text-[10px] hover:bg-red-600 hover:text-white transition-all uppercase tracking-widest italic shadow-sm active:scale-95">BAJA</button>
                                    </form>
                                </x-confirm-modal>
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center italic opacity-40">
                            <i class="fas fa-satellite-dish text-5xl text-slate-200 mb-6 block italic animate-pulse italic"></i>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">Sin señales activas</p>
                        </div>
                    @endforelse
                </div>
            </x-card>

            <!-- Current Team -->
            <x-card class="p-0 border-none shadow-2xl rounded-[3.5rem] overflow-hidden bg-white italic font-bold" shadow="none">
                <div class="p-10 bg-slate-900 text-white flex items-center justify-between italic">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] italic opacity-60 italic leading-none">EQUIPO OPERATIVO</h4>
                    <span class="text-3xl font-black italic tracking-tighter italic leading-none">{{ str_pad($integrantes->count(), 2, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="p-10 space-y-5 italic">
                    @forelse($integrantes as $i)
                        <div class="flex items-center gap-6 p-6 rounded-[2.5rem] bg-slate-50 hover:bg-emerald-50 border-4 border-white hover:border-emerald-500/10 transition-all group shadow-xl italic font-bold">
                            <div class="w-14 h-14 rounded-2xl bg-white shadow-2xl flex items-center justify-center border-4 border-emerald-500/10 italic group-hover:scale-110 group-hover:rotate-6 transition-transform">
                                <span class="text-lg font-black text-emerald-600 italic">{{ substr($i->aprendiz->apr_nombre, 0, 1) }}</span>
                            </div>
                            <div class="min-w-0 italic">
                                <p class="text-sm font-black text-slate-900 uppercase italic tracking-tighter truncate italic leading-none">{{ $i->aprendiz->apr_nombre }} {{ $i->aprendiz->apr_apellido }}</p>
                                <p class="text-[9px] font-black text-slate-300 lowercase tracking-widest truncate italic opacity-60 mt-2 italic">{{ $i->aprendiz->usuario->usr_correo }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center italic opacity-40">
                            <i class="fas fa-ghost text-5xl text-slate-200 mb-6 block italic italic"></i>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] italic leading-none">Equipo Inexistente</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
