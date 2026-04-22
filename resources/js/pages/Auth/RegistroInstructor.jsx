import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function RegistroInstructor() {
  const { props } = usePage();
  const { data, setData, post, errors } = useForm({
    nombre: '',
    apellido: '',
    documento: '',
    especialidad: '',
    correo: '',
    password: '',
    password_confirmation: '',
    terminos: false
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/registro/instructor');
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
            <h2>¡Guía el <span style={{ color: 'var(--primary-light)' }}>Futuro!</span></h2>
            <p>Lidera proyectos con aprendices y conecta con empresas.</p>
          </div>

          <div className="brand-features">
            <div className="brand-feature">
              <i className="fas fa-chalkboard-teacher"></i>
              <span>Mentoría de Talento</span>
            </div>
            <div className="brand-feature">
              <i className="fas fa-project-diagram"></i>
              <span>Gestión de Proyectos</span>
            </div>
            <div className="brand-feature">
              <i className="fas fa-network-wired"></i>
              <span>Red Empresarial</span>
            </div>
          </div>

          <div className="brand-footer">
            Bolsa de Proyectos & Talentos
          </div>
        </div>

        <div className="login-content">
          <div className="content-header">
            <h3>Registro Instructor</h3>
            <p>Crea tu cuenta de instructor</p>
          </div>

          {Object.keys(errors).length > 0 && (
            <div className="alert alert-error">
              {Object.values(errors).map((error, i) => (
                <span key={i}>{error}</span>
              ))}
            </div>
          )}

          <form onSubmit={handleSubmit}>
            <div className="input-row">
              <div className="form-group">
                <label>Nombre</label>
                <div className="input-wrapper">
                  <i className="fas fa-user"></i>
                  <input
                    type="text"
                    name="nombre"
                    value={data.nombre}
                    onChange={(e) => setData('nombre', e.target.value)}
                    placeholder="Tu nombre"
                    required
                  />
                </div>
              </div>
              <div className="form-group">
                <label>Apellidos</label>
                <div className="input-wrapper">
                  <i className="fas fa-user"></i>
                  <input
                    type="text"
                    name="apellido"
                    value={data.apellido}
                    onChange={(e) => setData('apellido', e.target.value)}
                    placeholder="Tus apellidos"
                    required
                  />
                </div>
              </div>
            </div>

            <div className="form-group">
              <label>Documento de Identidad</label>
              <div className="input-wrapper">
                <i className="fas fa-id-card"></i>
                <input
                  type="text"
                  name="documento"
                  value={data.documento}
                  onChange={(e) => setData('documento', e.target.value)}
                  placeholder="Número de documento"
                  required
                />
              </div>
            </div>

            <div className="form-group">
              <label>Especialización SENA</label>
              <div className="input-wrapper">
                <i className="fas fa-chalkboard-user"></i>
                <input
                  type="text"
                  name="especialidad"
                  value={data.especialidad}
                  onChange={(e) => setData('especialidad', e.target.value)}
                  placeholder="Área de especialización"
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
                  placeholder="tu@email.com"
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
                  placeholder="Mín. 6 caracteres"
                  required
                />
              </div>
            </div>

            <div className="form-group">
              <label>Confirmar Contraseña</label>
              <div className="input-wrapper">
                <i className="fas fa-lock"></i>
                <input
                  type="password"
                  name="password_confirmation"
                  value={data.password_confirmation}
                  onChange={(e) => setData('password_confirmation', e.target.value)}
                  placeholder="Confirmar contraseña"
                  required
                />
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