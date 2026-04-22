import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Postulantes() {
  const { props } = usePage();
  const { proyecto, postulantes } = props;

  return (
    <div style={{ paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-users"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
            <span className="instructor-tag">Postulantes</span>
          </div>
          <h1 className="instructor-title">
            Postulantes: <span style={{ color: 'var(--primary)' }}>{proyecto?.titulo}</span>
          </h1>
          <p>Gestiona las postulaciones de tus aprendices.</p>
        </div>
      </div>

      {/* Table */}
      <div style={{ background: 'white', borderRadius: '24px', overflow: 'hidden', boxShadow: 'var(--shadow)' }}>
        {postulantes?.length > 0 ? (
          <table style={{ width: '100%', borderCollapse: 'collapse' }}>
            <thead>
              <tr style={{ background: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Aprendiz</th>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Programa</th>
                <th style={{ padding: '16px 24px', textAlign: 'center', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Estado</th>
                <th style={{ padding: '16px 24px', textAlign: 'right', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Acciones</th>
              </tr>
            </thead>
            <tbody>
              {postulantes.map((p) => (
                <tr key={p.pos_id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                  <td style={{ padding: '20px 24px' }}>
                    <div style={{ fontWeight: 700 }}>{p.apr_nombre} {p.apr_apellido}</div>
                    <div style={{ fontSize: '13px', color: 'var(--text-light)' }}>{p.usr_correo}</div>
                  </td>
                  <td style={{ padding: '20px 24px' }}>
                    {p.apr_programa}
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'center' }}>
                    <span style={{
                      padding: '6px 14px',
                      borderRadius: '20px',
                      fontSize: '12px',
                      fontWeight: 600,
                      background: p.pos_estado === 'aprobada' ? '#dcfce7' : p.pos_estado === 'rechazada' ? '#fee2e2' : '#fef3c7',
                      color: p.pos_estado === 'aprobada' ? '#16a34a' : p.pos_estado === 'rechazada' ? '#dc2626' : '#d97706'
                    }}>
                      {p.pos_estado}
                    </span>
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'right' }}>
                    <form method="POST" action={`/empresa/postulaciones/${p.pos_id}/estado`} style={{ display: 'inline-flex', gap: '8px' }}>
                      <input type="hidden" name="_token" value={props.csrf} />
                      <input type="hidden" name="estado" value="aprobada" />
                      <button type="submit" style={{
                        padding: '8px 16px',
                        borderRadius: '10px',
                        background: '#dcfce7',
                        color: '#16a34a',
                        border: 'none',
                        fontWeight: 600,
                        cursor: 'pointer'
                      }}>
                        <i className="fas fa-check"></i> Aprobar
                      </button>
                    </form>
                    <form method="POST" action={`/empresa/postulaciones/${p.pos_id}/estado`} style={{ display: 'inline-flex', gap: '8px' }}>
                      <input type="hidden" name="_token" value={props.csrf} />
                      <input type="hidden" name="estado" value="rechazada" />
                      <button type="submit" style={{
                        padding: '8px 16px',
                        borderRadius: '10px',
                        background: '#fee2e2',
                        color: '#dc2626',
                        border: 'none',
                        fontWeight: 600,
                        cursor: 'pointer'
                      }}>
                        <i className="fas fa-times"></i> Rechazar
                      </button>
                    </form>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        ) : (
          <div style={{ padding: '60px', textAlign: 'center' }}>
            <div style={{ fontSize: '48px', marginBottom: '16px', color: '#cbd5e1' }}>
              <i className="fas fa-users"></i>
            </div>
            <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '8px' }}>No hay postulantes</h3>
            <p style={{ color: 'var(--text-light)' }}>Aún no hay postulaciones para este proyecto.</p>
          </div>
        )}
      </div>
    </div>
  );
}