import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function Perfil() {
  const { props } = usePage();
  const { instructor, usuario, proyectosCount, aprendicesCount, evidenciasPendientesCount } = props;
  const { data, setData, put, errors } = useForm({
    nombre: instructor?.nombres || '',
    apellido: instructor?.apellidos || '',
    especialidad: instructor?.especialidad || '',
    password: '',
    password_confirmation: ''
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    put('/instructor/perfil');
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
            {(instructor?.nombres || 'I').charAt(0).toUpperCase()}
          </div>
          <div style={{ flex: 1 }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '12px' }}>
              <span className="instructor-tag">Mi Perfil</span>
            </div>
            <h1 className="instructor-title">
              Hola, <span style={{ color: 'var(--primary)' }}>{instructor?.nombres}</span>!
            </h1>
            <p style={{ fontSize: '15px', color: 'rgba(255,255,255,0.7)' }}>
              <i className="fas fa-chalkboard-user" style={{ marginRight: '8px' }}></i>
              {instructor?.especialidad}
            </p>

            <div style={{ display: 'flex', gap: '16px', marginTop: '20px' }}>
              <div style={{ background: 'rgba(255,255,255,0.1)', borderRadius: '12px', padding: '12px 16px' }}>
                <div style={{ fontSize: '20px', fontWeight: 800 }}>{proyectosCount}</div>
                <div style={{ fontSize: '11px', opacity: 0.7 }}>Proyectos</div>
              </div>
              <div style={{ background: 'rgba(255,255,255,0.1)', borderRadius: '12px', padding: '12px 16px' }}>
                <div style={{ fontSize: '20px', fontWeight: 800 }}>{aprendicesCount}</div>
                <div style={{ fontSize: '11px', opacity: 0.7 }}>Aprendices</div>
              </div>
              <div style={{ background: 'rgba(255,255,255,0.1)', borderRadius: '12px', padding: '12px 16px' }}>
                <div style={{ fontSize: '20px', fontWeight: 800 }}>{evidenciasPendientesCount}</div>
                <div style={{ fontSize: '11px', opacity: 0.7 }}>Evidencias</div>
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
                />
              </div>
            </div>
          </div>

          <div className="form-group">
            <label>Especialidad</label>
            <div className="input-wrapper">
              <i className="fas fa-chalkboard-user"></i>
              <input
                type="text"
                value={data.especialidad}
                onChange={(e) => setData('especialidad', e.target.value)}
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