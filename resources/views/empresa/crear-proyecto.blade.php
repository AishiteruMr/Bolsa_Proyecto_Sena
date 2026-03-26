@extends('layouts.dashboard')

@section('title', 'Lanzar Nueva Misión | ' . (session('nombre') ?? 'Empresa'))

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
        <i class="fas fa-plus-circle group-hover:scale-110 transition-transform italic text-[#FF6B00]"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Lanzar Misión</span>
    </a>
    
    <span class="nav-label text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mt-6 mb-2 block italic text-slate-400">CONFIGURACIÓN</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item group {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building group-hover:rotate-12 transition-transform italic text-slate-400"></i> 
        <span class="font-bold tracking-tight uppercase text-xs italic text-slate-400">Perfil Corporativo</span>
    </a>

@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-12 pb-24 font-bold italic">
    
    <!-- Header Section -->
    <div class="space-y-8 px-4">
        <a href="{{ route('empresa.proyectos') }}" class="inline-flex items-center text-[10px] font-black text-[#E65100] uppercase tracking-[0.2em] hover:text-orange-700 transition-all group italic">
            <i class="fas fa-chevron-left mr-3 group-hover:-translate-x-1 transition-transform italic text-[#FF6B00]"></i> 
            RETORNAR AL PUERTO DE PROYECTOS
        </a>
        <div class="space-y-4 italic">
            <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                Lanzar <span class="text-[#FF6B00] underline decoration-[#FF6B00]/10 decoration-8 underline-offset-8">Nueva Misión</span>
            </h2>
            <p class="text-slate-400 text-lg uppercase italic font-bold">
                DEFINE LOS PARÁMETROS DE TU DESAFÍO TÉCNICO PARA ATRAER AL TALENTO DE ÉLITE SENA.
            </p>
        </div>
    </div>

    <form action="{{ route('empresa.proyectos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12 px-4 italic font-bold text-slate-900">
        @csrf
        
        <x-card class="p-10 md:p-16 border-none shadow-2xl rounded-[4rem] bg-white space-y-16 italic" shadow="none">
            
            <!-- Identidad Logic -->
            <section class="space-y-10 italic">
                <div class="flex items-center gap-6 border-b border-slate-100 pb-8 italic">
                    <div class="w-14 h-14 rounded-2xl bg-[#FF6B00] text-white flex items-center justify-center italic shadow-2xl shadow-[#FF6B00]/20 rotate-3">
                        <i class="fas fa-fingerprint text-xl italic font-bold text-white"></i>
                    </div>
                    <div class="italic">
                        <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Identidad de Misión</h3>
                        <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.3em] italic opacity-60 italic">METADATOS BÁSICOS DEL PROYECTO</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 italic">
                    <div class="md:col-span-2 space-y-3 italic">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic mb-1 block">TÍTULO DE LA PROPUESTA CORPORATIVA *</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}" required maxlength="200"
                            class="w-full px-8 py-5 rounded-[1.5rem] bg-slate-50 border-2 {{ $errors->has('titulo') ? 'border-red-500 bg-red-50' : 'border-slate-100' }} focus:border-[#FF6B00] focus:bg-white focus:ring-8 focus:ring-[#FF6B00]/5 transition-all font-black text-slate-900 uppercase italic placeholder:text-slate-300 placeholder:italic italic" 
                            placeholder="EJ: OPTIMIZACIÓN DE ARQUITECTURA CLOUD">
                        @error('titulo')
                            <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mt-2 ml-4 italic animate-pulse">!! {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-3 italic">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic mb-1 block">DIVISIÓN / CATEGORÍA *</label>
                        <div class="relative italic">
                            <select name="categoria" required 
                                class="w-full px-8 py-5 rounded-[1.5rem] bg-slate-50 border-2 {{ $errors->has('categoria') ? 'border-red-500 bg-red-50' : 'border-slate-100' }} focus:border-[#FF6B00] focus:bg-white transition-all font-black text-slate-900 uppercase italic appearance-none cursor-pointer italic">
                                <option value="">SELECCIONAR ÁREA...</option>
                                @foreach(['Tecnología', 'Agrícola', 'Industrial', 'Salud', 'Ambiental', 'Otro'] as $cat)
                                    <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>{{ strtoupper($cat) }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-[#FF6B00] pointer-events-none italic text-xs"></i>
                        </div>
                        @error('categoria')
                            <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mt-2 ml-4 italic animate-pulse">!! {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <!-- Metas y Alcance -->
            <section class="space-y-10 italic">
                <div class="flex items-center gap-6 border-b border-slate-100 pb-8 italic">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center italic shadow-2xl shadow-blue-500/20 -rotate-3">
                        <i class="fas fa-bullseye text-xl italic font-bold"></i>
                    </div>
                    <div class="italic">
                        <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Alcance y Objetivos</h3>
                        <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.3em] italic opacity-60 italic">DEFINICIÓN DEL DESAFÍO TÉCNICO</p>
                    </div>
                </div>
                
                <div class="space-y-4 italic">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic mb-1 block">MANIFIESTO DEL DESAFÍO *</label>
                    <textarea name="descripcion" required rows="5" maxlength="500"
                        class="w-full px-8 py-6 rounded-[2rem] bg-slate-50 border-2 {{ $errors->has('descripcion') ? 'border-red-500 bg-red-50' : 'border-slate-100' }} focus:border-blue-500 focus:bg-white focus:ring-8 focus:ring-blue-500/5 transition-all font-black text-slate-900 uppercase italic placeholder:text-slate-300 placeholder:italic italic min-h-[180px]" 
                        placeholder="DESCRIBE EL PROBLEMA A RESOLVER Y LOS HITOS ESPERADOS PARA LA MISIÓN...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mt-2 ml-4 italic animate-pulse">!! {{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 italic">
                    <div class="space-y-4 italic">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic mb-1 block">REQ. TÉCNICOS / HARD SKILLS *</label>
                        <textarea name="requisitos" required rows="4" maxlength="200"
                            class="w-full px-8 py-6 rounded-[2rem] bg-slate-50 border-2 {{ $errors->has('requisitos') ? 'border-red-500 bg-red-50' : 'border-slate-100' }} focus:border-[#FF6B00] focus:bg-white transition-all font-black text-slate-900 uppercase italic placeholder:text-slate-300 placeholder:italic italic" 
                            placeholder="FRAMEWORKS, LENGUAJES O HERRAMIENTAS ESPECÍFICAS CRÍTICAS...">{{ old('requisitos') }}</textarea>
                        @error('requisitos')
                            <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mt-2 ml-4 italic animate-pulse">!! {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-4 italic">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] italic mb-1 block">REQ. CONDUCTUALES / SOFT SKILLS *</label>
                        <textarea name="habilidades" required rows="4" maxlength="200"
                            class="w-full px-8 py-6 rounded-[2rem] bg-slate-50 border-2 {{ $errors->has('habilidades') ? 'border-red-500 bg-red-50' : 'border-slate-100' }} focus:border-amber-500 focus:bg-white transition-all font-black text-slate-900 uppercase italic placeholder:text-slate-300 placeholder:italic italic" 
                            placeholder="LIDERAZGO, COMUNICACIÓN ASERTIVA, PENSAMIENTO LATERAL...">{{ old('habilidades') }}</textarea>
                        @error('habilidades')
                            <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mt-2 ml-4 italic animate-pulse">!! {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <!-- Cronograma -->
            <section class="space-y-10 italic">
                <div class="flex items-center gap-6 border-b border-slate-100 pb-8 italic">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center italic shadow-2xl shadow-amber-500/20 rotate-12">
                        <i class="fas fa-calendar-check text-xl italic font-bold"></i>
                    </div>
                    <div class="italic">
                        <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Cronograma de Operación</h3>
                        <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.3em] italic opacity-60 italic">VENTANA TEMPORAL DE EJECUCIÓN</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-10 bg-slate-900 rounded-[3.5rem] border-none shadow-2xl relative overflow-hidden italic">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-[#FF6B00]/5 rounded-full italic font-bold"></div>
                    
                    <div class="space-y-4 italic relative z-10 text-center">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.4em] italic block">INÍCIO DE DESPLIEGUE</label>
                        <input type="date" name="fecha_publi" id="fecha_publi" value="{{ old('fecha_publi', date('Y-m-d')) }}" required 
                            class="w-full bg-white/5 border-2 border-white/10 rounded-2xl px-6 py-4 font-black text-orange-400 text-center uppercase italic focus:border-[#FF6B00] focus:ring-0 transition-all cursor-pointer italic">
                    </div>
                    
                    <div class="space-y-4 italic relative z-10 text-center">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.4em] italic block">DURACIÓN ESTIMADA</label>
                        <div class="px-6 py-4 rounded-2xl bg-[#FF6B00] text-white font-black text-center shadow-2xl shadow-[#FF6B00]/20 uppercase italic border border-white/10 italic">
                            <input type="text" id="duracion" readonly class="bg-transparent border-none text-center w-full focus:ring-0 cursor-default p-0 font-black italic value-['--']" value="--">
                        </div>
                    </div>
                    
                    <div class="space-y-4 italic relative z-10 text-center">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.4em] italic block">FINALIZACIÓN PREVISTA</label>
                        <div class="px-6 py-4 rounded-2xl bg-white/5 border-2 border-white/10 text-slate-300 font-black text-center uppercase italic italic">
                            <input type="text" id="fecha_finalizacion" readonly class="bg-transparent border-none text-center w-full focus:ring-0 cursor-default p-0 font-black italic uppercase italic value-['--']" value="--">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Media & Geo -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 italic font-bold">
                <section class="space-y-8 italic">
                    <div class="flex items-center gap-6 border-b border-slate-100 pb-8 italic">
                        <div class="w-14 h-14 rounded-2xl bg-red-500 text-white flex items-center justify-center italic shadow-2xl shadow-red-500/20 -rotate-6">
                            <i class="fas fa-map-marked-alt text-xl italic font-bold"></i>
                        </div>
                        <div class="italic">
                            <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Nodo de Despliegue</h3>
                            <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.3em] italic opacity-60 italic">UBICACIÓN GEOGRÁFICA FOCAL</p>
                        </div>
                    </div>
                    <div id="map" class="w-full h-[350px] rounded-[3rem] border-8 border-slate-50 shadow-2xl ring-1 ring-slate-200 overflow-hidden relative z-10 italic"></div>
                    <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
                    <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">
                </section>

                <section class="space-y-8 italic">
                    <div class="flex items-center gap-6 border-b border-slate-100 pb-8 italic">
                        <div class="w-14 h-14 rounded-2xl bg-purple-600 text-white flex items-center justify-center italic shadow-2xl shadow-purple-500/20 rotate-6">
                            <i class="fas fa-satellite text-xl italic font-bold"></i>
                        </div>
                        <div class="italic">
                            <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Visual de Misión</h3>
                            <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.3em] italic opacity-60 italic">IMAGEN IDENTIFICADORA (HERO)</p>
                        </div>
                    </div>
                    <div id="image-upload-container" class="relative group h-[350px] bg-slate-50 border-8 border-slate-50 shadow-2xl ring-1 ring-slate-200 rounded-[3rem] overflow-hidden flex flex-col items-center justify-center transition-all hover:bg-orange-50/20 italic">
                        <div id="image-upload-content" class="text-center p-12 pointer-events-none transition-all group-hover:scale-110 italic">
                            <div class="w-20 h-20 rounded-3xl bg-white shadow-xl flex items-center justify-center mx-auto mb-6 text-[#FF6B00] italic">
                                <i class="fas fa-cloud-upload-alt text-3xl italic"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-900 uppercase tracking-[0.3em] italic">Arrastrar Artifacto</p>
                            <p class="text-[9px] font-black text-slate-400 mt-3 italic uppercase opacity-60">JPG, PNG (MAX 2MB BUFFER)</p>
                        </div>
                        <img id="image-preview" src="" class="hidden absolute inset-0 w-full h-full object-cover z-20 pointer-events-none italic">
                        <input type="file" name="imagen" id="imagen-input" class="absolute inset-0 opacity-0 cursor-pointer z-30 italic" accept="image/*">
                    </div>
                </section>
            </div>

            <!-- Action Toolbar -->
            <div class="flex flex-col md:flex-row gap-6 justify-end items-center pt-12 border-t border-slate-100 group italic">
                <x-button variant="secondary" :href="route('empresa.proyectos')" class="w-full md:w-auto px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-red-500 border-none bg-transparent active:scale-95 transition-all italic underline decoration-slate-200 hover:decoration-red-200 underline-offset-8">
                    ABORTAR OPERACIÓN
                </x-button>
                <x-button type="submit" variant="primary" shadow="orange" class="w-full md:w-auto px-14 py-6 rounded-3xl group flex items-center justify-center gap-4 text-[11px] font-black uppercase italic shadow-2xl active:scale-95 transition-all">
                    <i class="fas fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform italic text-lg text-white"></i>
                    INICIAR DESPLIEGUE DE MISIÓN
                </x-button>
            </div>
        </x-card>
    </form>
