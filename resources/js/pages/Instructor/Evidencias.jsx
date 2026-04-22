import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Evidencias() {
  const { props } = usePage();
  const { proyecto, evidencias } = props;

  return (
    <div style={{ paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-file-alt"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
            <span className="instructor-tag">Evidencias</span>
          </div>
          <h1 className="instructor-title">
            Evidencias: <span style={{ color: 'var(--primary)' }}>{proyecto?.titulo}</span>
          </h1>
          <p>Revisa y califica las evidencias de los aprendices.</p>
        </div>
      </div>

      {/* Table */}
      <div style={{ background: 'white', borderRadius: '24px', overflow: 'hidden', boxShadow: 'var(--shadow)' }}>
        {evidencias?.length > 0 ? (
          <table style={{ width: '100%', borderCollapse: 'collapse' }}>
            <thead>
              <tr style={{ background: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Aprendiz</th>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Etapa</th>
                <th style={{ padding: '16px 24px', textAlign: 'center', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Estado</th>
                <th style={{ padding: '16px 24px', textAlign: 'right', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Acciones</th>
              </tr>
            </thead>
            <tbody>
              {evidencias.map((ev) => (
                <tr key={ev.id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                  <td style={{ padding: '20px 24px' }}>
                    <div style={{ fontWeight: 600 }}>{ev.aprendiz?.nombres} {ev.aprendiz?.apellidos}</div>
                    <div style={{ fontSize: '12px', color: 'var(--text-light)' }}>{ev.aprendiz?.usuario?.correo}</div>
                  </td>
                  <td style={{ padding: '20px 24px' }}>
                    {ev.etapa?.nombre}
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'center' }}>
                    <span style={{
                      padding: '6px 14px',
                      borderRadius: '20px',
                      fontSize: '12px',
                      fontWeight: 600,
                      background: ev.estado === 'aprobada' ? '#dcfce7' : ev.estado === 'rechazada' ? '#fee2e2' : '#fef3c7',
                      color: ev.estado === 'aprobada' ? '#16a34a' : ev.estado === 'rechazada' ? '#dc2626' : '#d97706'
                    }}>
                      {ev.estado}
                    </span>
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'right' }}>
                    {ev.estado === 'pendiente' && (
                      <div style={{ display: 'flex', gap: '8px', justifyContent: 'flex-end' }}>
                        <form method="POST" action={`/instructor/evidencias/${ev.id}`}>
                          <input type="hidden" name="_token" value={props.csrf} />
                          <input type="hidden" name="estado" value="aprobada" />
                          <button type="submit" style={{ padding: '8px 12px', borderRadius: '8px', background: '#dcfce7', color: '#16a34a', border: 'none', fontWeight: 600, cursor: 'pointer' }}>
                            <i className="fas fa-check"></i>
                          </button>
                        </form>
                        <form method="POST" action={`/instructor/evidencias/${ev.id}`}>
                          <input type="hidden" name="_token" value={props.csrf} />
                          <input type="hidden" name="estado" value="rechazada" />
                          <button type="submit" style={{ padding: '8px 12px', borderRadius: '8px', background: '#fee2e2', color: '#dc2626', border: 'none', fontWeight: 600, cursor: 'pointer' }}>
                            <i className="fas fa-times"></i>
                          </button>
                        </form>
                      </div>
                    )}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        ) : (
          <div style={{ padding: '60px', textAlign: 'center' }}>
            <div style={{ fontSize: '48px', marginBottom: '16px', color: '#cbd5e1' }}>
              <i className="fas fa-file-alt"></i>
            </div>
            <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '8px' }}>Sin evidencias</h3>
            <p style={{ color: 'var(--text-light)' }}>No hay evidencias enviadas aún.</p>
          </div>
        )}
      </div>
    </div>
  );
}