import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Dashboard() {
  const { props } = usePage();
  const {
    aprendiz,
    totalPostulaciones,
    postulacionesAprobadas,
    proyectosDisponibles,
    proyectosRecientes,
    proyectosAprobados,
    proximoCierre
  } = props;

  return (
    <div className="dashboard-aprendiz">
      {/* Header */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-rocket"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '10px' }}>
            <span className="instructor-tag">Portal del Talento</span>
          </div>
          <h1>
            ¡Hola de nuevo, <span style={{ color: '#3eb489' }}>{aprendiz?.nombres}</span>!
          </h1>
          <p>Impulsa tu carrera colaborar en desafíos reales de la industria.</p>
        </div>
      </div>

      {/* Stats Grid */}
      <div className="instructor-stat-grid">
        <div className="glass-card" style={{ gridColumn: 'span 2' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '32px' }}>
            <div style={{ width: '80px', height: '80px', borderRadius: '24px', background: 'linear-gradient(135deg, #3eb489, #2d9d74)', color: 'white', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '32px' }}>
              <i className="fas fa-rocket"></i>
            </div>
            <div>
              <h3>{postulacionesAprobadas} Proyectos</h3>
              <p>En los que estás transformando el futuro.</p>
            </div>
          </div>
        </div>

        <div className="glass-card">
          <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
              <div style={{ width: '40px', height: '40px', borderRadius: '10px', background: 'rgba(239, 68, 68, 0.1)', color: '#ef4444', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                <i className="fas fa-clock"></i>
              </div>
              <span>Próximo Cierre</span>
            </div>
            <h4>{proximoCierre ? 'En curso' : 'Sin cierres'}</h4>
          </div>
        </div>

        <div className="glass-card">
          <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
              <div style={{ width: '40px', height: '40px', borderRadius: '10px', background: 'rgba(62,180,137,0.1)', color: '#3eb489', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                <i className="fas fa-paper-plane"></i>
              </div>
              <span>Actividad</span>
            </div>
            <h4>{totalPostulaciones}</h4>
            <p>Postulaciones enviadas</p>
          </div>
        </div>
      </div>

      {/* Projects Section */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', margin: '40px 0 28px' }}>
        <h3>
          <i className="fas fa-fire" style={{ color: '#f97316' }}></i> Oportunidades para ti
        </h3>
        <Link href="/aprendiz/proyectos" style={{ color: '#3eb489', fontWeight: 700 }}>
          Explorar todas <i className="fas fa-arrow-right"></i>
        </Link>
      </div>

      {/* Projects Grid */}
      <div className="instructor-projects-grid">
        {proyectosRecientes?.map((proyecto) => (
          <div key={proyecto.id} className="project-card">
            <div className="project-header">
              <span className="project-category">{proyecto.categoria}</span>
              <span className="project-status">{proyecto.estado}</span>
            </div>
            <h4>{proyecto.titulo}</h4>
            <p>{proyecto.descripcion}</p>
            <div className="project-footer">
              <span><i className="fas fa-building"></i> {proyecto.empresa?.nombre}</span>
              <Link href={`/aprendiz/proyectos/${proyecto.id}/detalle`}>
                Ver detalle <i className="fas fa-arrow-right"></i>
              </Link>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}