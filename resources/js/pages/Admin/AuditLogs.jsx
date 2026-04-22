import React from 'react';
import { usePage, useForm } from '@inertiajs/react';

export default function AuditLogs() {
  const { props } = usePage();
  const logs = props.logs || { data: [], links: [] };
  const modulos = props.modulos || [];
  const acciones = props.acciones || [];

  const { data, setData, get, processing } = useForm({
    modulo: '',
    accion: '',
    usuario_id: '',
    fecha_inicio: '',
    fecha_fin: '',
  });

  const aplicarFiltros = () => {
    get('/admin/audit');
  };

  const getAccionColor = (accion) => {
    const colores = {
      'crear': '#10b981',
      'actualizar': '#3b82f6',
      'eliminar': '#ef4444',
      'login': '#8b5cf6',
      'logout': '#6b7280',
      'exportar': '#f59e0b',
    };
    return colores[accion?.toLowerCase()] || '#6b7280';
  };

  const getIcono = (accion) => {
    const iconos = {
      'crear': 'fa-plus',
      'actualizar': 'fa-edit',
      'eliminar': 'fa-trash',
      'login': 'fa-sign-in-alt',
      'logout': 'fa-sign-out-alt',
      'exportar': 'fa-download',
    };
    return iconos[accion?.toLowerCase()] || 'fa-history';
  };

  return (
    <div style={{ padding: '40px 20px', maxWidth: '1400px', margin: '0 auto' }}>
      <div style={{ marginBottom: '30px' }}>
        <a href="/admin/dashboard" style={{ color: 'var(--primary)', textDecoration: 'none', fontSize: '14px', marginBottom: '8px', display: 'inline-block' }}>
          ← Volver al Dashboard
        </a>
        <h1 style={{ fontSize: '28px', fontWeight: '800', color: 'var(--text)', margin: '8px 0' }}>
          Registros de Actividad (Audit Log)
        </h1>
      </div>

      <div style={{ background: 'white', borderRadius: '12px', padding: '20px', marginBottom: '20px', boxShadow: '0 1px 3px rgba(0,0,0,0.1)' }}>
        <h3 style={{ fontSize: '14px', fontWeight: '600', marginBottom: '15px' }}>Filtros</h3>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(180px, 1fr))', gap: '15px' }}>
          <div>
            <label style={{ fontSize: '12px', color: 'var(--text-light)', display: 'block', marginBottom: '4px' }}>Módulo</label>
            <select
              value={data.modulo}
              onChange={(e) => setData('modulo', e.target.value)}
              style={{ width: '100%', padding: '8px 12px', borderRadius: '6px', border: '1px solid #e2e8f0' }}
            >
              <option value="">Todos los módulos</option>
              {modulos.map((m) => (
                <option key={m} value={m}>{m}</option>
              ))}
            </select>
          </div>
          <div>
            <label style={{ fontSize: '12px', color: 'var(--text-light)', display: 'block', marginBottom: '4px' }}>Acción</label>
            <select
              value={data.accion}
              onChange={(e) => setData('accion', e.target.value)}
              style={{ width: '100%', padding: '8px 12px', borderRadius: '6px', border: '1px solid #e2e8f0' }}
            >
              <option value="">Todas las acciones</option>
              {acciones.map((a) => (
                <option key={a} value={a}>{a}</option>
              ))}
            </select>
          </div>
          <div>
            <label style={{ fontSize: '12px', color: 'var(--text-light)', display: 'block', marginBottom: '4px' }}>Fecha Inicio</label>
            <input
              type="date"
              value={data.fecha_inicio}
              onChange={(e) => setData('fecha_inicio', e.target.value)}
              style={{ width: '100%', padding: '8px 12px', borderRadius: '6px', border: '1px solid #e2e8f0' }}
            />
          </div>
          <div>
            <label style={{ fontSize: '12px', color: 'var(--text-light)', display: 'block', marginBottom: '4px' }}>Fecha Fin</label>
            <input
              type="date"
              value={data.fecha_fin}
              onChange={(e) => setData('fecha_fin', e.target.value)}
              style={{ width: '100%', padding: '8px 12px', borderRadius: '6px', border: '1px solid #e2e8f0' }}
            />
          </div>
          <div style={{ display: 'flex', alignItems: 'flex-end' }}>
            <button onClick={aplicarFiltros} className="btn-submit" style={{ width: '100%' }}>
              Aplicar Filtros
            </button>
          </div>
        </div>
      </div>

      <div style={{ background: 'white', borderRadius: '12px', overflow: 'hidden', boxShadow: '0 1px 3px rgba(0,0,0,0.1)' }}>
        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
          <thead>
            <tr style={{ background: '#f8fafc' }}>
              <th style={{ padding: '12px 16px', textAlign: 'left', fontSize: '12px', fontWeight: '600', color: '#64748b' }}>Fecha</th>
              <th style={{ padding: '12px 16px', textAlign: 'left', fontSize: '12px', fontWeight: '600', color: '#64748b' }}>Usuario</th>
              <th style={{ padding: '12px 16px', textAlign: 'left', fontSize: '12px', fontWeight: '600', color: '#64748b' }}>Acción</th>
              <th style={{ padding: '12px 16px', textAlign: 'left', fontSize: '12px', fontWeight: '600', color: '#64748b' }}>Módulo</th>
              <th style={{ padding: '12px 16px', textAlign: 'left', fontSize: '12px', fontWeight: '600', color: '#64748b' }}>Detalles</th>
              <th style={{ padding: '12px 16px', textAlign: 'left', fontSize: '12px', fontWeight: '600', color: '#64748b' }}>IP</th>
            </tr>
          </thead>
          <tbody>
            {logs.data.length === 0 ? (
              <tr>
                <td colSpan={6} style={{ padding: '40px', textAlign: 'center', color: '#64748b' }}>
                  No hay registros
                </td>
              </tr>
            ) : (
              logs.data.map((log) => (
                <tr key={log.id} style={{ borderTop: '1px solid #f1f5f9' }}>
                  <td style={{ padding: '12px 16px', fontSize: '13px' }}>
                    {new Date(log.created_at).toLocaleString('es-CO')}
                  </td>
                  <td style={{ padding: '12px 16px', fontSize: '13px' }}>
                    {log.usuario?.nombre || 'Sistema'}
                  </td>
                  <td style={{ padding: '12px 16px' }}>
                    <span style={{
                      background: `${getAccionColor(log.accion)}20`,
                      color: getAccionColor(log.accion),
                      padding: '4px 10px',
                      borderRadius: '12px',
                      fontSize: '11px',
                      fontWeight: '600',
                      textTransform: 'uppercase',
                    }}>
                      {log.accion}
                    </span>
                  </td>
                  <td style={{ padding: '12px 16px', fontSize: '13px' }}>{log.modulo}</td>
                  <td style={{ padding: '12px 16px', fontSize: '13px', maxWidth: '300px', overflow: 'hidden', textOverflow: 'ellipsis' }}>
                    {log.descripcion}
                  </td>
                  <td style={{ padding: '12px 16px', fontSize: '13px', fontFamily: 'monospace' }}>{log.ip}</td>
                </tr>
              ))
            )}
          </tbody>
        </table>
      </div>

      {logs.links && logs.links.length > 3 && (
        <div style={{ display: 'flex', justifyContent: 'center', gap: '8px', marginTop: '20px' }}>
          {logs.links.map((link, i) => (
            <a
              key={i}
              href={link.url}
              dangerouslySetInnerHTML={{ __html: link.label }}
              style={{
                padding: '8px 12px',
                borderRadius: '6px',
                background: link.active ? 'var(--primary)' : 'transparent',
                color: link.active ? 'white' : 'var(--text)',
                textDecoration: 'none',
              }}
            />
          ))}
        </div>
      )}
    </div>
  );
}