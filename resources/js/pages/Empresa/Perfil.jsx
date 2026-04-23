import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function Perfil() {
  const { props } = usePage();
  const { empresa } = props;
  const { data, setData, put, errors } = useForm({
    nombre_empresa: empresa?.nombre || '',
    representante: empresa?.representante || '',
    password: '',
    password_confirmation: ''
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    put('/empresa/perfil');
  };

  return (
    <div style={{ maxWidth: '1100px', margin: '0 auto', paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero" style={{ padding: '48px' }}>
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-building"></i>
        </div>
        <div style={{ display: 'flex', alignItems: 'center', gap: '32px' }}>
          <div style={{
            width: '96px',
            height: '96px',
            borderRadius: '50%',
            background: 'rgba(255,255,255,0.18)',
            border: '3px solid rgba(255,255,255,0.3)',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            fontSize: '40px',
            fontWeight: 900,
            color: 'white',
            flexShrink: 0
          }}>
            {(empresa?.nombre || 'E').charAt(0).toUpperCase()}
          </div>
          <div style={{ flex: 1 }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '12px' }}>
              <span className="instructor-tag">Perfil de Empresa</span>
            </div>
            <h1 className="instructor-title">
              <span style={{ color: 'var(--primary)' }}>{empresa?.nombre}</span>
            </h1>
            <p style={{ fontSize: '15px', color: 'rgba(255,255,255,0.7)' }}>
              <i className="fas fa-id-card" style={{ marginRight: '8px' }}></i>
              NIT: {empresa?.nit}
            </p>
          </div>
        </div>
      </div>

      {/* Form */}
      <div style={{ background: 'white', borderRadius: '24px', padding: '40px', boxShadow: 'var(--shadow)' }}>
        <h2 style={{ fontSize: '24px', fontWeight: 800, marginBottom: '32px' }}>Editar Perfil</h2>

        {Object.keys(errors).length > 0 && (
          <div className="alert alert-error">
            {Object.values(errors).map((error, i) => <span key={i}>{error}</span>)}
          </div>
        )}

        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label>Nombre de la Empresa</label>
            <div className="input-wrapper">
              <i className="fas fa-building"></i>
              <input
                type="text"
                value={data.nombre_empresa}
                onChange={(e) => setData('nombre_empresa', e.target.value)}
              />
            </div>
          </div>

          <div className="form-group">
            <label>Representante Legal</label>
            <div className="input-wrapper">
              <i className="fas fa-user-tie"></i>
              <input
                type="text"
                value={data.representante}
                onChange={(e) => setData('representante', e.target.value)}
              />
            </div>
          </div>

          <div style={{ borderTop: '1px solid #e2e8f0', margin: '32px 0', paddingTop: '32px' }}>
            <h3 style={{ fontSize: '18px', fontWeight: 700, marginBottom: '20px' }}>Cambiar Contraseña (opcional)</h3>
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '24px' }}>
              <div className="form-group">
                <label>Nueva Contraseña</label>
                <div className="input-wrapper">
                  <i className="fas fa-lock"></i>
                  <input
                    type="password"
                    value={data.password}
                    onChange={(e) => setData('password', e.target.value)}
                  />
                </div>
              </div>
              <div className="form-group">
                <label>Confirmar Contraseña</label>
                <div className="input-wrapper">
                  <i className="fas fa-lock"></i>
                  <input
                    type="password"
                    value={data.password_confirmation}
                    onChange={(e) => setData('password_confirmation', e.target.value)}
                  />
                </div>
              </div>
            </div>
          </div>

          <button type="submit" className="btn btn-primary">
            <i className="fas fa-save"></i> Guardar Cambios
          </button>
        </form>
      </div>
    </div>
  );
}