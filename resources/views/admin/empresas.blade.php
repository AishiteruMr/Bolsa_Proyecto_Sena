@extends('layouts.dashboard')

@section('title', 'Directorio de Empresas')

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
<div class="max-w-7xl mx-auto space-y-12 pb-16 font-bold">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 px-4">
        <div class="space-y-4">
            <h2 class="text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                Empresas <span class="text-[#FF6B00] underline decoration-[#FF6B00]/20 decoration-8 underline-offset-8">Aliadas</span>
            </h2>
            <p class="text-slate-400 font-bold text-sm uppercase tracking-widest flex items-center gap-4 italic opacity-70">
                <span class="w-16 h-px bg-slate-200"></span>
                Gobernanza del ecosistema empresarial
            </p>
        </div>
    </div>

    <!-- Companies Table -->
    <div class="px-4 text-slate-400 font-bold italic">
        <x-card class="border-none shadow-2xl overflow-hidden bg-white" shadow="none">
            <div class="overflow-x-auto">
                <table class="w-full text-left font-bold">
                    <thead>
                        <tr class="bg-slate-900 text-[10px] font-black text-orange-400 uppercase tracking-[0.3em] italic">
                            <th class="px-10 py-6 italic">Entidad</th>
                            <th class="px-10 py-6 italic">Representación Legal</th>
                            <th class="px-10 py-6 italic">Contacto Digital</th>
                            <th class="px-10 py-6 italic text-center">Estado</th>
                            <th class="px-10 py-6 italic text-right">Comandos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 italic text-slate-400 font-bold italic opacity-80">
                        @forelse($empresas as $e)
                            <tr class="group hover:bg-slate-50/50 transition-all duration-300 italic font-bold">
                                <td class="px-10 py-8 italic font-bold">
                                    <div class="flex items-center gap-6 italic font-bold">
                                        <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 border border-slate-200 flex items-center justify-center italic text-xl shadow-inner group-hover:bg-slate-900 group-hover:text-orange-400 group-hover:scale-110 transition-all italic">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div>
                                            <p class="text-lg font-black text-slate-900 uppercase italic leading-none truncate max-w-[200px]">{{ $e->emp_nombre }}</p>
                                            <p class="text-[9px] text-slate-400 mt-2 uppercase italic tracking-widest font-black italic opacity-60">NIT: {{ $e->emp_nit }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8 italic font-bold">
                                    <span class="text-xs font-black text-slate-600 uppercase italic opacity-80 italic italic font-bold">{{ $e->emp_representante ?? 'N/A' }}</span>
                                </td>
                                <td class="px-10 py-8 italic font-bold">
                                    <span class="text-[10px] text-slate-400 lowercase italic underline decoration-slate-200 decoration-dotted hover:text-[#FF6B00] transition-colors uppercase font-bold italic">{{ $e->emp_correo }}</span>
                                </td>
                                <td class="px-10 py-8 italic text-center font-bold">
                                    @if($e->emp_estado == 1)
                                        <x-badge class="bg-[#FF6B00] text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black shadow-lg shadow-[#FF6B00]/20 italic">VINCULADA</x-badge>
                                    @else
                                        <x-badge class="bg-red-500 text-white border-none py-1.5 px-4 rounded-xl text-[9px] font-black shadow-lg shadow-red-500/20 italic">RESTRINGIDA</x-badge>
                                    @endif
                                </td>
                                <td class="px-10 py-8 italic text-right font-bold">
                                    <form action="{{ route('admin.empresas.estado', $e->emp_id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="estado" value="{{ $e->emp_estado == 1 ? 0 : 1 }}">
                                        <x-button type="submit" variant="{{ $e->emp_estado == 1 ? 'secondary' : 'primary' }}" 
                                                  class="px-6 py-2.5 rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-lg transition-all active:scale-90 italic">
                                            {{ $e->emp_estado == 1 ? 'RESTRINGIR' : 'LIBERAR' }}
                                        </x-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-32 italic text-center text-slate-300 font-black uppercase tracking-widest text-lg opacity-40 italic">
                                    Cero Entidades Registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>
@endsection
