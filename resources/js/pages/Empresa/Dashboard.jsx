import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Dashboard() {
  const { props } = usePage();
  const {
    totalProyectos,
    proyectosActivos,
    totalPostulaciones,
    postulacionesPendientes,
    proyectosRecientes
  } = props;

  return (
    <div className="dashboard-empresa">
      {/* Header */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-building"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '12px' }}>
            <span className="instructor-tag">Portal Corporativo</span>
          </div>
          <h1 className="instructor-title">
            Panel de <span style={{ color: 'var(--primary)' }}>Empresa</span>
          </h1>
          <p>Impulsa la innovación y conecta con el mejor talento del SENA.</p>
        </div>
      </div>

      {/* Stats Grid */}
      <div className="instructor-stat-grid">
        <div className="glass-card">
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '14px', background: 'rgba(62,180,137,0.1)', color: '#3eb489', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-folder-plus"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800 }}>{totalProyectos}</div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Proyectos Totales</div>
            </div>
          </div>
        </div>

        <div className="glass-card">
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '14px', background: 'linear-gradient(135deg, #3eb489, #2d9d74)', color: 'white', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-check-double"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800, color: '#2d9d74' }}>{proyectosActivos}</div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>En Ejecución</div>
            </div>
          </div>
        </div>

        <div className="glass-card">
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '14px', background: '#eff6ff', color: '#3b82f6', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-user-graduate"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800, color: '#3b82f6' }}>{totalPostulaciones}</div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Postulaciones</div>
            </div>
          </div>
        </div>

        <div className="glass-card" style={{ background: 'linear-gradient(135deg, #f59e0b, #d97706)', border: 'none', color: 'white' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
            <div style={{ width: '52px', height: '52px', borderRadius: '14px', background: 'rgba(255,255,255,0.2)', color: 'white', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-clock"></i>
            </div>
            <div>
              <div style={{ fontSize: '32px', fontWeight: 800 }}>{postulacionesPendientes}</div>
              <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', opacity: 0.9 }}>Pendientes</div>
            </div>
          </div>
        </div>
      </div>

      {/* Projects Section */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', margin: '40px 0 28px' }}>
        <h3>
          <i className="fas fa-project-diagram" style={{ color: '#3eb489' }}></i> Mis Proyectos
        </h3>
        <Link href="/empresa/proyectos/crear" className="btn btn-primary">
          <i className="fas fa-plus"></i> Nuevo Proyecto
        </Link>
      </div>

      {/* Projects Grid */}
      <div className="instructor-projects-grid">
        {proyectosRecientes?.map((proyecto) => (
          <div key={proyecto.id} className="project-card">
            <div className="project-header">
              <span className="project-category">{proyecto.categoria}</span>
              <span className={`project-status status-${proyecto.estado}`}>{proyecto.estado}</span>
            </div>
            <h4>{proyecto.titulo}</h4>
            <p>{proyecto.descripcion}</p>
            <div className="project-footer">
              <span><i className="fas fa-users"></i> {proyecto.postulaciones_count || 0} postulaciones</span>
              <Link href={`/empresa/proyectos/${proyecto.id}/editar`}>
                Ver <i className="fas fa-arrow-right"></i>
              </Link>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}