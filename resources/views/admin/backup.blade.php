@extends('layouts.dashboard')

@section('title', 'Backup de Base de Datos')
@section('page-title', 'Herramientas - Backup')

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Gestión Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
    <span class="nav-label" style="margin-top: 16px;">Herramientas</span>
    <a href="{{ route('admin.backup') }}" class="nav-item {{ request()->routeIs('admin.backup*') ? 'active' : '' }}">
        <i class="fas fa-database"></i> Backup
    </a>
    <a href="{{ route('admin.audit') }}" class="nav-item {{ request()->routeIs('admin.audit') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i> Auditoría
    </a>
    <span class="nav-label" style="margin-top: 24px; display: flex; align-items: center; gap: 8px; color: var(--primary);">
        <i class="fas fa-headset" style="font-size: 10px;"></i> Soporte
    </span>
    <a href="{{ route('admin.mensajes.soporte') }}" class="nav-item {{ request()->routeIs('admin.mensajes.soporte*') ? 'active' : '' }}">
        <i class="fas fa-envelope"></i> Mensajes Soporte
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* ── Backup page modern styles ── */
        :root {
            --backup-blue: #3b82f6;
            --backup-green: #10b981;
            --backup-purple: #8b5cf6;
            --backup-bg: #f8fafc;
        }

        /* ── Fix z-index issues ── */
        .animate-fade-in {
            position: relative;
            z-index: 1;
        }

        .backup-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #2d5a87 100%);
            border-radius: 20px;
            padding: 40px 36px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.3);
        }
        .backup-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }
        .backup-hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 10%;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        /* ── Action cards ── */
        .backup-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }
        .backup-action-card {
            background: white;
            border-radius: 20px;
            padding: 28px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
            border: 1px solid #e2e8f0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .backup-action-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            border-radius: 20px 20px 0 0;
        }
        .backup-action-card:nth-child(1)::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .backup-action-card:nth-child(2)::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .backup-action-card:nth-child(3)::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

        .backup-action-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(0,0,0,.12);
            border-color: transparent;
        }
        .backup-action-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            transition: transform 0.3s ease;
        }
        .backup-action-card:hover .backup-action-icon {
            transform: scale(1.1);
        }
        .backup-action-card h4 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
        }
        .backup-action-card p {
            margin: 0;
            font-size: .875rem;
            color: #64748b;
            line-height: 1.6;
        }

        /* ── Buttons ── */
        .btn-backup {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 10px;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: .9rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
            margin-top: auto;
        }
        .btn-backup:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,.2);
        }
        .btn-backup:active { transform: translateY(0); }

        .btn-crear    { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
        .btn-exportar { background: linear-gradient(135deg, #10b981, #059669); color: white; }
        .btn-importar { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }

        /* ── Auto backup info bar ── */
        .auto-info-bar {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1px solid #bfdbfe;
            border-radius: 16px;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
            font-size: .9rem;
            color: #1e40af;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.08);
        }
        .auto-info-bar i {
            font-size: 1.4rem;
            color: #3b82f6;
            flex-shrink: 0;
            animation: spin 10s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* ── Import modal ── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 11000;
            padding: 20px;
            animation: fadeIn 0.2s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .modal-backdrop.open { display: flex; }
        .modal-box {
            background: white;
            border-radius: 24px;
            padding: 36px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 24px 80px rgba(0,0,0,.25);
            animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .modal-box h3 {
            margin: 0 0 10px;
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
        }
        .modal-box p {
            margin: 0 0 24px;
            font-size: .9rem;
            color: #64748b;
            line-height: 1.6;
        }
        .file-drop-zone {
            border: 2px dashed #c7d2fe;
            border-radius: 16px;
            padding: 40px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            background: #faf5ff;
        }
        .file-drop-zone:hover, .file-drop-zone.drag-over {
            border-color: #8b5cf6;
            background: #ede9fe;
            transform: scale(1.02);
        }
        .file-drop-zone i {
            font-size: 2.5rem;
            color: #8b5cf6;
            margin-bottom: 12px;
            display: block;
        }
        .file-drop-zone span {
            font-size: .9rem;
            color: #64748b;
            font-weight: 600;
        }
        #selectedFileName {
            font-size: .875rem;
            color: #8b5cf6;
            font-weight: 600;
            margin-bottom: 16px;
            min-height: 24px;
            padding: 8px 16px;
            background: #faf5ff;
            border-radius: 8px;
        }
        .modal-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .btn-cancel {
            background: #f1f5f9;
            color: #64748b;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-cancel:hover { background: #e2e8f0; transform: translateY(-1px); }

        /* ── Warning alert ── */
        .alert-warning-custom {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            font-size: .875rem;
            color: #92400e;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.1);
        }
        .alert-warning-custom i {
            margin-top: 2px;
            flex-shrink: 0;
            color: #f59e0b;
            font-size: 1.1rem;
        }

        /* ── Table badge ── */
        .badge-auto {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .badge-manual {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* ── Improved alerts ── */
        .alert-success-custom {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-left: 4px solid #10b981;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            color: #065f46;
            font-size: .9rem;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
        }
        .alert-error-custom {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid #ef4444;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            color: #7f1d1d;
            font-size: .9rem;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.1);
        }

        /* ── Table improvements ── */
        .backup-table-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
            border: 1px solid #e2e8f0;
        }
        .backup-table-header {
            padding: 24px 28px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        }
        .backup-table-header h3 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .backup-count {
            font-size: .8rem;
            color: #94a3b8;
            font-weight: 600;
            background: white;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #94a3b8;
        }
        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
            display: block;
        }
        .empty-state p {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #64748b;
        }
        .empty-state span {
            font-size: .9rem;
            color: #94a3b8;
        }

        /* ── Action buttons in table ── */
        .table-btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            font-size: .85rem;
        }
        .table-btn:hover {
            transform: scale(1.1);
        }
        .btn-download {
            background: #dcfce7;
            color: #16a34a;
        }
        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }
    </style>
@endsection

@section('content')
<div class="animate-fade-in">

    {{-- ── HERO ── --}}
    <div class="backup-hero">
        <div class="admin-header-icon"><i class="fas fa-database"></i></div>
        <div style="position: relative; z-index: 1;">
            <h1 class="admin-header-title" style="color:white; font-size:1.8rem; margin-bottom:8px;">Backup de Base de Datos</h1>
            <p style="color: rgba(255,255,255,.75); font-size:1rem; margin:0; line-height:1.5;">
                Gestiona copias de seguridad manualmente o déjalo al sistema con los backups automáticos cada 1.5 semanas.
            </p>
        </div>
    </div>

    {{-- ── MENSAJES ── --}}
    @if(session('success'))
        <div class="alert-success-custom">
            <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error-custom">
            <i class="fas fa-exclamation-circle" style="font-size: 1.2rem;"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── TARJETAS DE ACCIÓN ── --}}
    <div class="backup-actions">

        {{-- Crear --}}
        <div class="backup-action-card">
            <div class="backup-action-icon" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                <i class="fas fa-plus-circle" style="color:#3b82f6;"></i>
            </div>
            <div>
                <h4>Crear Backup</h4>
                <p>Genera una copia de seguridad y guárdala en el servidor.</p>
            </div>
            <form action="{{ route('admin.backup.crear') }}" method="POST">
                @csrf
                <button type="submit" class="btn-backup btn-crear">
                    <i class="fas fa-save"></i> Crear Backup
                </button>
            </form>
        </div>

        {{-- Exportar --}}
        <div class="backup-action-card">
            <div class="backup-action-icon" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
                <i class="fas fa-file-export" style="color:#10b981;"></i>
            </div>
            <div>
                <h4>Exportar Base de Datos</h4>
                <p>Genera un backup y descárgalo directamente a tu computador.</p>
            </div>
            <a href="{{ route('admin.backup.exportar') }}"
               class="btn-backup btn-exportar"
               id="btn-exportar"
               onclick="this.innerHTML='<i class=\'fas fa-spinner fa-spin\'></i> Generando...'; setTimeout(()=>this.innerHTML='<i class=\'fas fa-file-export\'></i> Exportar DB',8000);">
                <i class="fas fa-file-export"></i> Exportar DB
            </a>
        </div>

        {{-- Importar --}}
        <div class="backup-action-card">
            <div class="backup-action-icon" style="background: linear-gradient(135deg, #f5f3ff, #ede9fe);">
                <i class="fas fa-file-import" style="color:#8b5cf6;"></i>
            </div>
            <div>
                <h4>Importar / Restaurar</h4>
                <p>Restaura la base de datos desde un archivo .sql o .zip.</p>
            </div>
            <button type="button" class="btn-backup btn-importar"
                    onclick="document.getElementById('modalImportar').classList.add('open')">
                <i class="fas fa-file-import"></i> Importar DB
            </button>
        </div>

    </div>

    {{-- ── BARRA INFO AUTO BACKUP ── --}}
    <div class="auto-info-bar">
        <i class="fas fa-clock"></i>
        <div>
            <strong>Backup automático activo</strong> — El sistema genera copias de seguridad automáticamente
            <strong>cada 10 días (≈ 1.5 semanas)</strong> a las 2:00 AM.
            @if($proximoBackup)
                Próximo estimado: <strong>{{ $proximoBackup }}</strong>.
            @endif
            Se conservan los últimos <strong>5 backups</strong> automáticos.
        </div>
    </div>

    {{-- ── TABLA DE BACKUPS ── --}}
    <div class="backup-table-card">
        <div class="backup-table-header">
            <h3>
                <i class="fas fa-folder-open" style="color: var(--primary);"></i>
                Backups Disponibles
            </h3>
            <span class="backup-count">{{ count($backups) }} archivo(s)</span>
        </div>

        @if(empty($backups))
            <div class="empty-state">
                <i class="fas fa-database"></i>
                <p>No hay backups disponibles</p>
                <span>Crea o exporta el primero usando los botones de arriba.</span>
            </div>
        @else
            <div class="premium-table-container">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Tamaño</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backups as $backup)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 42px; height: 42px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas {{ $backup['tipo'] === 'zip' ? 'fa-file-archive' : 'fa-folder' }}" style="color: #3b82f6; font-size: 1rem;"></i>
                                    </div>
                                    <span style="font-weight: 700; color: var(--text); font-size:.875rem;">{{ $backup['nombre'] }}</span>
                                </div>
                            </td>
                            <td>
                                @if($backup['automatico'])
                                    <span class="badge-auto"><i class="fas fa-robot"></i> Automático</span>
                                @else
                                    <span class="badge-manual"><i class="fas fa-hand-pointer"></i> Manual</span>
                                @endif
                            </td>
                            <td style="color: var(--text-light); font-weight: 600; font-size:.875rem;">
                                {{ $backup['fecha']->format('d/m/Y H:i:s') }}
                            </td>
                            <td>
                                <span style="padding: 6px 14px; background: #f8fafc; border-radius: 20px; font-size: .75rem; font-weight: 700; color: #64748b; border: 1px solid #e2e8f0;">
                                    {{ number_format($backup['tamano'] / 1024, 2) }} KB
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display:flex; gap:8px; justify-content:flex-end;">
                                    <a href="{{ route('admin.backup.descargar', $backup['nombre']) }}"
                                       class="table-btn btn-download"
                                       title="Descargar">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form action="{{ route('admin.backup.eliminar', $backup['nombre']) }}"
                                          method="POST"
                                          style="display:inline;"
                                          onsubmit="return confirm('¿Eliminar el backup \'{{ $backup['nombre'] }}\'? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="table-btn btn-delete"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

