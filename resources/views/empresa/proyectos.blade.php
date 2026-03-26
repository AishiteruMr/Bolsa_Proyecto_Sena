@extends('layouts.dashboard')

@section('title', 'Portafolio de Proyectos | ' . (session('nombre') ?? 'Empresa'))

@section('sidebar-nav')

    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic text-slate-400">OPERACIÓN TÉCNICA</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item group {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line group-hover:scale-110 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400 text-slate-400">Centro de Mando</span>
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item group {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram group-hover:rotate-12 transition-transform italic text-[#FF6B00]"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Mis Proyectos</span>
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item group {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle group-hover:scale-110 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Lanzar Misión</span>
    </a>
    
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mt-6 mb-2 block italic text-slate-400">CONFIGURACIÓN</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item group {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building group-hover:rotate-12 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Perfil Corporativo</span>
    </a>

@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-16 font-bold italic">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 px-4">
        <div class="space-y-6">
            <div class="flex items-center gap-5 italic font-bold">
                <x-badge class="bg-[#FF6B00] text-white border-none px-5 py-2 rounded-2xl text-[9px] font-black uppercase tracking-[0.2em] shadow-xl shadow-[#FF6B00]/20 italic">ARCHIVO CORPORATIVO</x-badge>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#FF6B00] animate-pulse shadow-lg shadow-[#FF6B00]/20"></span>
                    <span class="text-slate-400 text-[10px] uppercase font-black tracking-widest italic opacity-60">SISTEMA DE GESTIÓN ACTIVO</span>
                </div>
            </div>
            <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                MIS <span class="text-[#FF6B00]">PROYECTOS</span>
            </h2>
            <p class="text-slate-400 text-lg uppercase italic font-bold max-w-2xl">
                SUPERVISIÓN CENTRALIZADA DE LAS PROPUESTAS TÉCNICAS Y EL IMPACTO DE TU INVERSIÓN EN TALENTO SENA.
            </p>
        </div>
        <x-button variant="primary" :href="route('empresa.proyectos.crear')" shadow="orange" class="py-6 px-10 rounded-[2rem] group flex items-center gap-4 text-[10px] font-black uppercase italic shadow-2xl active:scale-95 transition-all text-white">
            <i class="fas fa-plus group-hover:rotate-90 transition-transform italic text-lg"></i>
            NUEVA INICIATIVA
        </x-button>
    </div>

    <!-- Main Content Card -->
    <div class="px-4">
        <x-card class="p-0 border-none shadow-2xl rounded-[4rem] bg-white overflow-hidden group italic" shadow="none">
            @if($proyectos->isNotEmpty())
                <div class="overflow-x-auto italic font-bold">
                    <table class="w-full text-left border-separate border-spacing-y-5 px-10 md:px-14 italic font-bold">
                        <thead>
                            <tr class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] italic opacity-60 italic">
                                <th class="pb-2 px-6 italic">IDENTIFICADOR DE MISIÓN</th>
                                <th class="pb-2 px-6 italic">DIVISIÓN TÉCNICA</th>
                                <th class="pb-2 px-6 text-center italic font-bold">ESTADO OPERATIVO</th>
                                <th class="pb-2 px-6 text-center italic font-bold">CRONOGRAMA</th>
                                <th class="pb-2 px-6 text-right italic font-bold">GESTIÓN</th>
                            </tr>
                        </thead>
                        <tbody class="italic font-bold">
                            @foreach($proyectos as $proyecto)
                                <tr class="group/row italic">
                                    <td class="px-8 py-8 bg-slate-50 rounded-l-[2rem] border-none group-hover/row:bg-orange-50 transition-all duration-300 italic font-bold">
                                        <div class="space-y-2 italic text-slate-900">
                                            <p class="text-sm font-black text-slate-900 uppercase italic tracking-tighter leading-tight group-hover/row:text-orange-700 transition-colors">
                                                {{ Str::limit($proyecto->pro_titulo_proyecto, 60) }}
                                            </p>
                                            <div class="flex items-center gap-3 text-[9px] font-black text-slate-400 uppercase italic opacity-60 italic">
                                                <i class="far fa-clock text-[#FF6B00] italic"></i>
                                                <span>LANZADO: {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->translatedFormat('d M, Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-8 bg-slate-50 border-none group-hover/row:bg-orange-50 transition-all duration-300 italic">
                                        <x-badge class="bg-white text-slate-500 border-none px-4 py-2 rounded-xl text-[9px] font-black italic shadow-sm uppercase tracking-widest italic group-hover/row:text-[#E65100]">
                                            {{ $proyecto->pro_categoria }}
                                        </x-badge>
                                    </td>
                                    <td class="px-8 py-8 bg-slate-50 border-none text-center group-hover/row:bg-orange-50 transition-all duration-300 italic">
                                        @php
                                            $statusColor = match($proyecto->pro_estado) {
                                                'Activo', 'Aprobado', 'Ejecución' => 'bg-[#FF6B00] shadow-[#FF6B00]/20',
                                                'Pendiente' => 'bg-amber-500 shadow-amber-500/20',
                                                'Cerrado', 'Rechazado' => 'bg-red-500 shadow-red-500/20',
                                                default => 'bg-slate-500 shadow-slate-500/20'
                                            };
                                        @endphp
                                        <x-badge class="{{ $statusColor }} text-white border-none py-2 px-5 text-[9px] font-black italic shadow-lg uppercase tracking-widest italic">
                                            {{ strtoupper($proyecto->pro_estado) }}
                                        </x-badge>
                                    </td>
                                    <td class="px-8 py-8 bg-slate-50 border-none text-center group-hover/row:bg-orange-50 transition-all duration-300 italic">
                                        <div class="inline-flex flex-col items-center italic text-slate-900">
                                            <span class="text-2xl font-black text-slate-900 group-hover/row:text-[#E65100] transition-colors italic tracking-tighter leading-none">{{ $proyecto->pro_duracion_estimada }}</span>
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic opacity-60 italic">DÍAS ESTIMADOS</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-8 bg-slate-50 rounded-r-[2rem] border-none text-right group-hover/row:bg-orange-50 transition-all duration-300 italic font-bold">
                                        <div class="flex items-center justify-end gap-3 italic font-bold">
                                            <a href="{{ route('empresa.proyectos.edit', $proyecto->pro_id) }}" 
                                               class="w-12 h-12 rounded-[1.25rem] bg-white border border-slate-100 text-slate-400 hover:text-[#FF6B00] hover:border-[#FF6B00] shadow-xl transition-all hover:scale-110 active:scale-95 italic font-bold flex items-center justify-center">
                                                <i class="fas fa-terminal text-lg italic font-bold"></i>
                                            </a>
                                            <form action="{{ route('empresa.proyectos.destroy', $proyecto->pro_id) }}" method="POST" id="delete-form-{{ $proyecto->pro_id }}" class="inline italic font-bold">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" @click="$dispatch('open-modal-delete-{{ $proyecto->pro_id }}')" class="w-12 h-12 rounded-[1.25rem] bg-white border border-slate-100 text-slate-400 hover:text-red-500 hover:border-red-500 shadow-xl transition-all hover:scale-110 active:scale-95 italic font-bold flex items-center justify-center">
                                                    <i class="fas fa-trash-alt text-lg italic font-bold"></i>
                                                </button>
                                            </form>

                                            <x-confirm-modal 
                                                id="delete-{{ $proyecto->pro_id }}"
                                                title="Eliminar Proyecto"
                                                message="¿Estás seguro de que deseas eliminar este proyecto de forma permanente? Esta acción borrará todas las postulaciones y evidencias asociadas."
                                                confirmText="ELIMINAR DEFINITIVAMENTE"
                                                action="{{ route('empresa.proyectos.destroy', $proyecto->pro_id) }}"
                                                method="DELETE"
                                            />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-40 text-center italic">
                    <div class="mb-10 inline-flex p-10 rounded-[3rem] bg-slate-50 text-slate-100 shadow-inner ring-8 ring-slate-100 italic">
                        <i class="fas fa-folder-open text-7xl text-slate-200/50 italic animate-pulse"></i>
                    </div>
                    <div class="space-y-4 italic">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] italic mb-2">BÓVEDA VACÍA</p>
                        <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter">SIN PROYECTOS REGISTRADOS</h3>
                        <p class="text-slate-400 font-bold max-w-sm mx-auto uppercase text-sm italic">LANZA TU PRIMERA INICIATIVA Y ENCUENTRA EL TALENTO IDEAL EN ÓRBITA SENA.</p>
                    </div>
                    <div class="mt-12">
                        <x-button variant="primary" :href="route('empresa.proyectos.crear')" shadow="orange" class="py-6 px-12 rounded-2xl text-[11px] font-black uppercase italic shadow-2xl active:scale-95">
                            ESTABLECER CONEXIÓN <i class="fas fa-rocket ml-3 italic"></i>
                        </x-button>
                    </div>
                </div>
            @endif
        </x-card>
    </div>
</div>
@endsection