</div>

<!-- LEAFLET & LOGIC SCRIPTS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ---- Cronograma Logic ----
    const fechaPubliInput = document.getElementById('fecha_publi');
    const duracionInput = document.getElementById('duracion');
    const fechaFinalizacionInput = document.getElementById('fecha_finalizacion');

    function calcularFechas() {
        const fechaPubli = new Date(fechaPubliInput.value);
        if (!isNaN(fechaPubli.getTime())) {
            const fechaFinalizacion = new Date(fechaPubli);
            fechaFinalizacion.setMonth(fechaFinalizacion.getMonth() + 6);
            const duracionDias = Math.ceil((fechaFinalizacion - fechaPubli) / (1000 * 60 * 60 * 24));
            duracionInput.value = duracionDias + ' DÍAS (SEMESTRE)';
            fechaFinalizacionInput.value = fechaFinalizacion.toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' }).toUpperCase();
        }
    }
    fechaPubliInput.addEventListener('change', calcularFechas);
    calcularFechas();

    // ---- Leaflet Logic ----
    try {
        let defaultLat = 4.6097;
        let defaultLng = -74.0817;
        const latInput = document.getElementById('latitud');
        const lngInput = document.getElementById('longitud');

        if(latInput.value && lngInput.value) {
            defaultLat = parseFloat(latInput.value);
            defaultLng = parseFloat(lngInput.value);
        }

        const map = L.map('map', { zoomControl: false }).setView([defaultLat, defaultLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        function actualizarInputs(lat, lng) {
            latInput.value = lat;
            lngInput.value = lng;
        }

        marker.on('dragend', () => actualizarInputs(marker.getLatLng().lat, marker.getLatLng().lng));
        map.on('click', (e) => {
            marker.setLatLng(e.latlng);
            actualizarInputs(e.latlng.lat, e.latlng.lng);
        });
        setTimeout(() => map.invalidateSize(), 500);
    } catch (e) { console.error('Map Error:', e); }

    // ---- Image Preview Logic ----
    const imgInp = document.getElementById('imagen-input');
    const imgPre = document.getElementById('image-preview');
    const imgCnt = document.getElementById('image-upload-content');

    imgInp.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imgPre.src = e.target.result;
                imgPre.classList.remove('hidden');
                imgCnt.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
