@extends('layouts.dashboard')
@section('title', 'Publicar Proyecto')
@section('page-title', 'Publicar Nuevo Proyecto')

@section('sidebar-nav')
    <a href="{{ route('empresa.dashboard') }}" class="nav-item"><i class="fas fa-home"></i> Dashboard</a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item"><i class="fas fa-project-diagram"></i> Mis Proyectos</a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item active"><i class="fas fa-plus-circle"></i> Publicar Proyecto</a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item"><i class="fas fa-building"></i> Perfil Empresa</a>
@endsection

@section('content')
<div style="max-width:760px;">
    <div class="card">
        <h3 style="font-size:17px; font-weight:600; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f0f0f0;">
            <i class="fas fa-plus-circle" style="color:#39a900;"></i> Detalles del Proyecto
        </h3>

        <form action="{{ route('empresa.proyectos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Título del Proyecto </label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" class="form-control" placeholder="Ej: Optimización de procesos..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Categoría </label>
                    <select name="categoria" class="form-control" required>
                        <option value="">Seleccionar...</option>
                        <option value="Agrícola" {{ old('categoria') == 'Agrícola' ? 'selected' : '' }}>Agrícola</option>
                        <option value="Industrial" {{ old('categoria') == 'Industrial' ? 'selected' : '' }}>Industrial</option>
                        <option value="Tecnología" {{ old('categoria') == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
                        <option value="Salud" {{ old('categoria') == 'Salud' ? 'selected' : '' }}>Salud</option>
                        <option value="Educación" {{ old('categoria') == 'Educación' ? 'selected' : '' }}>Educación</option>
                        <option value="Ambiental" {{ old('categoria') == 'Ambiental' ? 'selected' : '' }}>Ambiental</option>
                        <option value="Otro" {{ old('categoria') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ubicación del Proyecto *</label>
                <div style="display:flex; gap:8px; align-items:flex-end;">
                    <input type="text" id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" class="form-control" placeholder="Cargando ubicación..." required>
                    <button type="button" id="btn-cargar-ubicacion" class="btn btn-outline" title="Cargar ubicación de la empresa">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <span style="font-size:12px; color:#888; margin-top:4px; display:block;">Se completará automáticamente con la ubicación de tu empresa</span>
            </div>

            <div class="form-group">
                <label class="form-label">Descripción </label>
                <textarea name="descripcion" class="form-control" rows="4" placeholder="Describe el proyecto, sus objetivos y actividades..." required>{{ old('descripcion') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Requisitos Específicos </label>
                <textarea name="requisitos" class="form-control" rows="3" placeholder="Conocimientos o condiciones necesarias..." required>{{ old('requisitos') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Habilidades Requeridas </label>
                <input type="text" name="habilidades" value="{{ old('habilidades') }}" class="form-control" placeholder="Ej: Trabajo en equipo, Excel, Programación..." required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Fecha de Publicación </label>
                    <input type="date" name="fecha_publi" id="fecha_publi" value="{{ old('fecha_publi', date('Y-m-d')) }}" class="form-control" required>
                    <span style="font-size:12px; color:#888; margin-top:4px; display:block;">Fecha actual por defecto</span>
                </div>
                <div class="form-group">
                    <label class="form-label">Duración Estimada </label>
                    <input type="text" id="duracion" class="form-control" placeholder="180 días (6 meses)" readonly style="background-color:#f5f5f5; cursor:not-allowed;">
                    <span style="font-size:12px; color:#888; margin-top:4px; display:block;">Se calcula automáticamente (6 meses)</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Fecha de Finalización Estimada *</label>
                <input type="text" id="fecha_finalizacion" class="form-control" readonly style="background-color:#f5f5f5; cursor:not-allowed;">
                <span style="font-size:12px; color:#888; margin-top:4px; display:block;">Se calcula automáticamente (fecha de publicación + 6 meses)</span>
            </div>

            <div class="form-group">
                <label class="form-label">Imagen del Proyecto</label>
                <input type="file" name="imagen" class="form-control" accept="image/jpg,image/jpeg,image/png">
                <span style="font-size:12px; color:#888;">Opcional. JPG/PNG, máx 2MB.</span>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:8px;">
                <a href="{{ route('empresa.proyectos') }}" class="btn btn-outline">Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Publicar Proyecto</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ubicacionInput = document.getElementById('ubicacion');
        const btnCargarUbicacion = document.getElementById('btn-cargar-ubicacion');
        const fechaPubliInput = document.getElementById('fecha_publi');
        const duracionInput = document.getElementById('duracion');
        const fechaFinalizacionInput = document.getElementById('fecha_finalizacion');

        // ── CARGAR UBICACIÓN DE LA EMPRESA ────────────────────────────────────
        function cargarUbicacionEmpresa() {
            btnCargarUbicacion.disabled = true;
            btnCargarUbicacion.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch('/api/empresa/ubicacion/sesion', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    const ubicacion = data.data.ubicacion || data.data.ubicacion_completa || 'Por definir';
                    ubicacionInput.value = ubicacion;
                    
                    // Mostrar notificación
                    mostrarNotificacion('✓ Ubicación cargada: ' + ubicacion, 'success');
                } else {
                    mostrarNotificacion('No se pudo cargar la ubicación de la empresa', 'warning');
                    ubicacionInput.value = 'Por definir';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al cargar la ubicación', 'error');
                ubicacionInput.value = 'Por definir';
            })
            .finally(() => {
                btnCargarUbicacion.disabled = false;
                btnCargarUbicacion.innerHTML = '<i class="fas fa-sync-alt"></i>';
            });
        }

        // ── NOTIFICACIONES ────────────────────────────────────────────────────────
        function mostrarNotificacion(mensaje, tipo) {
            const notif = document.createElement('div');
            notif.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 12px 20px;
                background-color: ${tipo === 'success' ? '#28a745' : tipo === 'error' ? '#dc3545' : '#ffc107'};
                color: ${tipo === 'warning' ? '#000' : '#fff'};
                border-radius: 4px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                font-size: 14px;
                z-index: 9999;
                animation: slideIn 0.3s ease-out;
            `;
            notif.textContent = mensaje;
            document.body.appendChild(notif);

            setTimeout(() => {
                notif.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notif.remove(), 300);
            }, 3000);
        }

        // ── CALCULAR FECHAS ──────────────────────────────────────────────────────
        function calcularFechas() {
            const fechaPubli = new Date(fechaPubliInput.value);
            
            if (!isNaN(fechaPubli.getTime())) {
                const fechaFinalizacion = new Date(fechaPubli);
                fechaFinalizacion.setMonth(fechaFinalizacion.getMonth() + 6);
                
                const duracionDias = Math.ceil((fechaFinalizacion - fechaPubli) / (1000 * 60 * 60 * 24));
                
                const opcionesFormato = { year: 'numeric', month: 'long', day: 'numeric' };
                const fechaFinFormatted = fechaFinalizacion.toLocaleDateString('es-ES', opcionesFormato);
                
                duracionInput.value = duracionDias + ' días (6 meses)';
                fechaFinalizacionInput.value = fechaFinFormatted;
            }
        }

        // ── EVENT LISTENERS ───────────────────────────────────────────────────────
        btnCargarUbicacion.addEventListener('click', cargarUbicacionEmpresa);
        fechaPubliInput.addEventListener('change', calcularFechas);

        // ── INICIALIZAR ───────────────────────────────────────────────────────────
        cargarUbicacionEmpresa();
        calcularFechas();
    });

    // ── ESTILOS DE ANIMACIÓN ──────────────────────────────────────────────────────
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        #btn-cargar-ubicacion {
            padding: 10px 16px;
            min-width: 44px;
            white-space: nowrap;
        }

        #btn-cargar-ubicacion:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    `;
    document.head.appendChild(style);
</script>

<style>
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
