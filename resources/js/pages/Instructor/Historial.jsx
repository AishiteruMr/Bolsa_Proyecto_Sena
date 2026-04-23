import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Historial() {
  const { props } = usePage();
  const { proyectos } = props;

  return (
    <div style={{ paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-history"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
            <span className="instructor-tag">Historial</span>
          </div>
          <h1 className="instructor-title">
            Mi <span style={{ color: 'var(--primary)' }}>Historial</span>
          </h1>
          <p>Revisa todos los proyectos que has guiado.</p>
        </div>
      </div>

      {/* Table */}
      <div style={{ background: 'white', borderRadius: '24px', overflow: 'hidden', boxShadow: 'var(--shadow)' }}>
        {proyectos?.length > 0 ? (
          <table style={{ width: '100%', borderCollapse: 'collapse' }}>
            <thead>
              <tr style={{ background: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Proyecto</th>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Empresa</th>
                <th style={{ padding: '16px 24px', textAlign: 'center', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Estado</th>
                <th style={{ padding: '16px 24px', textAlign: 'center', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Aprendices</th>
                <th style={{ padding: '16px 24px', textAlign: 'right', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Acciones</th>
              </tr>
            </thead>
            <tbody>
              {proyectos.map((p) => (
                <tr key={p.id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                  <td style={{ padding: '20px 24px' }}>
                    <div style={{ fontWeight: 700 }}>{p.titulo}</div>
                    <div style={{ fontSize: '12px', color: 'var(--text-light)' }}>{p.categoria}</div>
                  </td>
                  <td style={{ padding: '20px 24px' }}>
                    {p.nombre}
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'center' }}>
                    <span style={{
                      padding: '6px 14px',
                      borderRadius: '20px',
                      fontSize: '12px',
                      fontWeight: 600,
                      background: p.estado === 'aprobado' ? '#dcfce7' : p.estado === 'en_progreso' ? '#dbeafe' : '#fef3c7',
                      color: p.estado === 'aprobado' ? '#16a34a' : p.estado === 'en_progreso' ? '#1e40af' : '#d97706'
                    }}>
                      {p.estado}
                    </span>
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'center' }}>
                    <span style={{ fontWeight: 600 }}>{p.aprendices_aprobados}</span>
                    <span style={{ color: 'var(--text-light)', fontSize: '12px' }}> / {p.total_aprendices}</span>
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'right' }}>
                    <Link href={`/instructor/proyectos/${p.id}`} style={{ color: 'var(--primary)', fontWeight: 600 }}>
                      Ver <i className="fas fa-arrow-right"></i>
                    </Link>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        ) : (
          <div style={{ padding: '60px', textAlign: 'center' }}>
            <div style={{ fontSize: '48px', marginBottom: '16px', color: '#cbd5e1' }}>
              <i className="fas fa-history"></i>
            </div>
            <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '8px' }}>Sin historial</h3>
            <p style={{ color: 'var(--text-light)' }}>No has guiado proyectos aún.</p>
          </div>
        )}
      </div>
    </div>
  );
}