import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Dashboard() {
  const { props } = usePage();
  const {
    instructor,
    proyectosAsignados,
    proyectos,
    totalAprendices,
    evidenciasPendientes,
    nuevasPostulaciones,
    proximoCierre
  } = props;

  return (
    <div className="dashboard-instructor">
      {/* Header */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-chalkboard-teacher"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '10px' }}>
            <span className="instructor-tag">Instructor Hub</span>
          </div>
          <h1 className="instructor-title">
            Centro de Mando del <span style={{ color: 'var(--primary)' }}>Instructor</span>
          </h1>
          <p>Tu centro de mando para la excelencia académica.</p>
        </div>
      </div>

      {/* Stats Grid */}
      <div className="instructor-stat-grid">
        {/* Large Stat Card */}
        <div className="instructor-stat-card-lg glass-card">
          <div className="instructor-stat-icon-main">
            <i className="fas fa-project-diagram"></i>
          </div>
          <div>
            <div style={{ fontSize: '44px', fontWeight: 800 }}>{proyectosAsignados}</div>
            <div style={{ fontSize: '14px', fontWeight: 700, textTransform: 'uppercase' }}>Proyectos Bajo tu Guía</div>
          </div>
        </div>

        {/* Warning Stat Card */}
        <div className="instructor-warning-card">
          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start' }}>
            <div style={{ width: '48px', height: '48px', borderRadius: '14px', background: 'rgba(255,255,255,0.2)', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-clock"></i>
            </div>
            <span style={{ fontSize: '10px', fontWeight: 800, background: 'rgba(255,255,255,0.2)', padding: '4px 10px', borderRadius: '20px' }}>ACCIÓN REQUERIDA</span>
          </div>
          <div style={{ marginTop: '24px' }}>
            <div style={{ fontSize: '36px', fontWeight: 800 }}>{evidenciasPendientes}</div>
            <div style={{ fontSize: '13px', fontWeight: 600, opacity: 0.9 }}>Evidencias sin calificar</div>
          </div>
        </div>

        {/* Success Stat Card */}
        <div className="glass-card">
          <div style={{ display: 'flex', flexDirection: 'column', justifyContent: 'space-between', borderRadius: 'var(--radius)', padding: '24px' }}>
            <div style={{ width: '48px', height: '48px', borderRadius: '14px', background: 'rgba(62,180,137,0.1)', color: '#3eb489', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '22px' }}>
              <i className="fas fa-user-graduate"></i>
            </div>
            <div style={{ marginTop: '24px' }}>
              <div style={{ fontSize: '36px', fontWeight: 800, color: 'var(--text)' }}>{totalAprendices}</div>
              <div style={{ fontSize: '13px', fontWeight: 600 }}>Aprendices Activos</div>
            </div>
          </div>
        </div>

        {/* Info Stat Card */}
        <div className="glass-card">
          <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
              <div style={{ width: '40px', height: '40px', borderRadius: '10px', background: 'rgba(59,130,246,0.1)', color: '#3b82f6', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                <i className="fas fa-bell"></i>
              </div>
              <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', color: 'var(--text-light)' }}>Nuevas Postulaciones</span>
            </div>
            <h4 style={{ fontSize: '28px', fontWeight: 800, color: 'var(--text)', margin: 0 }}>{nuevasPostulaciones}</h4>
          </div>
        </div>
      </div>

      {/* Projects Section */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', margin: '40px 0 28px' }}>
        <h3>
          <i className="fas fa-folder-open" style={{ color: '#3eb489' }}></i> Proyectos Asignados
        </h3>
        <Link href="/instructor/proyectos" style={{ color: '#3eb489', fontWeight: 700 }}>
          Ver todos <i className="fas fa-arrow-right"></i>
        </Link>
      </div>

      {/* Projects Grid */}
      <div className="instructor-projects-grid">
        {proyectos?.map((proyecto) => (
          <div key={proyecto.id} className="project-card">
            <div className="project-header">
              <span className="project-category">{proyecto.categoria}</span>
              <span className={`project-status status-${proyecto.estado}`}>{proyecto.estado}</span>
            </div>
            <h4>{proyecto.titulo}</h4>
            <p>{proyecto.descripcion}</p>
            <div className="project-footer">
              <span><i className="fas fa-building"></i> {proyecto.empresa?.nombre}</span>
              <Link href={`/instructor/proyectos/${proyecto.id}`}>
                Ver <i className="fas fa-arrow-right"></i>
              </Link>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}