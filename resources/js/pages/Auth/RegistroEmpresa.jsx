import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function RegistroEmpresa() {
  const { props } = usePage();
  const { data, setData, post, errors } = useForm({
    nombre_empresa: '',
    nit: '',
    representante: '',
    correo: '',
    password: '',
    password_confirmation: '',
    terminos: false
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/registro/empresa');
  };

  return (
    <div className="login-page-wrapper">
      <a href="/" className="btn-back">
        <i className="fas fa-arrow-left"></i> Volver al Inicio
      </a>

      <div className="blob blob-1"></div>
      <div className="blob blob-2"></div>

      <div className="login-container">
        <div className="login-brand">
          <div className="brand-header">
            <img src="/img/logo.png" alt="SENA" />
            <span>Inspírate<br />SENA</span>
          </div>

          <div className="brand-quote">
            <h2>Regístrate como <span style={{ color: 'var(--primary-light)' }}>Empresa</span></h2>
            <p>Únete a nuestra red de empresas y conecta con talentosos aprendices del SENA.</p>
          </div>

          <div className="brand-features">
            <div className="brand-feature">
              <i className="fas fa-building"></i>
              <span>Talento Calificado</span>
            </div>
            <div className="brand-feature">
              <i className="fas fa-user-graduate"></i>
              <span>Aprendices SENA</span>
            </div>
            <div className="brand-feature">
              <i className="fas fa-handshake"></i>
              <span>Alianzas Estratégicas</span>
            </div>
          </div>

          <div className="brand-footer">
            Bolsa de Proyectos & Talentos
          </div>
        </div>

        <div className="login-content">
          <div className="content-header">
            <h3>Crear Cuenta</h3>
            <p>Ingresa los datos de tu empresa para comenzar.</p>
          </div>

          {Object.keys(errors).length > 0 && (
            <div className="alert alert-error">
              {Object.values(errors).map((error, i) => (
                <span key={i}>{error}</span>
              ))}
            </div>
          )}

          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label>Nombre de la Empresa</label>
              <div className="input-wrapper">
                <i className="fas fa-building"></i>
                <input
                  type="text"
                  name="nombre_empresa"
                  value={data.nombre_empresa}
                  onChange={(e) => setData('nombre_empresa', e.target.value)}
                  placeholder="Nombre de la empresa"
                  required
                />
              </div>
            </div>

            <div className="form-group">
              <label>NIT</label>
              <div className="input-wrapper">
                <i className="fas fa-id-card"></i>
                <input
                  type="text"
                  name="nit"
                  value={data.nit}
                  onChange={(e) => setData('nit', e.target.value)}
                  placeholder="Número de identificación"
                  required
                />
              </div>
            </div>

            <div className="form-group">
              <label>Representante Legal</label>
              <div className="input-wrapper">
                <i className="fas fa-user-tie"></i>
                <input
                  type="text"
                  name="representante"
                  value={data.representante}
                  onChange={(e) => setData('representante', e.target.value)}
                  placeholder="Nombre completo"
                  required
                />
              </div>
            </div>

            <div className="form-group">
              <label>Correo Electrónico</label>
              <div className="input-wrapper">
                <i className="fas fa-envelope"></i>
                <input
                  type="email"
                  name="correo"
                  value={data.correo}
                  onChange={(e) => setData('correo', e.target.value)}
                  placeholder="correo@empresa.com"
                  required
                />
              </div>
            </div>

            <div className="input-row">
              <div className="form-group">
                <label>Contraseña</label>
                <div className="input-wrapper">
                  <i className="fas fa-lock"></i>
                  <input
                    type="password"
                    name="password"
                    value={data.password}
                    onChange={(e) => setData('password', e.target.value)}
                    placeholder="Mín. 6 caracteres"
                    required
                  />
                </div>
              </div>
              <div className="form-group">
                <label>Confirmar</label>
                <div className="input-wrapper">
                  <i className="fas fa-lock"></i>
                  <input
                    type="password"
                    name="password_confirmation"
                    value={data.password_confirmation}
                    onChange={(e) => setData('password_confirmation', e.target.value)}
                    placeholder="Confirmar"
                    required
                  />
                </div>
              </div>
            </div>

            <div className="form-group">
              <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                <input
                  type="checkbox"
                  id="terminos"
                  checked={data.terminos}
                  onChange={(e) => setData('terminos', e.target.checked)}
                  style={{ width: '16px', height: '16px' }}
                />
                <label htmlFor="terminos" style={{ margin: 0, fontSize: '13px' }}>Acepto los Términos y Condiciones</label>
              </div>
            </div>

            <button type="submit" className="btn-submit">Crear Cuenta</button>
          </form>

          <div className="divider">¿Ya tienes cuenta?</div>

          <a href="/login" className="btn-submit" style={{ textAlign: 'center', textDecoration: 'none' }}>
            Iniciar Sesión
          </a>
        </div>
      </div>
    </div>
  );
}