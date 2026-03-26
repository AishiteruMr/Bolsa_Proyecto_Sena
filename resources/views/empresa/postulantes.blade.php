@extends('layouts.dashboard')

@section('title', 'Filtrado de Talento | ' . (session('nombre') ?? 'Empresa'))

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
    
    <!-- Header Section -->
    <div class="space-y-8 px-4">
        <a href="{{ route('empresa.proyectos') }}" class="inline-flex items-center text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] hover:text-emerald-700 transition-all group italic">
            <i class="fas fa-chevron-left mr-3 group-hover:-translate-x-1 transition-transform italic text-emerald-500"></i> 
            RETORNAR AL PUERTO
        </a>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 italic">
            <div class="space-y-4 italic">
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none truncate max-w-2xl italic">
                    {{ $proyecto->pro_titulo_proyecto }}
                </h2>
                <p class="text-slate-400 text-lg uppercase italic font-black flex items-center gap-3 italic">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center text-xs italic shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-users-viewfinder italic"></i>
                    </span>
                    MERITOCRACIA Y GESTIÓN DE TALENTO SENA
                </p>
            </div>
            <div class="flex items-center gap-6 bg-slate-100 p-3 rounded-[2rem] border-4 border-white shadow-2xl italic">
                <div class="px-8 py-4 bg-white rounded-[1.5rem] shadow-xl border border-slate-50 text-center italic">
                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] block italic mb-1">TOTAL SOLICITUDES</span>
                    <span class="text-3xl font-black text-slate-900 italic">{{ str_pad(count($postulantes), 2, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Applicants Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10 px-4 italic">
        @forelse($postulantes as $p)
            <x-card class="group flex flex-col p-10 border-none shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-700 relative overflow-hidden bg-white rounded-[3.5rem] italic" shadow="none">
                <!-- Kinetic Background Element -->
                <div class="absolute -top-16 -right-16 w-48 h-48 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-[1500ms] opacity-50 italic"></div>
                
                <div class="relative flex items-start gap-8 italic">
                    <div class="relative shrink-0 italic">
                        <div class="w-24 h-24 rounded-[2.5rem] bg-slate-900 text-white flex items-center justify-center text-4xl font-black shadow-2xl transition-all group-hover:rotate-12 italic">
                            {{ strtoupper(substr($p->apr_nombre ?? 'A', 0, 1)) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-white rounded-2xl flex items-center justify-center border-4 border-slate-50 shadow-xl italic rotate-12">
                            <i class="fas fa-certificate text-emerald-500 text-sm italic"></i>
                        </div>
                    </div>

                    <div class="flex-1 space-y-2 min-w-0 italic">
                        <h4 class="text-xl font-black text-slate-900 truncate tracking-tight uppercase italic group-hover:text-emerald-500 transition-colors italic">{{ $p->apr_nombre }} {{ $p->apr_apellido }}</h4>
                        <x-badge class="bg-emerald-50 text-emerald-600 border-none px-4 py-1.5 rounded-full font-black text-[9px] uppercase tracking-widest italic italic">
                            {{ strtoupper($p->apr_programa ?? 'ESPECIALIDAD SENA') }}
                        </x-badge>
                        <div class="flex items-center gap-2 text-slate-300 font-bold text-[10px] pt-2 uppercase italic italic">
                            <i class="fas fa-envelope text-emerald-500 italic"></i>
                            <span class="truncate italic">{{ $p->usr_correo }}</span>
                        </div>
                    </div>
                </div>

                <!-- Metrics Slate -->
                <div class="relative mt-10 p-6 bg-slate-50 rounded-[2.5rem] border-2 border-white shadow-inner flex items-center justify-between italic">
                    <div class="space-y-1 italic">
                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] block italic">FECHA POSTULACIÓN</span>
                        <span class="text-xs font-black text-slate-900 uppercase italic italic">{{ \Carbon\Carbon::parse($p->pos_fecha)->format('d M, Y') }}</span>
                    </div>
                    <div>
                        @switch($p->pos_estado)
                            @case('Pendiente')
                                <x-badge variant="warning" class="bg-amber-100 text-amber-600 border-none px-5 py-2 rounded-xl font-black text-[9px] uppercase tracking-widest italic italic shadow-sm italic ring-1 ring-amber-200">PENDIENTE</x-badge>
                                @break
                            @case('Aprobada')
                                <x-badge variant="success" class="bg-emerald-100 text-emerald-600 border-none px-5 py-2 rounded-xl font-black text-[9px] uppercase tracking-widest italic italic shadow-sm italic ring-1 ring-emerald-200">APROBADO</x-badge>
                                @break
                            @case('Rechazada')
                                <x-badge variant="danger" class="bg-red-100 text-red-600 border-none px-5 py-2 rounded-xl font-black text-[9px] uppercase tracking-widest italic italic shadow-sm italic ring-1 ring-red-200">RECHAZADO</x-badge>
                                @break
                        @endswitch
                    </div>
                </div>

                <!-- Action Hub -->
                <div class="relative mt-10 flex items-center gap-4 pt-10 border-t border-slate-50 italic">
                    <x-button variant="secondary" class="flex-1 px-6 py-4 rounded-2xl border-4 border-slate-50 bg-white hover:bg-emerald-50 hover:text-emerald-600 text-[10px] font-black uppercase tracking-widest transition-all group/btn flex items-center justify-center gap-3 active:scale-95 italic italic shadow-xl">
                        <i class="fas fa-file-pdf group-hover/btn:scale-110 transition-transform italic text-slate-400"></i> PORTAFOLIO
                    </x-button>
                    
                    @if($p->pos_estado == 'Pendiente')
                        <div class="flex gap-4 italic font-bold">
                            <!-- APROBAR -->
                            <x-confirm-modal 
                                id="modal-aprobar-{{ $p->pos_id }}"
                                title="VINCULAR TALENTO"
                                message="¿Confirmas la vinculación de {{ $p->apr_nombre }} al proyecto? Esta acción iniciará la fase operativa para el aprendiz."
                                confirm-text="SÍ, VINCULAR"
                                variant="success">
                                <form action="{{ route('empresa.postulaciones.estado', $p->pos_id) }}" method="POST" class="shrink-0 italic">
                                    @csrf
                                    <input type="hidden" name="estado" value="Aprobada">
                                    <button type="button" @click="$dispatch('open-confirm-modal-modal-aprobar-{{ $p->pos_id }}')" 
                                        class="w-16 h-16 rounded-2xl bg-emerald-500 text-white shadow-2xl shadow-emerald-500/30 flex items-center justify-center hover:scale-110 active:scale-90 transition-all font-bold italic rotate-0 hover:rotate-6 italic" title="VINCULAR OPERATIVO">
                                        <i class="fas fa-check text-xl italic text-white flex items-center justify-center font-bold"></i>
                                    </button>
                                </form>
                            </x-confirm-modal>

                            <!-- RECHAZAR -->
                            <x-confirm-modal 
                                id="modal-rechazar-{{ $p->pos_id }}"
                                title="DECLINAR SOLICITUD"
                                message="¿Estás seguro de que deseas rechazar la postulación de {{ $p->apr_nombre }}? Esta acción es irreversible."
                                confirm-text="SÍ, DECLINAR"
                                variant="danger">
                                <form action="{{ route('empresa.postulaciones.estado', $p->pos_id) }}" method="POST" class="shrink-0 italic">
                                    @csrf
                                    <input type="hidden" name="estado" value="Rechazada">
                                    <button type="button" @click="$dispatch('open-confirm-modal-modal-rechazar-{{ $p->pos_id }}')" 
                                        class="w-16 h-16 rounded-2xl bg-white border-4 border-slate-50 text-slate-300 hover:bg-red-50 hover:text-red-500 hover:border-red-100 flex items-center justify-center hover:scale-110 active:scale-90 transition-all font-bold italic rotate-0 hover:-rotate-6 italic shadow-xl" title="DECLINAR SOLICITUD">
                                        <i class="fas fa-times text-xl italic flex items-center justify-center font-bold"></i>
                                    </button>
                                </form>
                            </x-confirm-modal>
                        </div>
                    @endif
                </div>
            </x-card>
        @empty
            <div class="col-span-full py-32 italic font-bold">
                <div class="max-w-md mx-auto text-center space-y-10 italic">
                    <div class="w-32 h-32 bg-slate-50 rounded-[3.5rem] border-8 border-white shadow-2xl flex items-center justify-center mx-auto text-slate-200 rotate-12 italic">
                        <i class="fas fa-radar text-5xl animate-pulse italic"></i>
                    </div>
                    <div class="space-y-4 italic">
                        <h4 class="text-3xl font-black text-slate-900 uppercase tracking-tighter italic">Buscando Talentos</h4>
                        <p class="text-slate-400 font-bold uppercase italic text-sm tracking-widest leading-relaxed italic">TU MISIÓN ESTÁ EN EL RADAR SENA. LAS SOLICITUDES SE SINCRONIZARÁN AQUÍ EN TIEMPO REAL.</p>
                    </div>
                    <x-button variant="secondary" :href="route('empresa.proyectos')" class="rounded-3xl px-12 py-5 border-4 border-slate-50 bg-white text-[11px] font-black uppercase tracking-widest shadow-2xl active:scale-95 transition-all text-slate-400 italic italic">
                        RETORNAR AL COMANDO
                    </x-button>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
