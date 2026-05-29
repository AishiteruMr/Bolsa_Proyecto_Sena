const fieldMapper = {
    'usr_correo': 'Correo Electrónico',
    'usr_nombre': 'Nombre Personal',
    'usr_apellido': 'Apellidos',
    'usr_rol': 'Perfil del Usuario',
    'usr_estado': 'Estado de Cuenta',
    'prj_nombre': 'Título del Proyecto',
    'prj_descripcion': 'Descripción Detallada',
    'prj_estado': 'Estado de Aprobación',
    'emp_nombre': 'Razón Social',
    'emp_nit': 'Identificación NIT',
    'password': 'Clave de Seguridad',
    'remember_token': 'Token de Sesión',
    'created_at': 'Fecha de Registro',
    'updated_at': 'Última Modificación',
    'email_verified_at': 'Verificación de Email',
    'activo': 'Estado Operativo',
    'rol_id': 'Tipo de Acceso',
    'instructor_usuario_id': 'Instructor Responsable',
    'aprendiz_id': 'Aprendiz Vinculado',
    'numero_documento': 'Documento de Identidad',
    'nombres': 'Nombres Reales',
    'apellidos': 'Apellidos Reales',
    'especialidad': 'Área de Especialidad',
    'telefono': 'Número de Contacto',
    'empresa_nit': 'NIT de Empresa'
};

function translateField(field) {
    return fieldMapper[field] || field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}

function formatValue(key, val) {
    if (val === null || val === undefined) return '<span style="opacity: 0.5; font-style: italic;">Sin asignar</span>';
    if (['usr_estado', 'activo', 'estado', 'prj_estado', 'calidad_aprobada'].includes(key)) {
        if (val == 1 || val === '1' || val === true || val === 'aprobado')
            return '<span class="badge-value badge-ok">Habilitado / Aprobado</span>';
        if (val == 0 || val === '0' || val === false || val === 'rechazado' || val === 'cerrado')
            return '<span class="badge-value badge-fail">Inactivo / No Aprobado</span>';
    }
    if (key === 'rol_id') {
        const roles = {1: 'Aprendiz', 2: 'Instructor', 3: 'Empresa', 4: 'Administrador'};
        return roles[val] || val;
    }
    if (typeof val === 'boolean') return val ? 'Sí' : 'No';
    if (typeof val === 'object') return '<pre class="json-pre">' + JSON.stringify(val, null, 2) + '</pre>';
    if (key === 'password') return '•••••••• (Protegida por seguridad)';
    return val;
}

function verDetalles(id) {
    const dataRaw = document.getElementById('data-' + id).textContent;
    const data = JSON.parse(dataRaw);
    document.getElementById('modalSubtitle').textContent = `Acción por ${data.usuario} • ${data.fecha}`;
    let html = '<div class="modal-detail-grid">';
    const anterior = data.anterior || {};
    const nuevo = data.nuevo || {};
    const keys = [...new Set([...Object.keys(anterior), ...Object.keys(nuevo)])];
    const changedKeys = keys.filter(key => JSON.stringify(anterior[key]) !== JSON.stringify(nuevo[key]));
    if (changedKeys.length > 0) {
        html += `
            <div class="modal-summary-card">
                <div class="modal-summary-icon">
                    <i class="fas fa-microscope"></i>
                </div>
                <div>
                    <div class="modal-summary-tags">
                        <span class="modal-tag-module">${data.modulo}</span>
                        ${data.registro_id ? `<span class="modal-tag-id">ID: #${data.registro_id}</span>` : ''}
                        <h5 class="modal-summary-title">Análisis de Actividad</h5>
                    </div>
                    <p class="modal-summary-text">
                        Se han identificado <strong>${changedKeys.length}</strong> cambios detallados en el módulo de <strong>${data.modulo}</strong>.
                        <span class="modal-summary-sub">Esta auditoría garantiza la integridad de la operación realizada.</span>
                    </p>
                </div>
            </div>
        `;
        changedKeys.forEach(key => {
            const valAnt = anterior[key];
            const valNue = nuevo[key];
            html += `
                <div class="modal-field-card">
                    <div class="modal-field-header">
                        <div class="modal-field-label">
                            <span class="modal-field-dot"></span>
                            <span class="modal-field-name">${translateField(key)}</span>
                        </div>
                        <span class="modal-field-key">${key}</span>
                    </div>
                    <div class="modal-field-compare">
                        <div class="modal-field-old">
                            <div class="modal-field-subtitle">
                                <i class="fas fa-history"></i> Estado Previo
                            </div>
                            <div class="modal-field-value old">
                                ${formatValue(key, valAnt)}
                            </div>
                        </div>
                        <div class="modal-field-new">
                            <div class="modal-field-subtitle new">
                                <i class="fas fa-arrow-right"></i> Nuevo Estado
                            </div>
                            <div class="modal-field-value new">
                                ${formatValue(key, valNue)}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        html += `
            <div class="modal-empty-state">
                <div class="modal-empty-icon">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <h4 class="modal-empty-title">Sin cambios atómicos</h4>
                <p class="modal-empty-desc">La operación de <strong>${data.accion}</strong> se registró exitosamente como un evento de sistema sin mutación de campos específicos.</p>
            </div>
        `;
    }
    html += '</div>';
    document.getElementById('modalContent').innerHTML = html;
    document.getElementById('modalDetalles').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModal() {
    document.getElementById('modalDetalles').style.display = 'none';
    document.body.style.overflow = '';
}

window.onclick = function(event) {
    const modal = document.getElementById('modalDetalles');
    if (event.target == modal) cerrarModal();
};

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});
