@extends('layouts.dashboard')

@section('title', 'Editar Proyecto')
@section('page-title', 'Editar Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 24px;">
        <h2 style="font-size:22px; font-weight:700;">Editar Proyecto</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Actualiza la información del proyecto.</p>
    </div>

    <div class="card">
        <form action="{{ route('empresa.proyectos.update', $proyecto->pro_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Título del Proyecto *</label>
                    <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $proyecto->pro_titulo_proyecto) }}" required>
                </div>
                <div class="form-group">
                    <label>Categoría *</label>
                    <input type="text" name="categoria" class="form-control" value="{{ old('categoria', $proyecto->pro_categoria) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Ubicación del Proyecto *</label>
                <div style="display:flex; gap:8px; align-items:flex-end;">
                    <input type="text" id="ubicacion" name="ubicacion" class="form-control" value="{{ old('ubicacion', $proyecto->pro_ubicacion ?? '') }}" required>
                    <button type="button" id="btn-cargar-ubicacion" class="btn btn-outline" title="Cargar ubicación de la empresa">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>Descripción *</label>
                <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $proyecto->pro_descripcion) }}</textarea>
            </div>

            <div class="form-group">
                <label>Requisitos Específicos *</label>
                <textarea name="requisitos" class="form-control" rows="3" required>{{ old('requisitos', $proyecto->pro_requisitos_especificos) }}</textarea>
            </div>

            <div class="form-group">
                <label>Habilidades Requeridas *</label>
                <input type="text" name="habilidades" class="form-control" value="{{ old('habilidades', $proyecto->pro_habilidades_requerida) }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Fecha de Publicación *</label>
                    <input type="date" name="fecha_publi" id="fecha_publi" class="form-control" value="{{ old('fecha_publi', $proyecto->pro_fecha_publi) }}" required>
                </div>
                <div class="form-group">
                    <label>Duración Estimada *</label>
                    <input type="text" id="duracion" class="form-control" readonly style="background-color:#f5f5f5; cursor:not-allowed;">
                    <span style="font-size:12px; color:#888; margin-top:4px; display:block;">Se calcula automáticamente (6 meses)</span>
                </div>
            </div>

            <div class="form-group">
                <label>Fecha de Finalización Estimada *</label>
                <input type="text" id="fecha_finalizacion" class="form-control" readonly style="background-color:#f5f5f5; cursor:not-allowed;">
                <span style="font-size:12px; color:#888; margin-top:4px; display:block;">Se calcula automáticamente (fecha de publicación + 6 meses)</span>
            </div>

            <div class="form-group">
                <label>Imagen del Proyecto</label>
                @if($proyecto->pro_imagen_url)
                    <div style="margin-bottom:10px;">
                        <img src="{{ $proyecto->pro_imagen_url }}" alt="Proyecto" style="max-width:200px; border-radius:8px;">
                    </div>
                @endif
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <small style="color:#888;">Deja vacío para mantener la imagen actual</small>
            </div>

            <div style="margin-top:24px; display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('empresa.proyectos') }}" class="btn btn-outline">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
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
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('Error al cargar la ubicación', 'error');
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
