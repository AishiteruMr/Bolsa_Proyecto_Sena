@extends('layouts.dashboard')

@section('title', 'Gestión de Usuarios')

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
<div class="max-w-7xl mx-auto space-y-12 pb-16 font-bold" x-data="{ activeTab: 'aprendices' }">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 px-4">
        <div class="space-y-4">
            <h2 class="text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                Gestión <span class="text-emerald-500 underline decoration-emerald-500/20 decoration-8 underline-offset-8">Usuarios</span>
            </h2>
            <p class="text-slate-400 font-bold text-sm uppercase tracking-widest flex items-center gap-4 italic opacity-70">
                <span class="w-16 h-px bg-slate-200"></span>
                Administración de la fuerza de talento
            </p>
        </div>

        <!-- Premium Tabs -->
        <div class="flex p-2 bg-slate-100 rounded-[2rem] shadow-inner gap-2">
            <button @click="activeTab = 'aprendices'" 
                    :class="activeTab === 'aprendices' ? 'bg-white text-emerald-600 shadow-xl scale-105' : 'text-slate-400 hover:text-slate-600'"
                    class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 italic flex items-center gap-3">
                <i class="fas fa-user-graduate"></i>
                Aprendices ({{ $aprendices->count() }})
            </button>
            <button @click="activeTab = 'instructores'" 
                    :class="activeTab === 'instructores' ? 'bg-white text-emerald-600 shadow-xl scale-105' : 'text-slate-400 hover:text-slate-600'"
                    class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 italic flex items-center gap-3">
                <i class="fas fa-chalkboard-teacher"></i>
                Instructores ({{ $instructores->count() }})
            </button>
        </div>
    </div>

    <!-- Tables Logic -->
    <div class="px-4">
        <!-- Aprendices Table -->
        <div x-show="activeTab === 'aprendices'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
            <x-card class="border-none shadow-2xl overflow-hidden bg-white" shadow="none">
                <div class="overflow-x-auto">
                    <table class="w-full text-left font-bold">
                        <thead>
                            <tr class="bg-slate-900 text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] italic">
                                <th class="px-10 py-6 italic">Perfil</th>
                                <th class="px-10 py-6 italic">Programa Formativo</th>
                                <th class="px-10 py-6 italic text-center">Estado</th>
                                <th class="px-10 py-6 italic text-right">Comandos</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 italic text-slate-400 font-bold italic opacity-80">
                            @forelse($aprendices as $a)
                                <tr class="group hover:bg-slate-50/50 transition-all duration-300 italic">
                                    <td class="px-10 py-8 italic font-bold">
                                        <div class="flex items-center gap-6 italic font-bold">
                                            <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center italic text-xl shadow-xl group-hover:scale-110 group-hover:rotate-6 transition-transform italic">
                                                {{ strtoupper(substr($a->apr_nombre, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-lg font-black text-slate-900 uppercase italic leading-none">{{ $a->apr_nombre }} {{ $a->apr_apellido }}</p>
                                                <p class="text-[9px] text-slate-400 mt-2 uppercase italic tracking-widest font-black italic opacity-60 flex items-center gap-2">
                                                    <i class="fas fa-id-card text-emerald-500"></i>
                                                    ID: {{ $a->usr_documento }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 italic font-bold">
                                        <div class="max-w-[250px] italic">
                                            <p class="text-xs font-black text-slate-600 uppercase italic leading-relaxed">{{ $a->apr_programa }}</p>
                                            <p class="text-[10px] text-slate-400 mt-1 lowercase italic underline decoration-slate-200 decoration-dotted">{{ $a->usr_correo }}</p>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 italic text-center font-bold">
                                        @if($a->apr_estado == 1)
                                            <x-badge class="bg-emerald-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black shadow-lg shadow-emerald-500/20 italic">OPERATIVO</x-badge>
                                        @else
                                            <x-badge class="bg-red-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black shadow-lg shadow-red-500/20 italic">DORMIDO</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-10 py-8 italic text-right font-bold">
                                        <form action="{{ route('admin.usuarios.estado', $a->apr_id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="tipo" value="aprendiz">
                                            <input type="hidden" name="estado" value="{{ $a->apr_estado == 1 ? 0 : 1 }}">
                                            <x-button type="submit" variant="{{ $a->apr_estado == 1 ? 'secondary' : 'primary' }}" 
                                                      class="px-6 py-2.5 rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-lg transition-all active:scale-90 italic">
                                                {{ $a->apr_estado == 1 ? 'RESTRINGIR' : 'LIBERAR' }}
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-32 italic text-center text-slate-300 font-black uppercase tracking-widest text-lg opacity-40 italic">
                                        Cero Aprendices Desplegados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- Instructores Table -->
        <div x-show="activeTab === 'instructores'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
            <x-card class="border-none shadow-2xl overflow-hidden bg-white" shadow="none">
                <div class="overflow-x-auto">
                    <table class="w-full text-left font-bold">
                        <thead>
                            <tr class="bg-slate-900 text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] italic">
                                <th class="px-10 py-6 italic">Arquitecto</th>
                                <th class="px-10 py-6 italic">Línea Técnica</th>
                                <th class="px-10 py-6 italic text-center">Estado</th>
                                <th class="px-10 py-6 italic text-right">Comandos</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 italic text-slate-400 font-bold italic opacity-80">
                            @forelse($instructores as $i)
                                <tr class="group hover:bg-slate-50/50 transition-all duration-300 italic">
                                    <td class="px-10 py-8 italic font-bold">
                                        <div class="flex items-center gap-6 italic font-bold">
                                            <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center italic text-xl shadow-xl group-hover:scale-110 group-hover:-rotate-6 transition-transform italic">
                                                {{ strtoupper(substr($i->ins_nombre, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-lg font-black text-slate-900 uppercase italic leading-none">{{ $i->ins_nombre }} {{ $i->ins_apellido }}</p>
                                                <p class="text-[9px] text-slate-400 mt-2 uppercase italic tracking-widest font-black italic opacity-60 flex items-center gap-2">
                                                    <i class="fas fa-microchip text-emerald-500"></i>
                                                    DOC: {{ $i->usr_documento }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 italic font-bold">
                                        <div class="max-w-[250px] italic">
                                            <p class="text-xs font-black text-slate-600 uppercase italic leading-relaxed">{{ $i->ins_especialidad }}</p>
                                            <p class="text-[10px] text-slate-400 mt-1 lowercase italic underline decoration-slate-200 decoration-dotted">{{ $i->usr_correo }}</p>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 italic text-center font-bold">
                                        @if($i->ins_estado == 1)
                                            <x-badge class="bg-emerald-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black shadow-lg shadow-emerald-500/20 italic">AUTORIZADO</x-badge>
                                        @else
                                            <x-badge class="bg-red-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black shadow-lg shadow-red-500/20 italic">BLOQUEADO</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-10 py-8 italic text-right font-bold">
                                        <form action="{{ route('admin.usuarios.estado', $i->usr_id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="tipo" value="instructor">
                                            <input type="hidden" name="estado" value="{{ $i->ins_estado == 1 ? 0 : 1 }}">
                                            <x-button type="submit" variant="{{ $i->ins_estado == 1 ? 'secondary' : 'primary' }}" 
                                                      class="px-6 py-2.5 rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-lg transition-all active:scale-90 italic">
                                                {{ $i->ins_estado == 1 ? 'RESTRINGIR' : 'LIBERAR' }}
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-32 italic text-center text-slate-300 font-black uppercase tracking-widest text-lg opacity-40 italic">
                                        Arquitectos No Encontrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
