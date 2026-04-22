import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Proyectos() {
  const { props } = usePage();
  const { proyectos } = props;

  return (
    <div style={{ maxWidth: '1200px', margin: '0 auto', paddingBottom: '60px' }}>
      {/* Header */}
      <div style={{
        background: 'linear-gradient(135deg, #0a1a15 0%, #1a2e28 100%)',
        borderRadius: '32px',
        padding: '60px 48px',
        marginBottom: '40px',
        position: 'relative'
      }}>
        <div style={{ position: 'relative', zIndex: 1 }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '16px' }}>
            <span style={{
              background: '#8b5cf6',
              color: 'white',
              padding: '8px 18px',
              borderRadius: '40px',
              fontSize: '11px',
              fontWeight: 800,
              textTransform: 'uppercase'
            }}>
              Banco de Proyectos
            </span>
          </div>
          <h2 style={{ color: 'white', fontSize: '38px', fontWeight: 800, marginBottom: '12px' }}>
            Gestión de Proyectos
          </h2>
          <p style={{ color: 'rgba(255,255,255,0.7)', fontSize: '16px', marginBottom: '40px', maxWidth: '600px' }}>
            Revisa, aprueba y gestiona todos los proyectos del sistema.
          </p>
        </div>
      </div>

      {/* Projects Table */}
      <div style={{ background: 'white', borderRadius: '24px', overflow: 'hidden', boxShadow: 'var(--shadow)' }}>
        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
          <thead>
            <tr style={{ background: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
              <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Proyecto</th>
              <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Empresa</th>
              <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Estado</th>
              <th style={{ padding: '16px 24px', textAlign: 'center', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Postulaciones</th>
              <th style={{ padding: '16px 24px', textAlign: 'right', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Acciones</th>
            </tr>
          </thead>
          <tbody>
            {proyectos?.map((proyecto) => (
              <tr key={proyecto.id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                <td style={{ padding: '20px 24px' }}>
                  <div style={{ fontWeight: 700, fontSize: '16px', marginBottom: '4px' }}>{proyecto.titulo}</div>
                  <div style={{ fontSize: '13px', color: 'var(--text-light)' }}>{proyecto.categoria}</div>
                </td>
                <td style={{ padding: '20px 24px' }}>
                  <span style={{ fontSize: '14px' }}>{proyecto.empresa?.nombre}</span>
                </td>
                <td style={{ padding: '20px 24px' }}>
                  <span style={{
                    padding: '6px 14px',
                    borderRadius: '20px',
                    fontSize: '12px',
                    fontWeight: 600,
                    background: proyecto.estado === 'aprobado' ? '#dcfce7' : proyecto.estado === 'pendiente' ? '#fef3c7' : '#dbeafe',
                    color: proyecto.estado === 'aprobado' ? '#166534' : proyecto.estado === 'pendiente' ? '#92400e' : '#1e40af'
                  }}>
                    {proyecto.estado}
                  </span>
                </td>
                <td style={{ padding: '20px 24px', textAlign: 'center' }}>
                  <span style={{ fontWeight: 700, fontSize: '18px' }}>{proyecto.postulaciones_count || 0}</span>
                </td>
                <td style={{ padding: '20px 24px', textAlign: 'right' }}>
                  <Link href={`/admin/proyectos/${proyecto.id}/revisar`} style={{
                    padding: '8px 16px',
                    borderRadius: '10px',
                    background: '#8b5cf6',
                    color: 'white',
                    fontSize: '13px',
                    fontWeight: 600,
                    textDecoration: 'none'
                  }}>
                    <i className="fas fa-eye"></i> Revisar
                  </Link>
                </td>
              </tr>
            ))}
          </tbody>
        </table>

        {proyectos?.length === 0 && (
          <div style={{ padding: '60px', textAlign: 'center' }}>
            <div style={{ fontSize: '48px', marginBottom: '16px', color: '#cbd5e1' }}>
              <i className="fas fa-folder-open"></i>
            </div>
            <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '8px' }}>No hay proyectos</h3>
            <p style={{ color: 'var(--text-light)' }}>No hay proyectos en el sistema aún.</p>
          </div>
        )}
      </div>
    </div>
  );
}