import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function DetalleProyecto() {
  const { props } = usePage();
  const { proyecto, etapas = [] } = props;

  const getStatusStyle = (estado) => {
    switch (estado) {
      case 'aprobado':
        return { bg: '#f0fdf4', border: '#bbf7d0', text: '#16a34a' };
      case 'pendiente':
        return { bg: '#fffbeb', border: '#fde68a', text: '#d97706' };
      default:
        return { bg: '#fef2f2', border: '#fecaca', text: '#ef4444' };
    }
  };

  const formatDate = (dateStr) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('es-ES', { year: 'numeric', month: '2-digit', day: '2-digit' });
  };

  if (!proyecto) {
    return (
      <div style={{ padding: '40px', textAlign: 'center' }}>
        <p>Cargando...</p>
      </div>
    );
  }

  const statusStyle = getStatusStyle(proyecto.estado);

  return (
    <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: '28px', paddingBottom: '40px', alignItems: 'start' }}>
      <div style={{ display: 'flex', flexDirection: 'column', gap: '24px' }}>
        <div style={{ background: 'white', borderRadius: '24px', overflow: 'hidden', boxShadow: 'var(--shadow)' }}>
          <div style={{ width: '100%', height: '240px', position: 'relative' }}>
            <img 
              src={proyecto.imagen_url || '/assets/proyecto_default.jpg'} 
              alt={proyecto.titulo} 
              style={{ width: '100%', height: '100%', objectFit: 'cover' }}
            />
            <div style={{ position: 'absolute', inset: 0, background: 'linear-gradient(0deg, rgba(0,0,0,0.8) 0%, transparent 60%)' }}></div>
            <div style={{ position: 'absolute', bottom: '20px', left: '24px' }}>
              <span style={{
                background: '#3eb489',
                color: 'white',
                padding: '6px 14px',
                borderRadius: '20px',
                fontSize: '11px',
                fontWeight: 800,
                textTransform: 'uppercase',
                marginBottom: '8px',
                display: 'inline-block'
              }}>
                {proyecto.categoria}
              </span>
              <h2 style={{ color: 'white', fontSize: '1.6rem', fontWeight: 800, textShadow: '0 2px 4px rgba(0,0,0,0.3)' }}>
                {proyecto.titulo}
              </h2>
            </div>
          </div>
          
          <div style={{ padding: '28px' }}>
            <h3 style={{ fontSize: '18px', fontWeight: 800, color: 'var(--text)', marginBottom: '16px' }}>
              Descripción de la Convocatoria
            </h3>
            <p style={{ color: 'var(--text-light)', lineHeight: 1.8, fontSize: '14px', fontWeight: 500 }}>
              {proyecto.descripcion}
            </p>
          </div>
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
          <div style={{ background: 'white', borderRadius: '24px', padding: '24px', boxShadow: 'var(--shadow)' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '14px', marginBottom: '16px' }}>
              <div style={{
                width: '44px',
                height: '44px',
                borderRadius: '12px',
                background: 'rgba(59,130,246,0.1)',
                color: '#3b82f6',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontSize: '18px'
              }}>
                <i className="fas fa-tools"></i>
              </div>
              <h4 style={{ fontWeight: 800, fontSize: '15px', color: 'var(--text)' }}>Requisitos Técnicos</h4>
            </div>
            <p style={{ color: 'var(--text-light)', fontSize: '13px', lineHeight: 1.6, fontWeight: 500 }}>
              {proyecto.requisitos_especificos || proyecto.requisitos || 'No especificado'}
            </p>
          </div>

          <div style={{ background: 'white', borderRadius: '24px', padding: '24px', boxShadow: 'var(--shadow)' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '14px', marginBottom: '16px' }}>
              <div style={{
                width: '44px',
                height: '44px',
                borderRadius: '12px',
                background: 'rgba(62,180,137,0.1)',
                color: '#3eb489',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontSize: '18px'
              }}>
                <i className="fas fa-lightbulb"></i>
              </div>
              <h4 style={{ fontWeight: 800, fontSize: '15px', color: 'var(--text)' }}>Habilidades Buscadas</h4>
            </div>
            <p style={{ color: 'var(--text-light)', fontSize: '13px', lineHeight: 1.6, fontWeight: 500 }}>
              {proyecto.habilidades_requeridas || proyecto.habilidades || 'No especificado'}
            </p>
          </div>
        </div>

        <div style={{ background: 'white', borderRadius: '24px', padding: '28px', boxShadow: 'var(--shadow)' }}>
          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '24px' }}>
            <h3 style={{ fontSize: '18px', fontWeight: 800, color: 'var(--text)' }}>
              <i className="fas fa-tasks" style={{ color: '#3eb489', marginRight: '10px' }}></i>
              Estructura del Proyecto
            </h3>
            <span style={{ fontSize: '12px', color: 'var(--text-light)', fontWeight: 700 }}>
              {etapas.length} Etapas Definidas
            </span>
          </div>

          <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
            {etapas.length > 0 ? etapas.map((etapa, index) => (
              <div key={etapa.id || index} style={{ display: 'flex', gap: '20px' }}>
                <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
                  <div style={{
                    width: '36px',
                    height: '36px',
                    borderRadius: '50%',
                    background: index === 0 ? 'linear-gradient(135deg, #3eb489, #2d9d74)' : '#f8fafc',
                    color: index === 0 ? 'white' : 'var(--text-light)',
                    border: `2px solid ${index === 0 ? '#3eb489' : '#e2e8f0'}`,
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    fontSize: '14px',
                    fontWeight: 800,
                    flexShrink: 0,
                    boxShadow: index === 0 ? '0 4px 12px rgba(62,180,137,0.3)' : 'none'
                  }}>
                    {index + 1}
                  </div>
                  {index < etapas.length - 1 && (
                    <div style={{ width: '2px', flex: 1, minHeight: '40px', background: '#e2e8f0', margin: '8px 0' }}></div>
                  )}
                </div>
                <div style={{ flex: 1, paddingBottom: '20px' }}>
                  <h5 style={{ fontWeight: 800, color: 'var(--text)', marginBottom: '4px', fontSize: '15px' }}>
                    {etapa.nombre}
                  </h5>
                  <p style={{ fontSize: '13px', color: 'var(--text-light)', lineHeight: 1.6 }}>
                    {etapa.descripcion}
                  </p>
                </div>
              </div>
            )) : (
              <div style={{ textAlign: 'center', padding: '40px', background: '#f8fafc', borderRadius: '16px', border: '2px dashed #e2e8f0' }}>
                <i className="fas fa-stream" style={{ fontSize: '32px', color: 'var(--text-lighter)', marginBottom: '12px' }}></i>
                <p style={{ color: 'var(--text-light)', fontWeight: 600 }}>
                  El instructor aún no ha definido las etapas de este proyecto.
                </p>
              </div>
            )}
          </div>
        </div>
      </div>

      <div style={{ display: 'flex', flexDirection: 'column', gap: '20px', position: 'sticky', top: '24px' }}>
        <div style={{ background: 'white', borderRadius: '24px', padding: '24px', boxShadow: 'var(--shadow)' }}>
          <div style={{ textAlign: 'center', marginBottom: '20px' }}>
            <p style={{ fontSize: '11px', textTransform: 'uppercase', letterSpacing: '1px', color: 'var(--text-light)', fontWeight: 800, marginBottom: '10px' }}>
              Estado Actual
            </p>
            <span style={{
              background: statusStyle.bg,
              border: `1px solid ${statusStyle.border}`,
              color: statusStyle.text,
              fontSize: '14px',
              padding: '8px 20px',
              borderRadius: '20px',
              fontWeight: 800
            }}>
              {proyecto.estado}
            </span>
          </div>
          
          <div style={{ display: 'grid', gap: '14px', borderTop: '1px solid #f1f5f9', paddingTop: '20px' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <span style={{ fontSize: '13px', color: 'var(--text-light)', fontWeight: 600 }}>Duración:</span>
              <span style={{ fontSize: '14px', fontWeight: 800, color: 'var(--text)' }}>{proyecto.duracion_estimada_dias || 180} días</span>
            </div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <span style={{ fontSize: '13px', color: 'var(--text-light)', fontWeight: 600 }}>Publicado:</span>
              <span style={{ fontSize: '14px', fontWeight: 800, color: 'var(--text)' }}>
                {formatDate(proyecto.fecha_publicacion)}
              </span>
            </div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <span style={{ fontSize: '13px', color: 'var(--text-light)', fontWeight: 600 }}>Cierre:</span>
              <span style={{ fontSize: '14px', fontWeight: 800, color: '#ef4444' }}>
                {formatDate(proyecto.fecha_finalizacion)}
              </span>
            </div>
          </div>
        </div>

        <div style={{ background: 'white', borderRadius: '24px', padding: '24px', boxShadow: 'var(--shadow)' }}>
          <h4 style={{ fontSize: '14px', fontWeight: 800, color: 'var(--text)', marginBottom: '16px' }}>
            <i className="fas fa-chalkboard-teacher" style={{ color: '#3eb489', marginRight: '8px' }}></i>
            Instructor Responsable
          </h4>
          {proyecto.nombres ? (
            <div style={{ display: 'flex', alignItems: 'center', gap: '14px' }}>
              <div style={{
                width: '48px',
                height: '48px',
                borderRadius: '14px',
                background: 'linear-gradient(135deg, #3eb489, #2d9d74)',
                color: 'white',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontWeight: 800,
                fontSize: '18px'
              }}>
                {proyecto.nombres.charAt(0)}
              </div>
              <div>
                <p style={{ fontSize: '14px', fontWeight: 800, color: 'var(--text)' }}>
                  {proyecto.nombres} {proyecto.apellidos}
                </p>
                <p style={{ fontSize: '12px', color: '#3eb489', fontWeight: 600 }}>Instructor SENA</p>
              </div>
            </div>
          ) : (
            <div style={{ display: 'flex', alignItems: 'center', gap: '12px', color: 'var(--text-light)', padding: '16px', background: '#f8fafc', borderRadius: '12px' }}>
              <i className="fas fa-user-clock" style={{ fontSize: '20px' }}></i>
              <p style={{ fontSize: '13px', fontWeight: 600 }}>Pendiente por asignar.</p>
            </div>
          )}
        </div>

        <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
          <Link
            href={`/empresa/proyectos/${proyecto.id}/editar`}
            style={{
              display: 'inline-flex',
              alignItems: 'center',
              justifyContent: 'center',
              gap: '10px',
              background: '#3b82f6',
              color: 'white',
              padding: '14px 20px',
              borderRadius: '12px',
              fontWeight: 600,
              fontSize: '14px',
              textDecoration: 'none'
            }}
          >
            <i className="fas fa-edit"></i> Editar Proyecto
          </Link>
          <Link
            href={`/empresa/proyectos/${proyecto.id}/postulantes`}
            style={{
              display: 'inline-flex',
              alignItems: 'center',
              justifyContent: 'center',
              gap: '10px',
              background: '#3eb489',
              color: 'white',
              padding: '14px 20px',
              borderRadius: '12px',
              fontWeight: 600,
              fontSize: '14px',
              textDecoration: 'none'
            }}
          >
            <i className="fas fa-users"></i> Ver Postulantes
          </Link>
        </div>
      </div>
    </div>
  );
}