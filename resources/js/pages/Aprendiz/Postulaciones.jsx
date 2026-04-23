import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Postulaciones() {
  const { props } = usePage();
  const { postulaciones } = props;

  const total = postulaciones?.data?.length || 0;
  const pendientes = postulaciones?.data?.filter(p => p.estado === 'pendiente').length || 0;
  const aprobadas = postulaciones?.data?.filter(p => p.estado === 'aprobada').length || 0;
  const rechazadas = postulaciones?.data?.filter(p => p.estado === 'rechazada').length || 0;

  return (
    <div style={{ paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-paper-plane"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
            <span className="instructor-tag">Postulaciones</span>
          </div>
          <h1 className="instructor-title">
            Mis <span style={{ color: 'var(--primary)' }}>Postulaciones</span>
          </h1>
          <p>Sigue el estado de tus aplicaciones a los diferentes proyectos.</p>
        </div>
      </div>

      {/* Stats */}
      <div className="instructor-stat-grid" style={{ marginBottom: '32px' }}>
        <div className="glass-card" style={{ padding: '24px' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '16px', background: 'rgba(62,180,137,0.1)', color: '#3eb489', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-inbox"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800 }}>{total}</div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Total</div>
            </div>
          </div>
        </div>

        <div className="glass-card" style={{ padding: '24px', borderColor: '#fde68a' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '16px', background: '#fffbeb', color: '#d97706', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-clock"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800, color: '#d97706' }}>{pendientes}</div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Pendientes</div>
            </div>
          </div>
        </div>

        <div className="glass-card" style={{ padding: '24px' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '16px', background: '#dcfce7', color: '#16a34a', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-check-circle"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800, color: '#16a34a' }}>{aprobadas}</div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Aprobadas</div>
            </div>
          </div>
        </div>

        <div className="glass-card" style={{ padding: '24px' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '16px', background: '#fee2e2', color: '#dc2626', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-times-circle"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800, color: '#dc2626' }}>{rechazadas}</div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Rechazadas</div>
            </div>
          </div>
        </div>
      </div>

      {/* List */}
      <div style={{ background: 'white', borderRadius: '24px', overflow: 'hidden', boxShadow: 'var(--shadow)' }}>
        {postulaciones?.data?.length > 0 ? (
          <table style={{ width: '100%', borderCollapse: 'collapse' }}>
            <thead>
              <tr style={{ background: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Proyecto</th>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Empresa</th>
                <th style={{ padding: '16px 24px', textAlign: 'center', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Estado</th>
                <th style={{ padding: '16px 24px', textAlign: 'right', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Fecha</th>
              </tr>
            </thead>
            <tbody>
              {postulaciones.data.map((postulacion) => (
                <tr key={postulacion.id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                  <td style={{ padding: '20px 24px' }}>
                    <div style={{ fontWeight: 700 }}>{postulacion.proyecto?.titulo}</div>
                  </td>
                  <td style={{ padding: '20px 24px', color: 'var(--text-light)' }}>
                    {postulacion.proyecto?.empresa?.nombre}
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'center' }}>
                    <span style={{
                      padding: '6px 14px',
                      borderRadius: '20px',
                      fontSize: '12px',
                      fontWeight: 600,
                      background: postulacion.estado === 'aprobada' ? '#dcfce7' : postulacion.estado === 'rechazada' ? '#fee2e2' : '#fef3c7',
                      color: postulacion.estado === 'aprobada' ? '#16a34a' : postulacion.estado === 'rechazada' ? '#dc2626' : '#d97706'
                    }}>
                      {postulacion.estado}
                    </span>
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'right', fontSize: '13px', color: 'var(--text-light)' }}>
                    {new Date(postulacion.fecha_postulacion).toLocaleDateString('es-CO')}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        ) : (
          <div style={{ padding: '60px', textAlign: 'center' }}>
            <div style={{ fontSize: '48px', marginBottom: '16px', color: '#cbd5e1' }}>
              <i className="fas fa-inbox"></i>
            </div>
            <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '8px' }}>No hay postulaciones</h3>
            <p style={{ color: 'var(--text-light)', marginBottom: '24px' }}>Explora proyectos y postúltate.</p>
            <Link href="/aprendiz/proyectos" className="btn btn-primary">
              Explorar Proyectos
            </Link>
          </div>
        )}
      </div>
    </div>
  );
}