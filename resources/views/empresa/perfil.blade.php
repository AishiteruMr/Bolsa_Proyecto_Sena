@extends('layouts.dashboard')

@section('title', 'Santuario de Identidad | ' . (session('nombre') ?? 'Empresa'))

@section('sidebar-nav')
<<<<<<< HEAD
    <span class="nav-label">Principal</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
=======
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-2 block italic text-slate-400">OPERACIÓN TÉCNICA</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item group {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line group-hover:scale-110 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Centro de Mando</span>
>>>>>>> master
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
    
    <!-- HEADER BENTO -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 px-4 italic">
        
        <!-- Company Info Card -->
        <x-card class="lg:col-span-2 overflow-hidden border-none shadow-2xl relative group rounded-[4rem] bg-slate-900 italic" shadow="none">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900/50 opacity-90 italic"></div>
            <div class="relative p-12 flex flex-col md:flex-row items-center gap-12 italic">
                <div class="relative shrink-0 italic">
                    <div class="w-40 h-40 md:w-48 md:h-48 rounded-[3.5rem] bg-white/5 backdrop-blur-3xl border-4 border-white/10 shadow-2xl flex items-center justify-center group-hover:rotate-6 transition-transform duration-700 italic">
                        <i class="fas fa-building text-7xl text-white drop-shadow-[0_20px_20px_rgba(0,0,0,0.4)] italic"></i>
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-emerald-500 rounded-[2rem] flex items-center justify-center border-8 border-slate-900 shadow-2xl text-white italic rotate-12">
                        <i class="fas fa-shield-check text-xl font-bold italic"></i>
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left space-y-6 italic">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 italic">
                        <x-badge class="bg-emerald-500 text-white border-none px-6 py-2 rounded-full font-black tracking-[0.2em] text-[10px] uppercase italic italic shadow-lg shadow-emerald-500/20 italic">
                            ALIADO ESTRATÉGICO SENA
                        </x-badge>
                        <span class="text-white/40 font-black text-[10px] uppercase tracking-[0.3em] italic">IDENTIT_NIT: {{ $empresa->emp_nit }}</span>
                    </div>
                    <h2 class="text-5xl md:text-6xl font-black text-white tracking-tighter uppercase italic leading-none truncate italic">
                        {{ $empresa->emp_nombre }}
                    </h2>
                    
                    <div class="flex flex-col md:flex-row gap-8 pt-4 text-emerald-400/80 font-black text-[11px] uppercase tracking-widest italic italic">
                        <div class="flex items-center gap-3 italic">
                            <i class="fas fa-user-tie text-emerald-500 italic"></i>
                            {{ $empresa->emp_representante }}
                        </div>
                        <div class="flex items-center gap-3 italic">
                            <i class="fas fa-envelope text-emerald-500 italic"></i>
                            {{ $empresa->emp_correo }}
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Quick Integration Progress -->
        <x-card class="flex flex-col justify-between p-10 border-none shadow-2xl bg-white relative overflow-hidden group rounded-[3.5rem] italic" shadow="none">
            <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-50 rounded-full -mr-24 -mt-24 transition-transform group-hover:scale-150 duration-1000 italic opacity-50"></div>
            
            <div class="relative space-y-8 italic">
                <div class="w-16 h-16 rounded-3xl bg-slate-900 text-white shadow-2xl flex items-center justify-center text-2xl rotate-12 group-hover:rotate-0 transition-transform italic">
                    <i class="fas fa-shield-bolt italic text-white font-bold flex items-center justify-center"></i>
                </div>
                <div class="italic">
                    <h4 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter italic">Integridad Corporativa</h4>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2 italic opacity-60 italic">NIVEL DE SINCRONIZACIÓN DE PERFIL</p>
                </div>

                <div class="space-y-6 italic">
                    <div class="flex justify-between items-end italic">
                        <span class="text-4xl font-black text-slate-900 italic">100<span class="text-lg text-emerald-500">%</span></span>
                        <x-badge class="bg-emerald-50 text-emerald-600 border-none px-4 py-1.5 rounded-full font-black text-[9px] uppercase tracking-widest italic italic italic">OPTIMIZADO</x-badge>
                    </div>
                    <div class="h-4 w-full bg-slate-100 rounded-full overflow-hidden p-1 shadow-inner italic">
                        <div class="h-full bg-emerald-500 rounded-full shadow-lg transition-all duration-1000 relative italic" style="width: 100%">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer italic"></div>
                        </div>
                    </div>
                </div>
            </div>

            <x-button :href="route('empresa.proyectos.crear')" variant="primary" shadow="emerald" class="w-full py-6 mt-8 rounded-[2rem] flex items-center justify-center gap-4 font-black uppercase tracking-[0.2em] text-[10px] active:scale-95 transition-all italic italic shadow-2xl">
                <i class="fas fa-plus-circle text-lg italic text-white flex items-center justify-center font-bold"></i> NUEVA CONVOCATORIA
            </x-button>
        </x-card>
    </div>

    <!-- MAIN FORM GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10 px-4 italic">
        
        <!-- Editable Content -->
        <x-card class="lg:col-span-3 p-12 md:p-16 border-none shadow-2xl space-y-16 bg-white rounded-[4rem] italic" shadow="none">
            <div class="flex items-center gap-6 border-b border-slate-50 pb-10 italic">
                <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-2xl shadow-emerald-500/20 italic rotate-6">
                    <i class="fas fa-sliders-h text-xl font-bold italic"></i>
                </div>
                <div class="italic">
                    <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic">Parámetros del Sistema</h3>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] italic opacity-60 italic">SINCRONIZACIÓN DE METADATOS COOPERATIVOS</p>
                </div>
            </div>

            <form action="{{ route('empresa.perfil.update') }}" method="POST" class="space-y-12 italic">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 italic">
                    <div class="space-y-4 italic">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] pl-2 italic">RAZÓN SOCIAL</label>
                        <div class="relative group italic">
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-focus-within:bg-emerald-50 group-focus-within:text-emerald-500 transition-all italic">
                                <i class="fas fa-building text-xs italic"></i>
                            </div>
                            <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa', $empresa->emp_nombre) }}" required 
                                class="w-full pl-20 pr-8 py-6 rounded-[2rem] bg-slate-50 border-4 border-transparent focus:border-emerald-500/10 focus:bg-white focus:ring-0 transition-all font-black text-slate-700 uppercase italic tracking-tight placeholder:text-slate-200">
                        </div>
                    </div>

                    <div class="space-y-4 italic">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] pl-2 italic">REPRESENTANTE LEGAL</label>
                        <div class="relative group italic">
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-focus-within:bg-emerald-50 group-focus-within:text-emerald-500 transition-all italic">
                                <i class="fas fa-user-tie text-xs italic"></i>
                            </div>
                            <input type="text" name="representante" value="{{ old('representante', $empresa->emp_representante) }}" required 
                                class="w-full pl-20 pr-8 py-6 rounded-[2rem] bg-slate-50 border-4 border-transparent focus:border-emerald-500/10 focus:bg-white focus:ring-0 transition-all font-black text-slate-700 uppercase italic tracking-tight placeholder:text-slate-200">
                        </div>
                    </div>

                    <div class="space-y-4 opacity-50 italic">
                        <label class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] pl-2 italic">NIT (COORDENADA INMUTABLE)</label>
                        <div class="relative italic">
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-300 italic">
                                <i class="fas fa-id-card text-xs italic"></i>
                            </div>
                            <input type="text" value="{{ $empresa->emp_nit }}" disabled 
                                class="w-full pl-20 pr-8 py-6 rounded-[2rem] bg-slate-100 border-4 border-transparent font-black text-slate-400 uppercase italic tracking-tight cursor-not-allowed italic">
                        </div>
                    </div>

                    <div class="space-y-4 opacity-50 italic">
                        <label class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] pl-2 italic">E-MAIL CORPORATIVO</label>
                        <div class="relative italic">
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-300 italic">
                                <i class="fas fa-envelope text-xs italic"></i>
                            </div>
                            <input type="email" value="{{ $empresa->emp_correo }}" disabled 
                                class="w-full pl-20 pr-8 py-6 rounded-[2rem] bg-slate-100 border-4 border-transparent font-black text-slate-400 uppercase italic tracking-tight cursor-not-allowed italic">
                        </div>
                    </div>
                </div>

                <!-- Password Reset -->
                <div class="p-10 bg-slate-900 rounded-[3rem] border-4 border-white shadow-2xl relative overflow-hidden group italic">
                    <!-- Tech Background Element -->
                    <div class="absolute top-0 right-0 p-12 text-white/5 pointer-events-none group-hover:scale-125 transition-transform duration-1000 italic rotate-12">
                        <i class="fas fa-key text-9xl italic"></i>
                    </div>
                    <div class="relative space-y-8 italic">
                        <div class="flex items-center gap-4 italic">
                            <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-emerald-500 italic">
                                <i class="fas fa-lock text-sm italic font-bold"></i>
                            </div>
                            <div class="italic">
                                <h4 class="text-sm font-black text-white tracking-[0.2em] uppercase italic">Protocolos de Seguridad</h4>
                                <p class="text-[9px] font-black text-white/40 uppercase tracking-[0.2em] italic">CIFRADO DE ACCESO AL CENTRO DE MANDO</p>
                            </div>
                        </div>
                        <div class="space-y-4 italic">
                            <label class="text-[10px] font-black text-emerald-500/60 uppercase tracking-[0.4em] pl-2 italic">ACTUALIZAR LLAVE DE ACCESO</label>
                            <input type="password" name="password" placeholder="INGRESA NUEVA CREDENCIAL SOLO SI DESEAS RE-SINCRONIZAR" 
                                class="w-full px-8 py-6 rounded-[2rem] bg-white/5 border-4 border-transparent focus:border-emerald-500/20 focus:bg-white/10 focus:ring-0 transition-all font-black text-white uppercase italic tracking-widest placeholder:text-white/20 italic">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-8 italic">
                    <x-button type="submit" variant="primary" shadow="emerald" class="px-16 py-6 rounded-[2rem] group flex items-center justify-center gap-6 font-black uppercase tracking-[0.2em] text-[11px] active:scale-95 transition-all italic italic shadow-2xl">
                        <i class="fas fa-sync group-hover:rotate-180 transition-transform duration-1000 italic text-white flex items-center justify-center font-bold"></i>
                        SINCRONIZAR ACTUALIZACIONES
                    </x-button>
                </div>
            </form>
        </x-card>

        <!-- Sidebar Activity -->
        <div class="space-y-10 sticky top-12 italic">
            <!-- Stats -->
            <x-card class="p-10 border-none shadow-2xl rounded-[3rem] bg-white space-y-10 relative overflow-hidden italic" shadow="none">
                <div class="absolute top-0 left-0 w-3 h-full bg-emerald-500 italic"></div>
                <h4 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em] italic mb-2">Impacto Corporativo</h4>
                <div class="space-y-6 italic">
                    <div class="p-8 bg-slate-50 rounded-[2.5rem] border-2 border-white shadow-inner italic">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.4em] block mb-4 italic">CONVOCATORIAS ACTIVAS</span>
                        <div class="flex items-baseline gap-4 italic">
                            <span class="text-5xl font-black text-slate-900 italic">{{ str_pad($empresa->proyectos()->count(), 2, '0', STR_PAD_LEFT) }}</span>
                            <x-badge class="bg-emerald-50 text-emerald-600 border-none px-4 py-1.5 rounded-full font-black text-[9px] uppercase tracking-widest italic italic shadow-sm italic ring-1 ring-emerald-100">MISIÓN OK</x-badge>
                        </div>
                    </div>
                    <div class="p-8 bg-emerald-600 rounded-[2.5rem] shadow-2xl shadow-emerald-500/30 text-white relative overflow-hidden group italic">
                        <div class="relative z-10 italic">
                            <span class="text-[9px] font-black text-white/50 uppercase tracking-[0.4em] block mb-2 italic">STATUS_CORPORATIVO</span>
                            <h5 class="text-2xl font-black uppercase italic tracking-tighter italic">ALIADO VERIFICADO</h5>
                        </div>
                        <i class="fas fa-shield-check absolute top-1/2 -translate-y-1/2 -right-8 text-white/10 text-8xl group-hover:scale-110 transition-transform duration-1000 italic"></i>
                    </div>
                </div>
            </x-card>

            <!-- Help -->
            <x-card class="p-10 border-none bg-slate-900 text-white shadow-2xl rounded-[3rem] space-y-8 relative overflow-hidden group italic" shadow="none">
                <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-emerald-500/10 rounded-full blur-[80px] italic"></div>
                <div class="relative space-y-6 italic">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-emerald-400 shadow-2xl italic">
                        <i class="fas fa-headset text-xl italic font-bold"></i>
                    </div>
                    <div class="italic">
                        <h4 class="text-xl font-black uppercase italic tracking-tight italic">Protocolo de Asistencia</h4>
                        <p class="text-white/40 text-[10px] font-black uppercase tracking-[0.2em] leading-relaxed mt-3 italic">CONTACTA CON NUESTROS LÍDERES TÉCNICOS PARA ASESORÍA ESTRATÉGICA.</p>
                    </div>
                    <x-button class="w-full bg-white/5 hover:bg-white/10 border-4 border-white/5 py-5 rounded-[1.5rem] font-black uppercase tracking-widest text-[9px] active:scale-95 transition-all text-white italic italic">
                        DESPLEGAR AYUDA
                    </x-button>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
