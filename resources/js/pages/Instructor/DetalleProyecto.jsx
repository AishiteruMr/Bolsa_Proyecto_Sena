import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function DetalleProyecto() {
  const { props } = usePage();
  const { proyecto, etapas, postulaciones, integrantes } = props;

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
            <span style={{
              padding: '6px 14px',
              borderRadius: '20px',
              fontSize: '11px',
              fontWeight: 700,
              background: proyecto?.estado === 'en_progreso' ? '#dbeafe' : '#dcfce7',
              color: proyecto?.estado === 'en_progreso' ? '#1e40af' : '#166534'
            }}>
              {proyecto?.estado}
            </span>
          </div>
          <h1 className="instructor-title">
            {proyecto?.titulo}
          </h1>
          <p>
            <i className="fas fa-building" style={{ marginRight: '8px' }}></i>
            {proyecto?.empresa?.nombre}
          </p>
        </div>
      </div>

      {/* Grid */}
      <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '24px', marginBottom: '32px' }}>
        <div style={{ background: 'white', borderRadius: '20px', padding: '24px', boxShadow: 'var(--shadow)' }}>
          <h3 style={{ fontSize: '18px', fontWeight: 700, marginBottom: '16px' }}>Descripción</h3>
          <p style={{ color: 'var(--text-light)', lineHeight: 1.7 }}>{proyecto?.descripcion}</p>
        </div>
        <div style={{ background: 'white', borderRadius: '20px', padding: '24px', boxShadow: 'var(--shadow)' }}>
          <h3 style={{ fontSize: '18px', fontWeight: 700, marginBottom: '16px' }}>Requisitos</h3>
          <p style={{ color: 'var(--text-light)', lineHeight: 1.7 }}>{proyecto?.requisitos}</p>
        </div>
      </div>

      {/* Etapas */}
      <div style={{ background: 'white', borderRadius: '24px', padding: '32px', boxShadow: 'var(--shadow)', marginBottom: '24px' }}>
        <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '24px' }}>
          <i className="fas fa-tasks" style={{ marginRight: '12px', color: 'var(--primary)' }}></i>
          Etapas
        </h3>
        <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
          {etapas?.map((etapa, i) => (
            <div key={etapa.id} style={{
              display: 'flex',
              alignItems: 'center',
              gap: '16px',
              padding: '16px',
              background: '#f8fafc',
              borderRadius: '12px'
            }}>
              <div style={{
                width: '36px',
                height: '36px',
                borderRadius: '10px',
                background: 'var(--primary)',
                color: 'white',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontWeight: 700,
                fontSize: '14px'
              }}>
                {i + 1}
              </div>
              <div>
                <div style={{ fontWeight: 600 }}>{etapa.nombre}</div>
                <div style={{ fontSize: '13px', color: 'var(--text-light)' }}>{etapa.descripcion}</div>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Integrantes */}
      <div style={{ background: 'white', borderRadius: '24px', padding: '32px', boxShadow: 'var(--shadow)' }}>
        <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '24px' }}>
          <i className="fas fa-users" style={{ marginRight: '12px', color: 'var(--primary)' }}></i>
          Integrantes ({integrantes?.length || 0})
        </h3>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(250px, 1fr))', gap: '16px' }}>
          {integrantes?.map((int) => (
            <div key={int.id} style={{
              display: 'flex',
              alignItems: 'center',
              gap: '12px',
              padding: '16px',
              background: '#f8fafc',
              borderRadius: '12px'
            }}>
              <div style={{
                width: '40px',
                height: '40px',
                borderRadius: '50%',
                background: 'var(--primary)',
                color: 'white',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontWeight: 700
              }}>
                {int.aprendiz?.nombres?.charAt(0)}
              </div>
              <div>
                <div style={{ fontWeight: 600 }}>{int.aprendiz?.nombres} {int.aprendiz?.apellidos}</div>
                <div style={{ fontSize: '12px', color: 'var(--text-light)' }}>{int.aprendiz?.programa_formacion}</div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}