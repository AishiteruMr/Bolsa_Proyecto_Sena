import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function Perfil() {
  const { props } = usePage();
  const { aprender, usuario } = props;
  const { data, setData, put, errors } = useForm({
    nombre: aprender?.nombres || '',
    apellido: aprender?.apellidos || '',
    programa: aprender?.programa_formacion || '',
    password: '',
    password_confirmation: ''
  });

  const camposCompletos = [
    aprender?.nombres,
    aprender?.apellidos,
    aprender?.programa_formacion,
    usuario?.correo
  ].filter(Boolean).length;
  const progresoPerfil = (camposCompletos / 4) * 100;

  const handleSubmit = (e) => {
    e.preventDefault();
    put('/aprendiz/perfil');
  };

  return (
    <div style={{ maxWidth: '1100px', margin: '0 auto', paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero" style={{ padding: '48px' }}>
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-user-circle"></i>
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
            {(aprender?.nombres || 'A').charAt(0).toUpperCase()}
          </div>
          <div style={{ flex: 1 }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '12px' }}>
              <span className="instructor-tag">Mi Perfil</span>
              {aprender?.activo && (
                <span style={{ background: 'rgba(251,191,36,0.2)', border: '1px solid rgba(251,191,36,0.35)', color: '#fde68a', padding: '6px 14px', borderRadius: '20px', fontSize: '11px', fontWeight: 800 }}>
                  En Formación
                </span>
              )}
            </div>
            <h1 className="instructor-title">
              Hola, <span style={{ color: 'var(--primary)' }}>{aprender?.nombres}</span>!
            </h1>
            <p style={{ fontSize: '15px', color: 'rgba(255,255,255,0.7)' }}>
              <i className="fas fa-graduation-cap" style={{ marginRight: '8px' }}></i>
              {aprender?.programa_formacion}
            </p>

            <div style={{ background: 'rgba(255,255,255,0.1)', border: '1px solid rgba(255,255,255,0.15)', borderRadius: '14px', padding: '14px 18px', marginTop: '16px', maxWidth: '380px' }}>
              <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '8px' }}>
                <span style={{ fontSize: '11px', fontWeight: 700, color: 'rgba(255,255,255,0.6)', textTransform: 'uppercase' }}>Integridad del Perfil</span>
                <span style={{ fontSize: '13px', fontWeight: 900, color: '#fde68a' }}>{progresoPerfil}%</span>
              </div>
              <div style={{ height: '6px', background: 'rgba(255,255,255,0.15)', borderRadius: '3px', overflow: 'hidden' }}>
                <div style={{ width: `${progresoPerfil}%`, height: '100%', background: 'linear-gradient(90deg,#fde68a,#fbbf24)', borderRadius: '3px' }}></div>
              </div>
            </div>
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
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '24px', marginBottom: '24px' }}>
            <div className="form-group">
              <label>Nombre</label>
              <div className="input-wrapper">
                <i className="fas fa-user"></i>
                <input
                  type="text"
                  value={data.nombre}
                  onChange={(e) => setData('nombre', e.target.value)}
                  placeholder="Tu nombre"
                />
              </div>
            </div>
            <div className="form-group">
              <label>Apellidos</label>
              <div className="input-wrapper">
                <i className="fas fa-user"></i>
                <input
                  type="text"
                  value={data.apellido}
                  onChange={(e) => setData('apellido', e.target.value)}
                  placeholder="Tus apellidos"
                />
              </div>
            </div>
          </div>

          <div className="form-group">
            <label>Programa de Formación</label>
            <div className="input-wrapper">
              <i className="fas fa-graduation-cap"></i>
              <input
                type="text"
                value={data.programa}
                onChange={(e) => setData('programa', e.target.value)}
                placeholder="Programa técnico o tecnológico"
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
                    placeholder="Mín. 8 caracteres"
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
                    placeholder="Confirmar contraseña"
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