{{-- ── MODAL IMPORTAR ── --}}
<div class="modal-backdrop" id="modalImportar" onclick="if(event.target===this) this.classList.remove('open')">
    <div class="modal-box">
        <h3><i class="fas fa-file-import" style="color:#8b5cf6; margin-right:8px;"></i> Importar / Restaurar DB</h3>
        <p>Selecciona un archivo <strong>.sql</strong> o un <strong>.zip</strong> generado previamente por este sistema.</p>

        <div class="alert-warning-custom">
            <i class="fas fa-exclamation-triangle"></i>
            <span><strong>¡Atención!</strong> La importación <strong>reemplazará</strong> los datos actuales de la base de datos con los del archivo seleccionado. Esta acción no se puede deshacer.</span>
        </div>

        <form action="{{ url('/admin/backup/importar') }}" method="POST" enctype="multipart/form-data" id="formImportar">
            @csrf

            <div class="file-drop-zone" id="dropZone" onclick="document.getElementById('archivoBackup').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <span>Haz clic aquí o arrastra tu archivo .sql / .zip</span>
            </div>
            <input type="file" id="archivoBackup" name="archivo_backup" accept=".sql,.zip,.txt" style="display:none;"
                   onchange="mostrarNombreArchivo(this)">
            <div id="selectedFileName"></div>

            @error('archivo_backup')
                <div style="color:#dc2626; font-size:.85rem; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-times-circle"></i> {{ $message }}
                </div>
            @enderror

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalImportar').classList.remove('open')">
                    Cancelar
                </button>
                <button type="submit" class="btn-backup btn-importar" id="btnSubmitImportar" disabled
                        onclick="this.innerHTML='<i class=\'fas fa-spinner fa-spin\'></i> Restaurando...'">
                    <i class="fas fa-upload"></i> Restaurar
                </button>
            </div>
        </form>
    </div>
    </div>
@endsection

@section('scripts')
<script>
    // Mostrar nombre del archivo seleccionado
    function mostrarNombreArchivo(input) {
        const label    = document.getElementById('selectedFileName');
        const btnSubmit = document.getElementById('btnSubmitImportar');
        if (input.files && input.files[0]) {
            label.textContent = '📎 ' + input.files[0].name;
            btnSubmit.disabled = false;
        } else {
            label.textContent = '';
            btnSubmit.disabled = true;
        }
    }

    // Drag & Drop
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('archivoBackup');

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('drag-over');
    });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const dt = new DataTransfer();
            dt.items.add(files[0]);
            fileInput.files = dt.files;
            mostrarNombreArchivo(fileInput);
        }
    });

    // Reabrir modal si hay error de validación
    @if($errors->has('archivo_backup'))
        document.getElementById('modalImportar').classList.add('open');
    @endif
</script>
@endsection