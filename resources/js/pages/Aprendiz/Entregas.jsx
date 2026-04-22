import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Entregas() {
  const { props } = usePage();
  const { proyectos, evidencias } = props;

  return (
    <div style={{ paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-tasks"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
            <span className="instructor-tag">Mis Entregas</span>
          </div>
          <h1 className="instructor-title">
            Mis <span style={{ color: 'var(--primary)' }}>Entregas</span>
          </h1>
          <p>Sube tus evidencias y sigue el estado de tus entregas.</p>
        </div>
      </div>

      {/* Stats */}
      <div className="instructor-stat-grid" style={{ marginBottom: '32px' }}>
        <div className="glass-card" style={{ padding: '24px' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '16px', background: 'rgba(62,180,137,0.1)', color: '#3eb489', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-project-diagram"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800 }}>{proyectos?.length || 0}</div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Proyectos</div>
            </div>
          </div>
        </div>

        <div className="glass-card" style={{ padding: '24px' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '16px', background: '#dcfce7', color: '#16a34a', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-check"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800, color: '#16a34a' }}>
                {evidencias?.filter(e => e.estado === 'aprobada').length || 0}
              </div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Aprobadas</div>
            </div>
          </div>
        </div>

        <div className="glass-card" style={{ padding: '24px' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '16px', background: '#fef3c7', color: '#d97706', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-clock"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800, color: '#d97706' }}>
                {evidencias?.filter(e => e.estado === 'pendiente').length || 0}
              </div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Pendientes</div>
            </div>
          </div>
        </div>

        <div className="glass-card" style={{ padding: '24px' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '16px', background: '#fee2e2', color: '#dc2626', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-times"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800, color: '#dc2626' }}>
                {evidencias?.filter(e => e.estado === 'rechazada').length || 0}
              </div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Rechazadas</div>
            </div>
          </div>
        </div>
      </div>

      {/* Evidencias List */}
      <div style={{ background: 'white', borderRadius: '24px', overflow: 'hidden', boxShadow: 'var(--shadow)' }}>
        {evidencias?.length > 0 ? (
          <table style={{ width: '100%', borderCollapse: 'collapse' }}>
            <thead>
              <tr style={{ background: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Proyecto</th>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Etapa</th>
                <th style={{ padding: '16px 24px', textAlign: 'center', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Estado</th>
                <th style={{ padding: '16px 24px', textAlign: 'right', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Fecha</th>
              </tr>
            </thead>
            <tbody>
              {evidencias.map((ev) => (
                <tr key={ev.id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                  <td style={{ padding: '20px 24px' }}>
                    <div style={{ fontWeight: 700 }}>{ev.proyecto?.titulo}</div>
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
                  <td style={{ padding: '20px 24px', textAlign: 'right', fontSize: '13px', color: 'var(--text-light)' }}>
                    {new Date(ev.fecha_envio).toLocaleDateString('es-CO')}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        ) : (
          <div style={{ padding: '60px', textAlign: 'center' }}>
            <div style={{ fontSize: '48px', marginBottom: '16px', color: '#cbd5e1' }}>
              <i className="fas fa-tasks"></i>
            </div>
            <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '8px' }}>No hay entregas</h3>
            <p style={{ color: 'var(--text-light)' }}>Aún no has enviado ninguna evidencia.</p>
          </div>
        )}
      </div>
    </div>
  );
}