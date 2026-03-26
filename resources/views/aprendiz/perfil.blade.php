@extends('layouts.dashboard')

@section('title', 'Mi Perfil - Inspírate SENA')
@section('page-title', 'Mi Perfil')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto space-y-10 pb-16">
    
    <!-- HEADER BENTO -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Welcome Card -->
        <x-card class="md:col-span-2 p-10 border-none ring-1 ring-slate-100 shadow-2xl relative overflow-hidden group">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-orange-50 rounded-full blur-3xl opacity-50 group-hover:bg-orange-100/50 transition-colors"></div>
            
            <div class="relative flex flex-col md:flex-row items-center gap-10">
                <div class="relative">
                    <div class="w-32 h-32 rounded-[2.5rem] bg-slate-900 flex items-center justify-center text-white text-5xl font-black italic shadow-2xl transform -rotate-6 hover:rotate-0 transition-transform duration-500 ring-8 ring-slate-50">
                        {{ strtoupper(substr($aprendiz->apr_nombre ?? 'A', 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#FF6B00] shadow-xl border-4 border-slate-50">
                        <i class="fas fa-certificate text-xs"></i>
                    </div>
                </div>

                <div class="flex-1 space-y-6 text-center md:text-left">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black text-[#E65100] uppercase tracking-[0.3em] italic">CENTRO DE FORMACIÓN ACADÉMICA</span>
                        <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">¡Hola, {{ $aprendiz->apr_nombre }}!</h2>
                    </div>
                    
                    <!-- Perfil Integrity -->
                    @php
                        $camposCompletos = 0;
                        if(!empty($aprendiz->apr_nombre)) $camposCompletos++;
                        if(!empty($aprendiz->apr_apellido)) $camposCompletos++;
                        if(!empty($aprendiz->apr_programa)) $camposCompletos++;
                        if(!empty($usuario->usr_correo)) $camposCompletos++;
                        $progresoPerfil = ($camposCompletos / 4) * 100;
                    @endphp
                    <div class="space-y-3 max-w-sm mx-auto md:mx-0">
                        <div class="flex items-center justify-between px-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">INTEGRIDAD DE IDENTIDAD</span>
                            <span class="text-[10px] font-black text-[#E65100] italic">{{ $progresoPerfil }}%</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden shadow-inner ring-1 ring-slate-50">
                            <div class="h-full bg-[#FF6B00] rounded-full transition-all duration-1000 ease-out shadow-[0_0_15px_rgba(16,185,129,0.5)]" style="width: {{ $progresoPerfil }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Training Program Card -->
        <x-card class="p-10 border-none ring-1 ring-slate-100 shadow-2xl relative overflow-hidden bg-slate-900 group">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#FF6B00]/10 rounded-full blur-3xl"></div>
            <div class="relative h-full flex flex-col justify-between space-y-8">
                <div class="space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#FF6B00]/20 text-orange-400 flex items-center justify-center text-xl italic shadow-inner">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">ESPECIALIDAD</h4>
                        <p class="text-xl font-black text-white leading-tight uppercase italic group-hover:text-orange-400 transition-colors">{{ $aprendiz->apr_programa }}</p>
                    </div>
                </div>
                <x-badge class="bg-[#FF6B00]/20 text-orange-400 border-none py-1.5 px-4 rounded-xl text-[10px] font-black uppercase tracking-widest w-fit">
                    ROL ACTIVO
                </x-badge>
            </div>
        </x-card>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Editable Info -->
        <x-card class="lg:col-span-2 p-10 md:p-12 border-none ring-1 ring-slate-100 shadow-2xl space-y-12">
            <div class="flex items-center justify-between border-b border-slate-50 pb-8">
                <h3 class="text-2xl font-black text-slate-900 tracking-tighter italic flex items-center gap-4 uppercase">
                    <span class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-sm shadow-inner italic">
                        <i class="fas fa-user-gear"></i>
                    </span>
                    Matriz de Identidad
                </h3>
            </div>

            <form action="{{ route('aprendiz.perfil.update') }}" method="POST" class="space-y-10">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1">Nombres</label>
                        <div class="relative group">
                            <i class="fas fa-id-card absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[#FF6B00] transition-colors italic"></i>
                            <input type="text" name="nombre" value="{{ old('nombre', $aprendiz->apr_nombre) }}" required 
                                   class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 pl-14 pr-6 text-sm font-black text-slate-900 focus:border-[#FF6B00] focus:bg-white transition-all outline-none shadow-inner">
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1">Apellidos</label>
                        <div class="relative group">
                            <i class="fas fa-id-card absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[#FF6B00] transition-colors italic"></i>
                            <input type="text" name="apellido" value="{{ old('apellido', $aprendiz->apr_apellido) }}" required 
                                   class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 pl-14 pr-6 text-sm font-black text-slate-900 focus:border-[#FF6B00] focus:bg-white transition-all outline-none shadow-inner">
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1">Programa de Formación</label>
                    <div class="relative group">
                        <i class="fas fa-award absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[#FF6B00] transition-colors italic"></i>
                        <input type="text" name="programa" value="{{ old('programa', $aprendiz->apr_programa) }}" required 
                               class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-4 pl-14 pr-6 text-sm font-black text-slate-900 focus:border-[#FF6B00] focus:bg-white transition-all outline-none shadow-inner">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1">Correo Institucional (Bloqueado)</label>
                    <div class="relative">
                        <i class="fas fa-at absolute left-5 top-1/2 -translate-y-1/2 text-slate-200 italic"></i>
                        <input type="email" value="{{ $usuario->usr_correo }}" disabled 
                               class="w-full bg-slate-100/50 border-2 border-slate-100 rounded-2xl py-4 pl-14 pr-6 text-sm font-black text-slate-400 italic cursor-not-allowed">
                        <i class="fas fa-lock absolute right-5 top-1/2 -translate-y-1/2 text-slate-200 text-xs italic"></i>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 space-y-8 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-slate-100 rounded-full -mr-16 -mt-16 opacity-50"></div>
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest italic flex items-center gap-3 relative">
                        <span class="w-8 h-8 rounded-xl bg-white text-slate-400 flex items-center justify-center text-[10px] shadow-sm italic">
                            <i class="fas fa-shield-halved"></i>
                        </span>
                        Protocolos de Acceso
                    </h4>
                    
                    <div class="space-y-3 relative">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic ml-1">Nueva Contraseña</label>
                        <div class="relative group">
                            <i class="fas fa-key absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[#FF6B00] transition-colors italic"></i>
                            <input type="password" name="password" placeholder="Mínimo 6 caracteres • Vacío para mantener" 
                                   class="w-full bg-white border-2 border-slate-100 rounded-2xl py-4 pl-14 pr-6 text-sm font-black text-slate-900 focus:border-[#FF6B00] transition-all outline-none shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <x-button type="submit" variant="primary" shadow="orange" class="py-5 px-12 rounded-3xl font-black text-xs uppercase tracking-[0.2em] flex items-center gap-4 hover:scale-105 active:scale-95 transition-all">
                        SINCRONIZAR DATOS <i class="fas fa-rotate italic text-lg"></i>
                    </x-button>
                </div>
            </form>
        </x-card>

        <!-- Sidebar Bento -->
        <div class="space-y-10 order-first lg:order-last">
            
            <!-- Quick Stats -->
            <x-card class="p-10 border-none ring-1 ring-slate-100 shadow-2xl space-y-8">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest italic flex items-center gap-3">
                    <i class="fas fa-wave-square text-[#FF6B00]"></i> VECTOR DE ACTIVIDAD
                </h4>
                
                <div class="grid gap-4">
                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-3xl border border-slate-100 group hover:border-[#FF6B00] transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white text-[#FF6B00] flex items-center justify-center text-lg italic shadow-sm group-hover:bg-[#FF6B00] group-hover:text-white transition-colors">
                                <i class="fas fa-satellite-dish"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest italic">POSTULACIONES</span>
                        </div>
                        <span class="text-2xl font-black text-slate-900 italic group-hover:text-[#E65100] transition-colors">{{ $aprendiz->postulaciones()->count() }}</span>
                    </div>

                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-3xl border border-slate-100 group hover:border-blue-500 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white text-blue-500 flex items-center justify-center text-lg italic shadow-sm group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest italic">MISIÓN OK</span>
                        </div>
                        <span class="text-2xl font-black text-slate-900 italic group-hover:text-blue-600 transition-colors">{{ $aprendiz->postulacionesAprobadas()->count() }}</span>
                    </div>

                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-3xl border border-slate-100 group hover:border-amber-500 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white text-amber-500 flex items-center justify-center text-lg italic shadow-sm group-hover:bg-amber-500 group-hover:text-white transition-colors">
                                <i class="fas fa-file-export"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest italic">EVIDENCIAS</span>
                        </div>
                        <span class="text-2xl font-black text-slate-900 italic group-hover:text-amber-600 transition-colors">{{ $aprendiz->evidencias()->count() }}</span>
                    </div>
                </div>
            </x-card>

            <!-- Help Card -->
            <x-card class="p-10 border-none ring-1 ring-slate-100 shadow-2xl bg-slate-900 relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#FF6B00]/10 rounded-full blur-3xl group-hover:bg-[#FF6B00]/20 transition-colors"></div>
                <div class="relative space-y-6">
                    <h4 class="text-lg font-black text-white italic tracking-tight uppercase">¿Dudas de Control?</h4>
                    <p class="text-[11px] font-bold text-slate-400 leading-relaxed italic">Si los datos de tu programa no coinciden con la realidad académica, contacta al centro de mando.</p>
                    <x-button variant="secondary" class="w-full py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest italic border-none bg-[#FF6B00] text-white hover:bg-[#E65100] transition-colors shadow-lg shadow-orange-900/20">
                        ABRIR TICKET DE SOPORTE
                    </x-button>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
@endsection
