import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Participantes() {
  const { props } = usePage();
  const { proyecto, aprendices } = props;

  return (
    <div style={{ paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-users"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
            <span className="instructor-tag">Participantes</span>
          </div>
          <h1 className="instructor-title">
            Integrantes: <span style={{ color: 'var(--primary)' }}>{proyecto?.titulo}</span>
          </h1>
          <p>Aprendices que participan en este proyecto.</p>
        </div>
      </div>

      {/* Grid */}
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(280px, 1fr))', gap: '20px' }}>
        {aprendices?.map((apr) => (
          <div key={apr.apr_id} style={{ background: 'white', borderRadius: '20px', padding: '24px', boxShadow: 'var(--shadow)' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '16px' }}>
              <div style={{
                width: '56px',
                height: '56px',
                borderRadius: '50%',
                background: 'linear-gradient(135deg, #3eb489, #2d9d74)',
                color: 'white',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontSize: '20px',
                fontWeight: 700
              }}>
                {(apr.apr_nombre || 'A').charAt(0)}
              </div>
              <div>
                <div style={{ fontWeight: 700, fontSize: '16px' }}>{apr.apr_nombre} {apr.apr_apellido}</div>
                <div style={{ fontSize: '13px', color: 'var(--text-light)' }}>{apr.usr_correo}</div>
              </div>
            </div>
            <div style={{ background: '#f8fafc', borderRadius: '12px', padding: '12px' }}>
              <div style={{ fontSize: '12px', color: 'var(--text-light)', marginBottom: '4px' }}>Programa</div>
              <div style={{ fontWeight: 600, fontSize: '14px' }}>{apr.apr_programa}</div>
            </div>
          </div>
        ))}

        {aprendices?.length === 0 && (
          <div style={{ gridColumn: '1 / -1', padding: '60px', textAlign: 'center', background: 'white', borderRadius: '24px' }}>
            <div style={{ fontSize: '48px', marginBottom: '16px', color: '#cbd5e1' }}>
              <i className="fas fa-users"></i>
            </div>
            <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '8px' }}>Sin participantes</h3>
            <p style={{ color: 'var(--text-light)' }}>No hay aprendices aceptados en este proyecto.</p>
          </div>
        )}
      </div>
    </div>
  );
}