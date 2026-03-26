@extends('layouts.dashboard')

@section('title', 'Expediente de Misión | ' . $proyecto->pro_titulo_proyecto)

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
<div class="max-w-7xl mx-auto space-y-12 pb-24 italic font-bold text-slate-900">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start italic">
        
        <!-- Main Content Pillar -->
        <div class="lg:col-span-2 space-y-12 italic">
            
            <!-- Header Hero Section -->
            <x-card class="overflow-hidden border-none shadow-2xl rounded-[4rem] group relative italic" shadow="none">
                <div class="relative h-[480px] bg-slate-900 overflow-hidden italic">
                    <img src="{{ $proyecto->pro_imagen_url ?: asset('assets/proyecto_default.jpg') }}" alt="Proyecto" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2000ms] opacity-80 italic">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
                    
                    <div class="absolute top-10 left-10 italic">
                        <x-badge class="bg-[#FF6B00] text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic shadow-2xl italic">
                            {{ strtoupper($proyecto->pro_categoria) }}
                        </x-badge>
                    </div>

                    <div class="absolute bottom-16 left-12 right-12 space-y-6 italic">
                        <h2 class="text-6xl md:text-7xl font-black text-white tracking-tighter uppercase italic leading-[0.9] drop-shadow-2xl italic">
                            {{ $proyecto->pro_titulo_proyecto }}
                        </h2>
                        <div class="flex items-center gap-6 italic">
                            <div class="h-1 w-24 bg-[#FF6B00] rounded-full italic"></div>
                            <span class="text-white/60 text-xs font-black uppercase tracking-[0.3em] italic">EXPEDIENTE DE MISIÓN ACTIVA</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-12 md:p-16 space-y-10 bg-white italic">
                    <div class="space-y-6 italic">
                        <div class="flex items-center gap-4 italic font-black text-slate-900 uppercase tracking-tighter text-xl italic">
                            <i class="fas fa-align-left text-[#FF6B00] italic"></i>
                            RESUMEN EJECUTIVO DE LA CONVOCATORIA
                        </div>
                        <div class="text-slate-400 font-bold text-lg leading-relaxed text-justify px-2 italic uppercase">
                            {!! nl2br(e($proyecto->pro_descripcion)) !!}
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Bento Grid for Requirements -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 italic">
                <x-card class="p-10 border-none shadow-xl rounded-[3rem] bg-slate-50 space-y-8 relative overflow-hidden italic" shadow="none">
                    <div class="absolute -right-8 -top-8 w-24 h-24 bg-[#FF6B00]/5 rounded-full italic"></div>
                    <div class="flex items-center gap-6 italic">
                        <div class="w-16 h-16 rounded-[1.5rem] bg-white text-[#FF6B00] flex items-center justify-center text-2xl shadow-xl italic rotate-3">
                            <i class="fas fa-microchip italic"></i>
                        </div>
                        <div class="italic">
                            <h4 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter">Ecosistema Técnico</h4>
                            <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.2em] italic opacity-60 italic">HARD SKILLS REQUERIDAS</p>
                        </div>
                    </div>
                    <p class="text-slate-500 font-bold text-sm leading-relaxed px-2 uppercase italic">
                        {{ $proyecto->pro_requisitos_especificos }}
                    </p>
                </x-card>

                <x-card class="p-10 border-none shadow-xl rounded-[3rem] bg-slate-900 space-y-8 relative overflow-hidden italic" shadow="none">
                    <div class="absolute -right-8 -top-8 w-24 h-24 bg-blue-500/10 rounded-full italic"></div>
                    <div class="flex items-center gap-6 italic">
                        <div class="w-16 h-16 rounded-[1.5rem] bg-blue-600 text-white flex items-center justify-center text-2xl shadow-2xl shadow-blue-500/20 italic -rotate-3">
                            <i class="fas fa-brain italic"></i>
                        </div>
                        <div class="italic">
                            <h4 class="text-xl font-black text-white uppercase italic tracking-tighter">Competencias Blandas</h4>
                            <p class="text-blue-400/60 text-[9px] font-black uppercase tracking-[0.2em] italic">SOFT SKILLS REQUERIDAS</p>
                        </div>
                    </div>
                    <p class="text-slate-400 font-bold text-sm leading-relaxed px-2 uppercase italic">
                        {{ $proyecto->pro_habilidades_requerida }}
                    </p>
                </x-card>
            </div>

            <!-- Stages Section -->
            <x-card class="p-12 md:p-16 border-none shadow-2xl rounded-[4rem] bg-white space-y-12 italic" shadow="none">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 border-b border-slate-100 pb-10 italic">
                    <div class="flex items-center gap-6 italic">
                        <div class="w-16 h-16 rounded-2xl bg-[#FF6B00] text-white flex items-center justify-center shadow-2xl shadow-[#FF6B00]/20 italic rotate-6">
                            <i class="fas fa-layer-group text-xl font-bold italic"></i>
                        </div>
                        <div class="italic">
                            <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic">Hoja de Ruta de Misión</h3>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] italic opacity-60 italic">ARQUITECTURA DE HITOS Y ENTREGAS</p>
                        </div>
                    </div>
                    <x-badge class="bg-slate-900 text-white border-none rounded-2xl px-8 py-3 font-black text-[11px] uppercase italic tracking-[0.2em] italic">
                        {{ count($etapas) }} HITOS SINCRO
                    </x-badge>
                </div>

                <div class="relative space-y-12 pl-16 before:absolute before:left-6 before:top-4 before:bottom-4 before:w-1.5 before:bg-slate-50 before:rounded-full italic">
                    @forelse($etapas as $index => $etapa)
                        <div class="relative group italic">
                            <!-- Timeline Dot -->
                            <div class="absolute -left-[54px] top-1 w-12 h-12 rounded-2xl {{ $index == 0 ? 'bg-[#FF6B00] shadow-2xl shadow-[#FF6B00]/30 text-white' : 'bg-white border-4 border-slate-50 text-slate-300' }} flex items-center justify-center text-sm font-black z-10 transition-all group-hover:scale-110 group-hover:rotate-6 italic">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            
                            <div class="space-y-3 italic">
                                <h5 class="text-xl font-black text-slate-900 group-hover:text-[#FF6B00] transition-colors uppercase italic tracking-tight italic">{{ $etapa->eta_nombre }}</h5>
                                <p class="text-slate-400 font-bold text-sm leading-relaxed uppercase italic italic opacity-70">{{ $etapa->eta_descripcion }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-slate-50 rounded-[3rem] border-4 border-dashed border-white shadow-inner px-10 italic">
                            <div class="w-20 h-20 rounded-3xl bg-white shadow-xl flex items-center justify-center mx-auto mb-6 text-slate-200 italic">
                                <i class="fas fa-stream text-3xl italic"></i>
                            </div>
                            <p class="text-slate-400 font-black text-xs uppercase tracking-[0.3em] italic">Planificación en progreso por el Líder Técnico</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>

        <!-- Sidebar Info Pillar -->
        <div class="space-y-10 sticky top-12 italic">
            
            <!-- Status Card -->
            <x-card class="p-10 border-none shadow-2xl rounded-[3rem] bg-white space-y-10 relative overflow-hidden group italic" shadow="none">
                <div class="absolute top-0 left-0 w-3 h-full bg-[#FF6B00] italic"></div>
                
                <div class="text-center space-y-6 italic">
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] block italic">Estado Operativo</span>
                    <x-badge class="bg-orange-50 text-[#E65100] border-none px-10 py-4 rounded-3xl text-xs font-black tracking-widest uppercase italic shadow-sm italic ring-1 ring-orange-100">
                        {{ strtoupper($proyecto->pro_estado) }}
                    </x-badge>
                </div>
                
                <div class="space-y-4 pt-10 border-t border-slate-50 italic">
                    <div class="flex flex-col gap-2 bg-slate-50 p-6 rounded-[2rem] border-2 border-slate-50 italic transition-all hover:bg-white hover:shadow-xl">
                        <span class="text-[9px] text-slate-400 uppercase tracking-[0.3em] italic">VENTANA DE EJECUCIÓN</span>
                        <div class="flex items-center justify-between italic">
                            <span class="text-[#FF6B00] text-lg italic"><i class="fas fa-clock italic"></i></span>
                            <span class="text-sm text-slate-900 font-black uppercase italic italic">{{ $proyecto->pro_duracion_estimada }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 bg-slate-50 p-6 rounded-[2rem] border-2 border-slate-50 italic transition-all hover:bg-white hover:shadow-xl">
                        <span class="text-[9px] text-slate-400 uppercase tracking-[0.3em] italic">COORDENADA TEMPORAL</span>
                        <div class="flex items-center justify-between italic">
                            <span class="text-[#FF6B00] text-lg italic"><i class="fas fa-calendar-alt italic"></i></span>
                            <span class="text-sm text-slate-900 font-black uppercase italic italic">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Instructor Assigned -->
            <x-card class="p-10 border-none shadow-xl rounded-[3rem] bg-slate-900 space-y-8 italic" shadow="none">
                <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] italic">Responsable Académico</h4>
                @if($proyecto->ins_nombre)
                    <div class="flex items-center gap-6 group italic">
                        <div class="w-16 h-16 rounded-2xl bg-white text-slate-900 flex items-center justify-center text-2xl font-black shadow-2xl transition-all group-hover:rotate-12 italic">
                            {{ substr($proyecto->ins_nombre, 0, 1) }}
                        </div>
                        <div class="space-y-1 italic">
                            <p class="text-sm font-black text-white uppercase tracking-tight italic">{{ $proyecto->ins_nombre }} {{ $proyecto->ins_apellido }}</p>
                            <div class="flex items-center gap-2 text-orange-400 italic">
                                <i class="fas fa-shield-check text-[10px] italic"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest italic">LÍDER TÉCNICO</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col gap-4 p-8 bg-white/5 rounded-[2rem] border border-white/10 items-center text-center italic">
                        <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-xl italic mb-2">
                             <i class="fas fa-user-clock italic"></i>
                        </div>
                        <p class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] italic leading-relaxed">Asignación de Comando Académico Pendiente</p>
                    </div>
                @endif
            </x-card>

            <!-- Call to Action -->
            <div class="space-y-6 italic">
                <x-button :href="route('empresa.proyectos.edit', $proyecto->pro_id)" variant="secondary" class="w-full py-6 rounded-[2rem] border-4 border-slate-50 bg-white font-black text-[10px] uppercase tracking-widest group flex items-center justify-center gap-4 shadow-xl hover:shadow-2xl active:scale-95 transition-all italic italic">
                    <i class="fas fa-edit group-hover:rotate-12 transition-transform italic text-slate-400"></i> MODIFICAR ARCHIVOS DE MISIÓN
                </x-button>
                <x-button :href="route('empresa.proyectos.postulantes', $proyecto->pro_id)" variant="primary" shadow="orange" class="w-full py-7 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.2em] flex items-center justify-center gap-4 shadow-2xl active:scale-95 transition-all italic italic">
                    <i class="fas fa-users-viewfinder text-lg italic text-white flex items-center justify-center"></i> EVALUAR OPERATIVOS
                </x-button>
            </div>
        </div>
    </div>
</div>
@endsection
section
