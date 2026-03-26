@extends('layouts.dashboard')

@section('title', 'Gestión Global de Proyectos')
@section('page-title', 'Centro de Control de Proyectos')

@section('sidebar-nav')

    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic text-slate-400">CONTROL CENTRAL</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item group {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line group-hover:scale-110 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Panel de Control</span>
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item group {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users-cog group-hover:rotate-12 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Usuarios Sistema</span>
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item group {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building group-hover:-translate-y-1 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Directorio Empresas</span>
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item group {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram group-hover:text-[#FF6B00] transition-colors italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Banco de Proyectos</span>
    </a>

@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-16">


    {{-- ── Header ─────────────────────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 px-4">
        <div class="space-y-4">
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                Gestión <span class="text-[#FF6B00] underline decoration-[#FF6B00]/20 decoration-8 underline-offset-8">Global</span>
            </h2>
            <p class="text-slate-400 font-bold text-sm uppercase tracking-widest flex items-center gap-3">
                <span class="w-12 h-px bg-slate-200"></span>
                Administración y auditoría de proyectos
            </p>
        </div>

        {{-- Quick stats --}}
        <div class="flex gap-3 flex-wrap">
            @php
                $counts = [
                    'todos'      => $proyectos->count(),
                    'pendientes' => $proyectos->where('pro_estado', 'Pendiente')->count(),
                    'aprobados'  => $proyectos->where('pro_estado', 'Aprobado')->count(),
                    'rechazados' => $proyectos->where('pro_estado', 'Rechazado')->count(),
                ]
            @endphp
            @foreach ([
                ['label' => 'Total',      'count' => $counts['todos'],      'color' => 'bg-slate-900 text-white'],
                ['label' => 'Pendientes', 'count' => $counts['pendientes'], 'color' => 'bg-amber-400 text-slate-900'],
                ['label' => 'Aprobados',  'count' => $counts['aprobados'],  'color' => 'bg-[#FF6B00] text-white'],
                ['label' => 'Rechazados', 'count' => $counts['rechazados'], 'color' => 'bg-red-500 text-white'],
            ] as $stat)
            <div class="flex items-center gap-2 px-4 py-2 rounded-2xl {{ $stat['color'] }} font-black text-xs uppercase tracking-widest shadow-sm">
                {{ $stat['count'] }} {{ $stat['label'] }}
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Filter Tabs ─────────────────────────────────────────────────── --}}
    @php $filtro = request('filtro', 'todos'); @endphp
    <div class="flex gap-2 flex-wrap px-4" id="filtros">
        @foreach ([
            ['key' => 'todos',      'label' => 'Todos'],
            ['key' => 'pendientes', 'label' => 'Pendientes'],
            ['key' => 'aprobados',  'label' => 'Aprobados'],
            ['key' => 'rechazados', 'label' => 'Rechazados'],
            ['key' => 'inactivos',  'label' => 'Inactivos'],
        ] as $tab)
        <a href="{{ request()->fullUrlWithQuery(['filtro' => $tab['key']]) }}"
           class="px-5 py-2 rounded-[1.5rem] text-[11px] font-black uppercase tracking-widest transition-all
                  {{ $filtro === $tab['key']
                       ? 'bg-slate-900 text-white shadow-lg'
                       : 'bg-white ring-1 ring-slate-200 text-slate-500 hover:ring-orange-400 hover:text-slate-800' }}">
            {{ $tab['label'] }}
        </a>
        @endforeach
    </div>

    {{-- ── ALERT: Pending projects need attention ───────────────────────── --}}
    @if($counts['pendientes'] > 0 && $filtro === 'todos')
    <div class="mx-4 bg-amber-50 border border-amber-200 rounded-[2rem] p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 rounded-2xl bg-amber-400 flex items-center justify-center shrink-0 shadow-lg">
            <i class="fas fa-exclamation-triangle text-white text-lg"></i>
        </div>
        <div>
            <p class="font-black text-slate-900 uppercase tracking-wide text-sm">
                {{ $counts['pendientes'] }} {{ $counts['pendientes'] === 1 ? 'proyecto pendiente' : 'proyectos pendientes' }} de revisión
            </p>
            <p class="text-slate-500 text-xs font-semibold mt-0.5">
                Revisa y aprueba o rechaza los proyectos antes de que sean visibles para los aprendices.
            </p>
        </div>
        <a href="{{ request()->fullUrlWithQuery(['filtro' => 'pendientes']) }}"
           class="ml-auto px-4 py-2 bg-amber-400 text-slate-900 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-amber-500 transition-all shrink-0">
            Ver pendientes
        </a>
    </div>
    @endif

    {{-- ── Projects Grid ───────────────────────────────────────────────── --}}
    @php
        $proyectosFiltrados = match($filtro) {
            'pendientes' => $proyectos->where('pro_estado', 'Pendiente'),
            'aprobados'  => $proyectos->where('pro_estado', 'Aprobado'),
            'rechazados' => $proyectos->where('pro_estado', 'Rechazado'),
            'inactivos'  => $proyectos->where('pro_estado', 'Inactivo'),
            default      => $proyectos,
        };
    @endphp

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 font-bold px-4">
        @forelse($proyectosFiltrados as $p)
            <x-card class="group border-none ring-1 ring-slate-100 shadow-xl hover:shadow-2xl
                           {{ $p->pro_estado === 'Pendiente' ? 'ring-amber-300/60 hover:ring-amber-400/80' : 'hover:ring-[#FF6B00]/20' }}
                           transition-all overflow-hidden flex flex-col md:flex-row bg-white">

                {{-- Project Visual Side --}}
                <div class="w-full md:w-56 bg-slate-900 relative flex-shrink-0 flex flex-col items-center justify-center p-8 text-center space-y-4">
                    <div class="absolute inset-0 bg-gradient-to-br
                         {{ $p->pro_estado === 'Pendiente' ? 'from-amber-500/20' : ($p->pro_estado === 'Rechazado' ? 'from-red-500/20' : 'from-[#FF6B00]/20') }}
                         to-transparent opacity-50"></div>
                    <div class="w-20 h-20 rounded-[2rem] bg-white/10 backdrop-blur-md flex items-center justify-center text-4xl italic text-orange-400 shadow-2xl relative z-10 transform group-hover:rotate-12 transition-transform">
                        <i class="fas fa-cube"></i>
                    </div>

                    @switch($p->pro_estado)
                        @case('Pendiente')
                            <x-badge class="bg-amber-400 text-slate-900 border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg relative z-10 italic">PENDIENTE</x-badge>
                            @break
                        @case('Aprobado')
                            <x-badge class="bg-[#FF6B00] text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-[#FF6B00]/20 relative z-10 italic">APROBADO</x-badge>
                            @break
                        @case('Activo')
                            <x-badge class="bg-[#FF6B00] text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-[#FF6B00]/20 relative z-10 italic">OPERATIVO</x-badge>
                            @break
                        @case('Rechazado')
                            <x-badge class="bg-red-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-red-500/20 relative z-10 italic">RECHAZADO</x-badge>
                            @break
                        @default
                            <x-badge class="bg-slate-700 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-slate-500/20 relative z-10 italic">INACTIVO</x-badge>
                    @endswitch
                </div>

                {{-- Project Content --}}
                <div class="flex-1 p-8 space-y-6 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">
                            <i class="fas fa-building text-[#FF6B00]"></i>
                            {{ $p->empresa->emp_nombre }}
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight uppercase italic leading-tight group-hover:text-[#E65100] transition-colors">
                            {{ Str::limit($p->pro_titulo_proyecto, 60) }}
                        </h3>
                        <p class="text-xs text-slate-500 font-semibold">
                            <i class="fas fa-tag mr-1 text-orange-400"></i>{{ $p->pro_categoria }}
                            <span class="mx-2">·</span>
                            <i class="fas fa-calendar mr-1 text-slate-400"></i>{{ \Carbon\Carbon::parse($p->pro_fecha_publi)->format('d/m/Y') }}
                        </p>
                    </div>

                    {{-- ── APROBACIÓN RÁPIDA (solo proyectos Pendientes) ── --}}
                    @if($p->pro_estado === 'Pendiente')
                    <div class="p-5 bg-amber-50 rounded-[2rem] border border-amber-200 space-y-4">
                        <p class="text-[10px] font-black uppercase tracking-widest text-amber-700 flex items-center gap-2">
                            <i class="fas fa-clock"></i> PENDIENTE DE REVISIÓN — ¿Aprobar este proyecto?
                        </p>
                        <div class="flex gap-3">
                            {{-- APROBAR --}}
                            <form action="{{ route('admin.proyectos.aprobar', $p->pro_id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3.5 rounded-[1.5rem] text-[11px] font-black uppercase tracking-widest
                                           bg-[#FF6B00] text-white hover:bg-[#E65100] transition-all shadow-md shadow-[#FF6B00]/20 active:scale-95">
                                    <i class="fas fa-check mr-2"></i>APROBAR
                                </button>
                            </form>
                            {{-- RECHAZAR --}}
                            <form action="{{ route('admin.proyectos.rechazar', $p->pro_id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3.5 rounded-[1.5rem] text-[11px] font-black uppercase tracking-widest
                                           bg-red-500 text-white hover:bg-red-600 transition-all shadow-md shadow-red-500/20 active:scale-95">
                                    <i class="fas fa-times mr-2"></i>RECHAZAR
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- Instructor Assignment --}}
                    <div class="p-6 bg-slate-50 rounded-[2.5rem] border border-slate-100 space-y-5 shadow-inner">
                        <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest italic text-slate-500">
                            <span>AUTORIDAD ASIGNADA</span>
                            @if($p->ins_usr_documento)
                                <span class="text-[#E65100] flex items-center gap-1"><i class="fas fa-check-circle"></i> VINCULADO</span>
                            @else
                                <span class="text-amber-500 flex items-center gap-1"><i class="fas fa-exclamation-triangle"></i> VACANTE</span>
                            @endif
                        </div>

                        <form action="{{ route('admin.proyectos.asignar', $p->pro_id) }}" method="POST" class="flex gap-2">
                            @csrf
                            <select name="ins_usr_documento" class="flex-1 bg-white border-none ring-1 ring-slate-200 rounded-2xl px-5 py-3 text-[11px] font-bold text-slate-700 focus:ring-2 focus:ring-[#FF6B00] transition-all outline-none shadow-sm" required>
                                <option value="" disabled selected>Elegir Instructor...</option>
                                @foreach($instructores as $ins)
                                    <option value="{{ $ins->usr_documento }}" {{ $p->ins_usr_documento == $ins->usr_documento ? 'selected' : '' }}>
                                        {{ $ins->ins_nombre }} {{ $ins->ins_apellido }}
                                    </option>
                                @endforeach
                            </select>
                            <x-button type="submit" variant="primary" shadow="orange" class="p-3.5 rounded-2xl group/btn transition-all active:scale-95">
                                <i class="fas fa-id-badge group-hover/btn:scale-110 transition-transform italic text-lg"></i>
                            </x-button>
                        </form>
                    </div>

                    {{-- State Actions (non-pending) --}}
                    <div class="flex gap-3">
                        @if($p->pro_estado === 'Rechazado' || $p->pro_estado === 'Inactivo')
                            <form action="{{ route('admin.proyectos.aprobar', $p->pro_id) }}" method="POST" class="flex-1 group/act">
                                @csrf
                                <x-button type="submit" variant="secondary" class="w-full py-3.5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest hover:bg-[#FF6B00] hover:text-white transition-all shadow-md group-hover/act:scale-[1.02] active:scale-95 italic">
                                    APROBAR
                                </x-button>
                            </form>
                        @endif

                        @if($p->pro_estado === 'Aprobado')
                            <form action="{{ route('admin.proyectos.rechazar', $p->pro_id) }}" method="POST" class="flex-1 group/act">
                                @csrf
                                <x-button type="submit" variant="secondary" class="w-full py-3.5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all shadow-sm group-hover/act:scale-[1.02] active:scale-95 italic">
                                    RECHAZAR
                                </x-button>
                            </form>
                        @endif

                        @if($p->pro_estado !== 'Inactivo')
                            <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST" class="flex-1 group/act">
                                @csrf
                                <input type="hidden" name="estado" value="Inactivo">
                                <x-button type="submit" variant="secondary" class="w-full py-3.5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all shadow-sm group-hover/act:scale-[1.02] active:scale-95 italic text-slate-400">
                                    INACTIVAR
                                </x-button>
                            </form>
                        @endif
                    </div>
                </div>
            </x-card>
        @empty
            <div class="xl:col-span-2 py-32 bg-white rounded-[4rem] border-2 border-dashed border-slate-100 text-center space-y-10 shadow-inner px-4">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-slate-200 rounded-full blur-3xl animate-pulse"></div>
                    <div class="w-44 h-44 rounded-[3.5rem] bg-slate-900 flex items-center justify-center mx-auto text-white text-7xl italic relative shadow-2xl transform rotate-12">
                        <i class="fas fa-ghost opacity-20"></i>
                    </div>
                </div>
                <div class="space-y-4 max-w-lg mx-auto italic text-slate-400 font-bold">
                    <h4 class="text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Sin Resultados</h4>
                    <p class="text-slate-400 font-bold text-xl italic leading-relaxed">
                        No hay proyectos en esta categoría.
                    </p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
