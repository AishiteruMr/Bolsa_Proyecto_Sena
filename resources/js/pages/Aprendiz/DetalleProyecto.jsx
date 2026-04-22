import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function DetalleProyecto() {
  const { props } = usePage();
  const { proyecto, etapas, evidencias, aprendiz } = props;

  return (
    <div style={{ paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-project-diagram"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
            <span className="instructor-tag">{proyecto?.categoria}</span>
          </div>
          <h1 className="instructor-title">
            {proyecto?.titulo}
          </h1>
          <p>
            <i className="fas fa-building" style={{ marginRight: '8px' }}></i>
            {proyecto?.emp_nombre}
          </p>
        </div>
      </div>

      {/* Info */}
      <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '24px', marginBottom: '32px' }}>
        <div style={{ background: 'white', borderRadius: '20px', padding: '24px', boxShadow: 'var(--shadow)' }}>
          <h3 style={{ fontSize: '18px', fontWeight: 700, marginBottom: '16px' }}>Descripción</h3>
          <p style={{ color: 'var(--text-light)', lineHeight: 1.7 }}>{proyecto?.descripcion}</p>
        </div>
        <div style={{ background: 'white', borderRadius: '20px', padding: '24px', boxShadow: 'var(--shadow)' }}>
          <h3 style={{ fontSize: '18px', fontWeight: 700, marginBottom: '16px' }}>Instructor</h3>
          <p style={{ fontWeight: 600 }}>{proyecto?.instructor_nombre}</p>
        </div>
      </div>

      {/* Etapas */}
      <div style={{ background: 'white', borderRadius: '24px', padding: '32px', boxShadow: 'var(--shadow)' }}>
        <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '24px' }}>
          <i className="fas fa-tasks" style={{ marginRight: '12px', color: 'var(--primary)' }}></i>
          Etapas del Proyecto
        </h3>

        <div style={{ display: 'flex', flexDirection: 'column', gap: '16px' }}>
          {etapas?.map((etapa, i) => {
            const evidencia = evidencias?.find(e => e.etapa_id === etapa.id);
            return (
              <div key={etapa.id} style={{
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'space-between',
                padding: '20px',
                background: evidencia?.estado === 'aprobada' ? '#dcfce7' : evidencia?.estado === 'rechazada' ? '#fee2e2' : '#f8fafc',
                borderRadius: '16px',
                border: '1px solid #e2e8f0'
              }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: '16px' }}>
                  <div style={{
                    width: '40px',
                    height: '40px',
                    borderRadius: '12px',
                    background: 'var(--primary)',
                    color: 'white',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    fontWeight: 700
                  }}>
                    {i + 1}
                  </div>
                  <div>
                    <div style={{ fontWeight: 700 }}>{etapa.nombre}</div>
                    <div style={{ fontSize: '13px', color: 'var(--text-light)' }}>{etapa.descripcion}</div>
                  </div>
                </div>
                <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                  {evidencia ? (
                    <span style={{
                      padding: '8px 16px',
                      borderRadius: '20px',
                      fontSize: '12px',
                      fontWeight: 600,
                      background: evidencia.estado === 'aprobada' ? '#16a34a' : evidencia.estado === 'rechazada' ? '#dc2626' : '#d97706',
                      color: 'white'
                    }}>
                      {evidencia.estado}
                    </span>
                  ) : (
                    <form method="POST" action={`/aprendiz/proyectos/${proyecto.id}/etapas/${etapa.id}/evidencia`} encType="multipart/form-data" style={{ display: 'flex', gap: '8px' }}>
                      <input type="hidden" name="_token" value={props.csrf} />
                      <input type="file" name="archivo" required style={{ fontSize: '13px' }} />
                      <button type="submit" className="btn btn-primary" style={{ padding: '10px 16px', fontSize: '13px' }}>
                        <i className="fas fa-upload"></i> Entregar
                      </button>
                    </form>
                  )}
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );
}