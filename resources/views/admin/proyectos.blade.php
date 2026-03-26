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
        <i class="fas fa-project-diagram group-hover:text-emerald-500 transition-colors italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Banco de Proyectos</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-16">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 px-4">
        <div class="space-y-4">
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                Gestión <span class="text-emerald-500 underline decoration-emerald-500/20 decoration-8 underline-offset-8">Global</span>
            </h2>
            <p class="text-slate-400 font-bold text-sm uppercase tracking-widest flex items-center gap-3">
                <span class="w-12 h-px bg-slate-200"></span>
                Administración y auditoría de proyectos
            </p>
        </div>
    </div>
[REPLACE_THROUGH_E    <!-- Projects Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 font-bold px-4">
        @forelse($proyectos as $p)
            <x-card class="group border-none ring-1 ring-slate-100 shadow-xl hover:shadow-2xl hover:ring-emerald-500/20 transition-all overflow-hidden flex flex-col md:flex-row bg-white">
                <!-- Project Visual -->
                <div class="w-full md:w-56 bg-slate-900 relative flex-shrink-0 flex flex-col items-center justify-center p-8 text-center space-y-4">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-transparent opacity-50"></div>
                    <div class="w-20 h-20 rounded-[2rem] bg-white/10 backdrop-blur-md flex items-center justify-center text-4xl italic text-emerald-400 shadow-2xl relative z-10 transform group-hover:rotate-12 transition-transform">
                        <i class="fas fa-cube"></i>
                    </div>
                    @switch($p->pro_estado)
                        @case('Activo')
                            <x-badge class="bg-emerald-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-emerald-500/20 relative z-10 italic">OPERATIVO</x-badge>
                            @break
                        @case('Aprobado')
                            <x-badge class="bg-blue-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-blue-500/20 relative z-10 italic">VALIDADO</x-badge>
                            @break
                        @case('Rechazado')
                            <x-badge class="bg-red-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-red-500/20 relative z-10 italic">DENEGADO</x-badge>
                            @break
                        @default
                            <x-badge class="bg-slate-700 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-slate-500/20 relative z-10 italic">DORMIDO</x-badge>
                    @endswitch
                </div>

                <!-- Project Content -->
                <div class="flex-1 p-8 space-y-6 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">
                            <i class="fas fa-building text-emerald-500"></i>
                            {{ $p->empresa->emp_nombre }}
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight uppercase italic leading-tight group-hover:text-emerald-600 transition-colors">
                            {{ Str::limit($p->pro_titulo_proyecto, 60) }}
                        </h3>
                    </div>

                    <!-- Instructor Assignment Logic -->
                    <div class="p-6 bg-slate-50 rounded-[2.5rem] border border-slate-100 space-y-5 shadow-inner">
                        <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest italic text-slate-500">
                            <span>AUTORIDAD ASIGNADA</span>
                            @if($p->ins_usr_documento)
                                <span class="text-emerald-600 flex items-center gap-1"><i class="fas fa-check-circle"></i> VINCULADO</span>
                            @else
                                <span class="text-amber-500 flex items-center gap-1"><i class="fas fa-exclamation-triangle"></i> VACANTE</span>
                            @endif
                        </div>

                        <form action="{{ route('admin.proyectos.asignar', $p->pro_id) }}" method="POST" class="flex gap-2">
                            @csrf
                            <select name="ins_usr_documento" class="flex-1 bg-white border-none ring-1 ring-slate-200 rounded-2xl px-5 py-3 text-[11px] font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500 transition-all outline-none shadow-sm" required>
                                <option value="" disabled selected>Elegir Instructor...</option>
                                @foreach($instructores as $ins)
                                    <option value="{{ $ins->usr_documento }}" {{ $p->ins_usr_documento == $ins->usr_documento ? 'selected' : '' }}>
                                        {{ $ins->ins_nombre }} {{ $ins->ins_apellido }}
                                    </option>
                                @endforeach
                            </select>
                            <x-button type="submit" variant="primary" shadow="emerald" class="p-3.5 rounded-2xl group/btn transition-all active:scale-95">
                                <i class="fas fa-id-badge group-hover/btn:scale-110 transition-transform italic text-lg"></i>
                            </x-button>
                        </form>
                    </div>

                    <!-- Project Actions -->
                    <div class="flex gap-3">
                        @if($p->pro_estado != 'Activo')
                            <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST" class="flex-1 group/act">
                                @csrf
                                <input type="hidden" name="estado" value="Activo">
                                <x-button type="submit" variant="secondary" class="w-full py-3.5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all shadow-md group-hover/act:scale-[1.02] active:scale-95 italic">
                                    ACTIVAR
                                </x-button>
                            </form>
                        @endif

                        @if($p->pro_estado != 'Inactivo')
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
                    <h4 class="text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Cero Proyectos</h4>
                    <p class="text-slate-400 font-bold text-xl italic leading-relaxed">No hay registros de proyectos en el sistema. Las empresas aún no han iniciado despliegues.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection