@extends('layouts.dashboard')

@section('title', 'Centro de Control Maestro')

@section('sidebar-nav')
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic text-slate-400">CONTROL CENTRAL</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item group {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line group-hover:scale-110 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400 font-bold uppercase transition-colors tracking-widest">Panel de Control</span>
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item group {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users-cog group-hover:rotate-12 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400 font-bold uppercase transition-colors tracking-widest">Usuarios Sistema</span>
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item group {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building group-hover:-translate-y-1 transition-transform italic"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400 font-bold uppercase transition-colors tracking-widest">Directorio Empresas</span>
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item group {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram group-hover:text-emerald-500 transition-colors italic text-emerald-500"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400 font-bold uppercase transition-colors tracking-widest">Banco de Proyectos</span>
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-16 font-bold">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 px-4">
        <div class="space-y-4">
            <div class="flex items-center gap-4 animate-in fade-in slide-in-from-left duration-700">
                <span class="bg-emerald-500 text-white px-4 py-1.5 rounded-2xl text-[10px] font-black tracking-[0.2em] uppercase italic shadow-lg shadow-emerald-500/20">Admin Hub</span>
                <span class="text-slate-400 text-xs font-black uppercase tracking-widest italic opacity-60">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h2 class="text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                Control <span class="text-emerald-500 underline decoration-emerald-500/10 decoration-8 underline-offset-8 transition-all hover:decoration-emerald-500/30 font-black">Maestro</span>
            </h2>
            <p class="text-slate-400 font-bold text-sm uppercase tracking-[0.25em] flex items-center gap-4 italic">
                <span class="w-16 h-px bg-slate-200"></span>
                Supervisión global del ecosistema
            </p>
        </div>
    </div>

    <!-- Bento Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
        <!-- Projects Stat -->
        <x-card class="group bg-slate-900 border-none shadow-2xl p-8 relative overflow-hidden transition-all hover:-translate-y-2 hover:shadow-emerald-500/10" shadow="none">
            <div class="absolute -right-8 -bottom-8 text-9xl text-white/5 transform -rotate-12 group-hover:rotate-0 transition-transform duration-700">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="relative z-10 space-y-6">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 flex items-center justify-center text-emerald-400 text-2xl italic shadow-inner">
                    <i class="fas fa-cubes"></i>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-white italic tracking-tighter">{{ $stats['proyectos'] }}</h3>
                    <p class="text-emerald-500/60 text-[10px] font-black uppercase tracking-widest italic mt-1">PROYECTOS TOTALES</p>
                </div>
                <div class="pt-4 border-t border-white/5">
                    <span class="text-white/40 text-[9px] font-black uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        {{ $stats['pendientes'] }} PENDIENTES
                    </span>
                </div>
            </div>
        </x-card>

        <!-- Users Stat -->
        <x-card class="group border-none shadow-xl p-8 relative overflow-hidden transition-all hover:-translate-y-2" shadow="none">
            <div class="absolute -right-8 -bottom-8 text-9xl text-slate-100 transform -rotate-12 group-hover:rotate-0 transition-transform duration-700 opacity-50">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="relative z-10 space-y-6">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 text-2xl italic shadow-sm">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-slate-900 italic tracking-tighter">{{ $stats['usuarios'] }}</h3>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest italic mt-1">USUARIOS REGISTRADOS</p>
                </div>
                <div class="pt-4 border-t border-slate-50 italic text-[10px] text-slate-400 font-bold">
                    CAPACIDAD DE RED GLOBAL
                </div>
            </div>
        </x-card>

        <!-- Companies Stat -->
        <x-card class="group border-none shadow-xl p-8 relative overflow-hidden transition-all hover:-translate-y-2" shadow="none">
            <div class="absolute -right-8 -bottom-8 text-9xl text-slate-100 transform -rotate-12 group-hover:rotate-0 transition-transform duration-700 opacity-50">
                <i class="fas fa-building"></i>
            </div>
            <div class="relative z-10 space-y-6">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 text-2xl italic shadow-sm">
                    <i class="fas fa-city"></i>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-slate-900 italic tracking-tighter">{{ $stats['empresas'] }}</h3>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest italic mt-1">EMPRESAS VINCULADAS</p>
                </div>
                <div class="pt-4 border-t border-slate-50 italic text-[10px] text-slate-400 font-bold">
                    ALIADOS ESTRATÉGICOS
                </div>
            </div>
        </x-card>

        <!-- Aprendices Stat -->
        <x-card class="group border-none shadow-xl p-8 relative overflow-hidden transition-all hover:-translate-y-2" shadow="none">
            <div class="absolute -right-8 -bottom-8 text-9xl text-slate-100 transform -rotate-12 group-hover:rotate-0 transition-transform duration-700 opacity-50">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="relative z-10 space-y-6">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-2xl italic shadow-sm">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-slate-900 italic tracking-tighter">{{ $stats['aprendices'] }}</h3>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest italic mt-1">APRENDICES ACTIVOS</p>
                </div>
                <div class="pt-4 border-t border-slate-50 italic text-[10px] text-slate-400 font-bold text-slate-400">
                    TALENTO EN ENTRENAMIENTO
                </div>
            </div>
        </x-card>
    </div>

    <!-- Main Grid: Activity & New Users -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4">
        
        <!-- Recent Projects Activity -->
        <div class="lg:col-span-2 space-y-6 italic">
            <div class="flex items-center justify-between mb-4 italic text-slate-400 font-bold">
                <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase italic flex items-center gap-3">
                    <span class="w-2 h-8 bg-emerald-500 rounded-full italic"></span>
                    Actividad de Proyectos
                </h3>
                <a href="{{ route('admin.proyectos') }}" class="text-[10px] font-black text-emerald-600 uppercase tracking-widest hover:translate-x-2 transition-transform italic underline decoration-emerald-500/20 underline-offset-4">Ver Todos <i class="fas fa-external-link-alt ml-1"></i></a>
            </div>

            <x-card class="border-none shadow-xl overflow-hidden bg-white" shadow="none">
                <div class="overflow-x-auto">
                    <table class="w-full text-left font-bold">
                        <thead>
                            <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">
                                <th class="px-8 py-5 italic">Identificador</th>
                                <th class="px-8 py-5 italic">Empresa Nodo</th>
                                <th class="px-8 py-5 italic">Estado Sistema</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 italic text-slate-400 font-bold italic">
                            @foreach($proyectosRecientes as $p)
                                <tr class="group hover:bg-slate-50 transition-colors duration-300 italic">
                                    <td class="px-8 py-6 italic">
                                        <div class="flex items-center gap-4 italic font-bold">
                                            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center italic text-xs shadow-lg group-hover:scale-110 transition-transform italic">
                                                <i class="fas fa-project-diagram"></i>
                                            </div>
                                            <div class="italic">
                                                <p class="text-sm font-black text-slate-900 uppercase italic leading-none truncate max-w-[200px]">{{ $p->pro_titulo_proyecto }}</p>
                                                <p class="text-[9px] text-slate-400 mt-1 uppercase italic tracking-widest font-bold">PRO-SYNC-{{ $p->pro_id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 italic">
                                        <span class="text-xs font-black text-slate-600 uppercase italic opacity-80 italic italic font-bold">{{ $p->emp_nombre }}</span>
                                    </td>
                                    <td class="px-8 py-6 italic font-bold">
                                        @if($p->pro_estado == 'Activo')
                                            <x-badge class="bg-emerald-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black shadow-lg shadow-emerald-500/10 italic">OPERATIVO</x-badge>
                                        @else
                                            <x-badge class="bg-slate-200 text-slate-600 border-none py-1.5 px-4 rounded-xl text-[9px] font-black italic">PENDIENTE</x-badge>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- New Users Panel -->
        <div class="space-y-6">
            <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase italic flex items-center gap-3">
                <span class="w-2 h-8 bg-blue-500 rounded-full italic"></span>
                Nuevos Accesos
            </h3>
            
            <x-card class="border-none shadow-xl p-8 bg-white space-y-8" shadow="none">
                <div class="space-y-6">
                    @foreach($usuariosRecientes as $u)
                        <div class="flex items-center justify-between group cursor-default">
                            <div class="flex items-center gap-4 italic font-bold">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-lg font-black group-hover:bg-slate-900 group-hover:text-white transition-all italic shadow-inner">
                                    {{ strtoupper(substr($u->usr_correo, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-900 uppercase italic leading-none truncate max-w-[120px]">{{ explode('@', $u->usr_correo)[0] }}</p>
                                    <p class="text-[9px] text-slate-400 mt-1 uppercase italic tracking-widest font-black italic opacity-60">{{ $u->nombre_rol }}</p>
                                </div>
                            </div>
                            <span class="text-[8px] font-black text-slate-300 uppercase tracking-tighter italic">{{ \Carbon\Carbon::parse($u->usr_fecha_creacion)->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-8 border-t border-slate-50 mt-4">
                    <x-button href="{{ route('admin.usuarios') }}" variant="secondary" class="w-full py-4 rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-slate-200/50 hover:bg-slate-900 hover:text-white transition-all italic text-slate-400">
                        AUDITAR USUARIOS
                    </x-button>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection

