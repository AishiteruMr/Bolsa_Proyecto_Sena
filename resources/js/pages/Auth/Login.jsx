import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function Login() {
  const { props } = usePage();
  const { data, setData, post, errors } = useForm({
    correo: '',
    password: ''
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/login');
  };

  return (
    <div className="login-page-wrapper">
      <a href="/" className="btn-back">
        <i className="fas fa-arrow-left"></i> Volver al Inicio
      </a>

      <div className="blob blob-1"></div>
      <div className="blob blob-2"></div>

      <div className="login-container" style={{ maxWidth: '1100px' }}>
        <div className="login-brand">
          <div className="brand-header">
            <img src="/img/logo.png" alt="SENA" />
            <span>Inspírate<br />SENA</span>
          </div>

          <div className="brand-quote">
            <h2>Impulsa <span style={{ color: 'var(--primary-light)' }}> Ideas</span>,<br />Cosecha <span style={{ color: 'var(--primary-light)' }}>Éxitos</span>.</h2>
            <p>"La innovación es el camino que transforma el conocimiento en soluciones reales para el mundo."</p>
          </div>

          <div className="brand-features">
            <div className="brand-feature">
              <i className="fas fa-rocket"></i>
              <span>Proyectos Innovadores</span>
            </div>
            <div className="brand-feature">
              <i className="fas fa-handshake"></i>
              <span>Red de Contactos</span>
            </div>
            <div className="brand-feature">
              <i className="fas fa-chart-line"></i>
              <span>Seguimiento Profesional</span>
            </div>
          </div>

          <div className="brand-footer">
            Bolsa de Proyectos & Talentos v2.0
          </div>
        </div>

        <div className="login-content" style={{ padding: '64px' }}>
          <div className="content-header">
            <h3>Bienvenido de nuevo</h3>
            <p>Ingresa tus credenciales para continuar.</p>
          </div>

          {props.flash?.success && (
            <div className="alert alert-success">{props.flash.success}</div>
          )}
          {props.flash?.error && (
            <div className="alert alert-error">{props.flash.error}</div>
          )}
          {props.flash?.info && (
            <div className="alert alert-info" style={{ background: '#eff6ff', borderColor: '#3b82f6', color: '#1e40af' }}>
              {props.flash.info}
            </div>
          )}
          {Object.keys(errors).length > 0 && (
            <div className="alert alert-error">
              {Object.values(errors).map((error, i) => (
                <span key={i}>{error}</span>
              ))}
            </div>
          )}

          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label>
                Correo Electrónico
              </label>
              <div className="input-wrapper">
                <i className="fas fa-envelope"></i>
                <input
                  type="email"
                  name="correo"
                  value={data.correo}
                  onChange={(e) => setData('correo', e.target.value)}
                  placeholder="tucorreo@email.com"
                  required
                />
              </div>
            </div>

            <div className="form-group">
              <label>Contraseña</label>
              <div className="input-wrapper">
                <i className="fas fa-lock"></i>
                <input
                  type="password"
                  name="password"
                  value={data.password}
                  onChange={(e) => setData('password', e.target.value)}
                  placeholder="••••••••"
                  required
                />
              </div>
              <div className="form-hint">
                <i className="fas fa-shield-alt" style={{ color: '#64748b' }}></i>
                Tu información está protegida
              </div>
            </div>

            <a href="/olvide-contraseña" className="forgot-link">¿Olvidaste tu contraseña?</a>

            <button type="submit" className="btn-submit">
              Entrar al Portal <i className="fas fa-arrow-right" style={{ marginLeft: '8px' }}></i>
            </button>
          </form>

          <div className="divider">ó regístrate como</div>

          <div className="role-grid">
            <a href="/registro/aprendiz" className="role-card">
              <i className="fas fa-user-graduate"></i>
              <span>Aprendiz</span>
            </a>
            <a href="/registro/instructor" className="role-card">
              <i className="fas fa-chalkboard-teacher"></i>
              <span>Instructor</span>
            </a>
            <a href="/registro/empresa" className="role-card">
              <i className="fas fa-building"></i>
              <span>Empresa</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  );
}