@extends('layouts.dashboard')

@section('title', 'Perfil Profesional | ' . ($instructor->ins_nombre ?? 'Instructor'))

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
    
    <!-- HEADER BENTO -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 px-4 italic">
        <!-- Mentor Profile Card -->
        <div class="lg:col-span-2 relative overflow-hidden rounded-[4rem] bg-slate-900 p-12 md:p-16 shadow-2xl shadow-emerald-500/10 text-white italic group italic">
            <div class="absolute -right-20 -bottom-20 rotate-[-15deg] text-[300px] text-emerald-500/5 opacity-40 pointer-events-none group-hover:rotate-0 transition-all duration-1000 italic font-bold">
                <i class="fas fa-user-astronaut italic"></i>
            </div>

            <div class="relative z-10 flex flex-col md:flex-row items-center gap-12 md:gap-16 italic font-bold">
                <div class="relative italic">
                    <div class="w-40 h-40 md:w-56 md:h-56 rounded-[3.5rem] bg-emerald-500 flex items-center justify-center text-8xl font-black shadow-2xl shadow-emerald-500/40 border-8 border-white/10 italic group-hover:scale-110 transition-transform italic leading-none italic">
                        {{ strtoupper(substr($instructor->ins_nombre ?? 'I', 0, 1)) }}
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left space-y-8 italic font-bold">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 italic">
                        <x-badge class="bg-emerald-500 text-white border-none px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.3em] italic shadow-2xl shadow-emerald-500/20 italic">INSTRUCTOR LÍDER</x-badge>
                        <span class="text-white/40 text-[11px] uppercase font-black tracking-[0.4em] flex items-center gap-4 italic leading-none italic">
                            <i class="fas fa-at text-emerald-500 italic font-bold"></i> {{ $usuario->usr_correo }}
                        </span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-black tracking-tighter uppercase italic leading-[0.9] italic">{{ $instructor->ins_nombre }} <br> {{ $instructor->ins_apellido }}</h2>
                    <div class="inline-flex items-center gap-5 px-8 py-4 rounded-[2rem] bg-white/5 border-2 border-white/5 text-emerald-400 italic shadow-xl italic font-bold">
                        <i class="fas fa-microchip text-2xl italic font-bold"></i>
                        <span class="text-[11px] font-black uppercase tracking-[0.3em] italic leading-none italic">ESPECIALIDAD: {{ strtoupper($instructor->ins_especialidad) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status Card -->
        <x-card class="bg-white border-none shadow-2xl rounded-[4rem] p-12 flex flex-col justify-center space-y-12 group italic font-bold" shadow="none">
            <div class="space-y-6 italic">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] italic opacity-80 italic leading-none italic">ESTADO OPERATIVO</p>
                <div class="flex items-center gap-6 italic">
                    <div class="w-5 h-5 rounded-full bg-emerald-500 shadow-[0_0_25px_rgba(16,185,129,0.7)] animate-pulse italic"></div>
                    <span class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic leading-none italic">SISTEMA NOMINAL</span>
                </div>
            </div>
            <div class="pt-10 border-t-4 border-slate-50 italic font-bold">
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.4em] mb-6 italic leading-none italic">JERARQUÍA ESTRATÉGICA</p>
                <p class="text-xs font-black text-slate-400 leading-relaxed uppercase italic opacity-80 italic tracking-tight italic">GESTOR DE PROYECTOS TÉCNICOS & ORQUESTADOR DE TALENTO DE ALTO RENDIMIENTO SENA</p>
            </div>
        </x-card>
    </div>

    <!-- CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 px-4 italic font-bold">
        
        <!-- Main Management Form -->
        <div class="lg:col-span-2 italic font-bold">
            <x-card class="p-12 md:p-16 border-none shadow-2xl rounded-[4rem] bg-white relative overflow-hidden group italic font-bold border-4 border-transparent hover:border-emerald-500/5 transition-all italic" shadow="none">
                <div class="absolute top-0 right-0 w-80 h-80 bg-slate-50 rounded-bl-[12rem] -z-10 group-hover:scale-125 transition-transform duration-1000 italic rotate-6 italic"></div>
                
                <div class="flex items-center justify-between mb-16 italic border-b-4 border-slate-50 pb-10 italic font-bold">
                    <div class="flex items-center gap-6 italic">
                        <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-2xl italic rotate-6 italic">
                            <i class="fas fa-fingerprint text-2xl italic text-emerald-500 font-bold"></i>
                        </div>
                        <div class="italic">
                            <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic leading-none italic">Identidad de Mando</h3>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3 italic opacity-60 italic leading-none italic">CONFIGURACIÓN DE CREDENCIALES TÉCNICAS</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('instructor.perfil.update') }}" method="POST" class="space-y-12 italic font-bold">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 italic">
                        <div class="space-y-4 italic">
                            <label class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] block ml-6 italic opacity-80 italic leading-none italic">NOMBRES DE PILA</label>
                            <div class="relative group italic">
                                <i class="fas fa-signature absolute left-8 top-1/2 -translate-y-1/2 text-slate-200 group-focus-within:text-emerald-500 transition-all italic font-bold"></i>
                                <input type="text" name="nombre" value="{{ old('nombre', $instructor->ins_nombre) }}" required
                                    class="w-full pl-20 pr-10 py-7 rounded-[2.5rem] bg-slate-50 border-none focus:ring-8 focus:ring-emerald-500/10 focus:bg-white focus:outline-none font-black text-base text-slate-900 transition-all shadow-inner uppercase italic tracking-tight italic">
                            </div>
                        </div>
                        <div class="space-y-4 italic">
                            <label class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] block ml-6 italic opacity-80 italic leading-none italic">APELLIDOS REGISTRADOS</label>
                            <div class="relative group italic">
                                <i class="fas fa-signature absolute left-8 top-1/2 -translate-y-1/2 text-slate-200 group-focus-within:text-emerald-500 transition-all italic font-bold"></i>
                                <input type="text" name="apellido" value="{{ old('apellido', $instructor->ins_apellido) }}" required
                                    class="w-full pl-20 pr-10 py-7 rounded-[2.5rem] bg-slate-50 border-none focus:ring-8 focus:ring-emerald-500/10 focus:bg-white focus:outline-none font-black text-base text-slate-900 transition-all shadow-inner uppercase italic tracking-tight italic">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 italic">
                        <label class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] block ml-6 italic opacity-80 italic leading-none italic">DIMENSIÓN DE ESPECIALIDAD</label>
                        <div class="relative group italic">
                            <i class="fas fa-atom absolute left-8 top-1/2 -translate-y-1/2 text-slate-200 group-focus-within:text-emerald-500 transition-all italic font-bold animate-spin-slow italic"></i>
                            <input type="text" name="especialidad" value="{{ old('especialidad', $instructor->ins_especialidad) }}" required
                                class="w-full pl-20 pr-10 py-7 rounded-[2.5rem] bg-slate-50 border-none focus:ring-8 focus:ring-emerald-500/10 focus:bg-white focus:outline-none font-black text-base text-slate-900 transition-all shadow-inner uppercase italic tracking-tight italic">
                        </div>
                    </div>

                    <div class="p-12 rounded-[3.5rem] bg-slate-900 border-none space-y-12 group-hover:shadow-2xl group-hover:shadow-emerald-500/10 transition-all duration-700 italic font-bold border-4 border-white/5 italic">
                        <h4 class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.4em] flex items-center gap-5 italic font-bold leading-none italic">
                            <i class="fas fa-shield-halved text-2xl italic font-bold"></i> PROTOCOLOS DE SEGURIDAD CRÍTICA
                        </h4>
                        <div class="space-y-6 italic">
                            <label class="text-[9px] font-black text-white/30 uppercase tracking-[0.4em] block ml-6 italic leading-none italic">ACTUALIZAR LLAVE DE ACCESO</label>
                            <div class="relative group italic font-bold">
                                <i class="fas fa-key absolute left-8 top-1/2 -translate-y-1/2 text-white/10 group-focus-within:text-emerald-500 transition-all italic font-bold"></i>
                                <input type="password" name="password" placeholder="MINIMO 8 CARACTERES ALFANUMÉRICOS"
                                    class="w-full pl-20 pr-10 py-8 rounded-[2.5rem] bg-white/5 border-none focus:ring-8 focus:ring-emerald-500/20 focus:outline-none font-black text-base text-white transition-all shadow-inner uppercase italic placeholder:text-white/5 tracking-widest italic italic">
                            </div>
                            <div class="p-6 rounded-2xl bg-emerald-500/5 border border-emerald-500/10 italic">
                                <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.2em] italic leading-relaxed italic text-center italic">
                                    ÚNICAMENTE MODIFIQUE ESTE REGISTRO PARA SOBREESCRIBIR LA LLAVE MAESTRA ACTUAL DEL SISTEMA.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-10 italic font-bold">
                        <x-button variant="primary" shadow="emerald" class="w-full md:w-auto px-16 py-7 rounded-[2rem] text-[11px] font-black uppercase italic shadow-2xl hover:scale-105 transition-all active:scale-95 italic tracking-widest leading-none italic" type="submit">
                            <i class="fas fa-sync-alt mr-4 italic text-xl font-bold"></i> CONSOLIDAR IDENTIDAD
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Side Stats & Info -->
        <div class="space-y-12 italic font-bold">
            <x-card class="bg-slate-900 p-12 border-none shadow-2xl rounded-[4rem] text-white italic font-bold border-2 border-white/5 italic" shadow="none">
                <h4 class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.4em] mb-14 border-b-2 border-white/5 pb-8 italic text-center leading-none italic font-bold">MÉTRICAS DE IMPACTO</h4>
                
                <div class="space-y-10 italic">
                    <div class="flex items-center justify-between p-8 rounded-[2.5rem] bg-white/5 hover:bg-white/10 transition-all group italic font-bold border-2 border-transparent hover:border-emerald-500/10 italic">
                        <div class="flex items-center gap-6 italic">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-2xl shadow-emerald-500/30 group-hover:rotate-12 transition-transform italic border-4 border-white/10 italic">
                                <i class="fas fa-project-diagram italic font-bold"></i>
                            </div>
                            <div class="italic">
                                <span class="block text-[9px] font-black uppercase tracking-[0.3em] text-emerald-100/40 italic leading-none italic">MISIONES</span>
                                <span class="block text-4xl font-black italic tracking-tighter mt-2 italic leading-none italic">{{ str_pad($proyectosCount, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-8 rounded-[2.5rem] bg-white/5 hover:bg-white/10 transition-all group italic font-bold border-2 border-transparent hover:border-blue-500/10 italic">
                        <div class="flex items-center gap-6 italic">
                            <div class="w-16 h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-2xl shadow-blue-500/30 group-hover:-rotate-12 transition-transform italic border-4 border-white/10 italic">
                                <i class="fas fa-user-graduate italic font-bold"></i>
                            </div>
                            <div class="italic">
                                <span class="block text-[9px] font-black uppercase tracking-[0.3em] text-blue-100/40 italic leading-none italic">TALENTOS</span>
                                <span class="block text-4xl font-black italic tracking-tighter mt-2 italic leading-none italic">{{ str_pad($aprendicesCount, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-8 rounded-[2.5rem] bg-white/5 border-2 border-dashed border-amber-500/20 hover:bg-amber-500/5 transition-all group italic font-bold">
                        <div class="flex items-center gap-6 italic">
                            <div class="w-16 h-16 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-2xl shadow-amber-500/30 group-hover:scale-110 transition-transform italic border-4 border-white/10 italic">
                                <i class="fas fa-radiation animate-pulse italic font-bold"></i>
                            </div>
                            <div class="italic">
                                <span class="block text-[9px] font-black uppercase tracking-[0.3em] text-amber-100/40 italic leading-none italic">ALERTAS</span>
                                <span class="block text-4xl font-black italic tracking-tighter mt-2 italic leading-none italic">{{ str_pad($evidenciasPendientesCount, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Profile Progress -->
            @php
                $camposCompletos = 0;
                if(!empty($instructor->ins_nombre)) $camposCompletos++;
                if(!empty($instructor->ins_apellido)) $camposCompletos++;
                if(!empty($instructor->ins_especialidad)) $camposCompletos++;
                if(!empty($usuario->usr_correo)) $camposCompletos++;
                $progresoPerfil = ($camposCompletos / 4) * 100;
            @endphp
            <x-card class="p-12 bg-white border-none shadow-2xl rounded-[4rem] group italic font-bold italic" shadow="none">
                <div class="flex justify-between items-center mb-10 italic">
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-300 italic opacity-80 italic leading-none">OPTIMIZACIÓN DE PERFIL</span>
                    <span class="text-5xl font-black text-slate-900 italic tracking-tighter italic leading-none italic">{{ round($progresoPerfil) }}%</span>
                </div>
                <div class="h-5 w-full bg-slate-50 rounded-full overflow-hidden mb-10 shadow-inner p-1.5 italic border-2 border-slate-100">
                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000 shadow-[0_0_20px_rgba(16,185,129,0.5)] italic" style="width: {{ $progresoPerfil }}%"></div>
                </div>
                <div class="p-8 rounded-[2rem] bg-slate-50 border-4 border-white shadow-xl italic font-bold">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] leading-relaxed italic opacity-80 text-center italic">
                        {{ $progresoPerfil == 100 ? 'IDENTIDAD ESTRATÉGICA COMPLETAMENTE SINCRONIZADA CON LOS PROTOCOLO INSTITUCIONALES SENA.' : 'SISTEMA EN OPTIMIZACIÓN. SE REQUIERE CONSOLIDAR TODOS LOS CAMPOS PARA UNA VISIBILIDAD DE MANDO ÓPTIMA.' }}
                    </p>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
