import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Dashboard() {
  const { props } = usePage();
  const { stats, proyectosRecientes, usuariosRecientes } = props;

  return (
    <div className="dashboard-admin">
      {/* Header */}
      <div className="admin-header-master">
        <div className="admin-header-icon">
          <i className="fas fa-shield-halved"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '20px' }}>
            <span className="admin-badge-hub">Admin Control Hub</span>
          </div>
          <h1 className="admin-header-title">
            Gestión Estratégica <span style={{ color: 'var(--primary)' }}>Global</span>
          </h1>
          <p>Control unificado sobre el banco de proyectos y el talento humano del ecosistema Sena.</p>
        </div>
      </div>

      {/* Stats Grid */}
      <div className="admin-stats-grid">
        <div className="stat-card-premium" style={{ padding: '28px', background: 'white', borderColor: 'var(--primary-soft)' }}>
          <div style={{ background: 'var(--primary-soft)', color: 'var(--primary)', marginBottom: '24px', width: '48px', height: '48px', borderRadius: '12px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <i className="fas fa-project-diagram"></i>
          </div>
          <div style={{ fontSize: '38px', color: 'var(--primary)', fontWeight: 800 }}>{stats?.proyectos}</div>
          <div style={{ fontSize: '11px', marginTop: '8px' }}>Banco de Proyectos</div>
          <div style={{ marginTop: '16px', width: 'fit-content', background: '#fef3c7', color: '#92400e', padding: '4px 12px', borderRadius: '20px', fontSize: '12px', fontWeight: 600 }}>
            <i className="fas fa-clock"></i> {stats?.pendientes} Pendientes
          </div>
        </div>

        <div className="stat-card-premium" style={{ padding: '28px', background: 'white' }}>
          <div style={{ background: '#f8fafc', color: '#64748b', marginBottom: '24px', width: '48px', height: '48px', borderRadius: '12px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <i className="fas fa-users"></i>
          </div>
          <div style={{ fontSize: '38px', color: 'var(--text)', fontWeight: 800 }}>{stats?.usuarios}</div>
          <div style={{ fontSize: '11px', marginTop: '8px' }}>Cuentas Totales</div>
        </div>

        <div className="stat-card-premium" style={{ padding: '28px', background: 'white' }}>
          <div style={{ background: '#eff6ff', color: '#3b82f6', marginBottom: '24px', width: '48px', height: '48px', borderRadius: '12px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <i className="fas fa-building"></i>
          </div>
          <div style={{ fontSize: '38px', color: '#2563eb', fontWeight: 800 }}>{stats?.empresas}</div>
          <div style={{ fontSize: '11px', marginTop: '8px' }}>Empresas Aliadas</div>
        </div>

        <div className="stat-card-premium" style={{ padding: '28px', background: 'white' }}>
          <div style={{ background: '#fdf2f8', color: '#db2777', marginBottom: '24px', width: '48px', height: '48px', borderRadius: '12px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <i className="fas fa-graduation-cap"></i>
          </div>
          <div style={{ fontSize: '38px', color: '#db2777', fontWeight: 800 }}>{stats?.aprendices}</div>
          <div style={{ fontSize: '11px', marginTop: '8px' }}>Aprendices</div>
        </div>

        <div className="stat-card-premium" style={{ padding: '28px', background: 'white' }}>
          <div style={{ background: '#fef3c7', color: '#d97706', marginBottom: '24px', width: '48px', height: '48px', borderRadius: '12px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <i className="fas fa-chalkboard-teacher"></i>
          </div>
          <div style={{ fontSize: '38px', color: '#d97706', fontWeight: 800 }}>{stats?.instructores}</div>
          <div style={{ fontSize: '11px', marginTop: '8px' }}>Instructores</div>
        </div>
      </div>

      {/* Proyectos Recientes */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', margin: '40px 0 28px' }}>
        <h3>
          <i className="fas fa-clock" style={{ color: '#3eb489' }}></i> Proyectos Recientes
        </h3>
        <Link href="/admin/proyectos" style={{ color: '#3eb489', fontWeight: 700 }}>
          Ver todos <i className="fas fa-arrow-right"></i>
        </Link>
      </div>

      <div className="instructor-projects-grid">
        {proyectosRecientes?.map((proyecto) => (
          <div key={proyecto.id} className="project-card">
            <div className="project-header">
              <span className="project-category">{proyecto.categoria}</span>
              <span className={`project-status status-${proyecto.estado}`}>{proyecto.estado}</span>
            </div>
            <h4>{proyecto.titulo}</h4>
            <div className="project-footer">
              <span><i className="fas fa-building"></i> {proyecto.empresa?. nombre}</span>
              <Link href={`/admin/proyectos/${proyecto.id}/revisar`}>
                Revisar <i className="fas fa-arrow-right"></i>
              </Link>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}