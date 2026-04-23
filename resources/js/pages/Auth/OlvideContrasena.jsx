import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function OlvideContrasena() {
  const { props } = usePage();
  const { data, setData, post, errors } = useForm({
    correo: ''
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/enviar-recuperacion');
  };

  return (
    <div className="login-page-wrapper">
      <a href="/login" className="btn-back">
        <i className="fas fa-arrow-left"></i> Volver al Login
      </a>

      <div className="blob blob-1"></div>
      <div className="blob blob-2"></div>

      <div className="login-container" style={{ maxWidth: '480px' }}>
        <div className="login-content" style={{ padding: '48px' }}>
          <div className="content-header">
            <h3>Recuperar Contraseña</h3>
            <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
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

            <button type="submit" className="btn-submit">
              <i className="fas fa-paper-plane"></i> Enviar Enlace
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}