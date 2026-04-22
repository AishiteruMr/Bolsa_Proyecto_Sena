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
              background: '#f59e0b',
              color: 'white',
              padding: '8px 18px',
              borderRadius: '40px',
              fontSize: '11px',
              fontWeight: 800,
              textTransform: 'uppercase'
            }}>
              Proyectos Asignados
            </span>
          </div>
          <h2 style={{ color: 'white', fontSize: '38px', fontWeight: 800, marginBottom: '12px' }}>
            Mis Proyectos
          </h2>
          <p style={{ color: 'rgba(255,255,255,0.7)', fontSize: '16px', marginBottom: '40px', maxWidth: '600px' }}>
            Gestiona los proyectos que tienes asignados como instructor.
          </p>
        </div>
      </div>

      {/* Projects Grid */}
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(340px, 1fr))', gap: '24px' }}>
        {proyectos?.map((proyecto) => (
          <div key={proyecto.id} className="project-card" style={{ background: 'white', borderRadius: '20px', padding: '24px', boxShadow: 'var(--shadow)' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '16px' }}>
              <span style={{ background: 'rgba(245,158,11,0.1)', color: '#d97706', padding: '4px 12px', borderRadius: '20px', fontSize: '11px', fontWeight: 700, textTransform: 'uppercase' }}>
                {proyecto.categoria}
              </span>
              <span style={{
                padding: '4px 12px',
                borderRadius: '20px',
                fontSize: '11px',
                fontWeight: 700,
                background: proyecto.estado === 'en_progreso' ? '#dbeafe' : '#dcfce7',
                color: proyecto.estado === 'en_progreso' ? '#1e40af' : '#166534'
              }}>
                {proyecto.estado}
              </span>
            </div>

            <h3 style={{ fontSize: '20px', fontWeight: 800, marginBottom: '12px' }}>{proyecto.titulo}</h3>
            <p style={{ fontSize: '14px', color: 'var(--text-light)', marginBottom: '20px', lineHeight: 1.6 }}>
              {proyecto.descripcion}
            </p>

            <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '20px', fontSize: '13px', color: 'var(--text-light)' }}>
              <i className="fas fa-building"></i>
              <span>{proyecto.empresa?.nombre}</span>
            </div>

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <span style={{ fontSize: '13px', color: 'var(--text-light)' }}>
                <i className="fas fa-users"></i> {proyecto.postulaciones_count || 0} aprendices
              </span>
              <Link href={`/instructor/proyectos/${proyecto.id}`} style={{ color: '#d97706', fontWeight: 700 }}>
                Ver Detalle <i className="fas fa-arrow-right"></i>
              </Link>
            </div>
          </div>
        ))}
      </div>

      {proyectos?.length === 0 && (
        <div style={{ padding: '60px', textAlign: 'center', background: 'white', borderRadius: '24px' }}>
          <div style={{ fontSize: '48px', marginBottom: '16px', color: '#cbd5e1' }}>
            <i className="fas fa-folder-open"></i>
          </div>
          <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '8px' }}>No hay proyectos asignados</h3>
          <p style={{ color: 'var(--text-light)' }}>Contacta al administrador para que te asignen proyectos.</p>
        </div>
      )}
    </div>
  );
}