import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';

export default function RestablecerContrasena({ token, correo }) {
  const { data, setData, post, errors, processing } = useForm({
    token: token || '',
    correo: correo || '',
    password: '',
    password_confirmation: '',
  });

  const [validacion, setValidacion] = useState({
    length: false,
    upper: false,
    lower: false,
    number: false,
  });

  const [coinciden, setCoinciden] = useState(true);

  const validarPassword = (value) => {
    setValidacion({
      length: value.length >= 8,
      upper: /[A-Z]/.test(value),
      lower: /[a-z]/.test(value),
      number: /[0-9]/.test(value),
    });
  };

  const validarCoincidencia = (pass, confirm) => {
    if (confirm && pass !== confirm) {
      setCoinciden(false);
    } else {
      setCoinciden(true);
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/restablecer-contraseña');
  };

  const isValid = validacion.length && validacion.upper && validacion.lower && validacion.number && coinciden;

  return (
    <div className="login-page-wrapper">
      <div className="blob blob-1"></div>
      <div className="blob blob-2"></div>

      <div className="login-container" style={{ maxWidth: '420px' }}>
        <div className="login-brand">
          <div className="brand-header">
            <img src="/img/logo.png" alt="SENA" style={{ width: '44px', height: '44px', background: '#fff', padding: '8px', borderRadius: '12px' }} />
            <span>Bolsa de Proyectos<br />SENA</span>
          </div>
        </div>

        <div className="login-content" style={{ padding: '40px 32px' }}>
          <div className="content-header">
            <h3>Nueva Contraseña</h3>
            <p>Ingresa tu nueva contraseña安全的.</p>
          </div>

          {Object.keys(errors).length > 0 && (
            <div className="alert alert-error">
              {Object.values(errors).map((error, i) => (
                <span key={i}>{error}</span>
              ))}
            </div>
          )}

          <div className="password-requirements" style={{
            background: '#f0f7ff',
            borderLeft: '4px solid var(--primary)',
            padding: '12px',
            borderRadius: '6px',
            marginBottom: '20px',
            fontSize: '12px'
          }}>
            <h4 style={{ color: 'var(--primary)', marginBottom: '8px' }}>Requisitos:</h4>
            <ul style={{ listStyle: 'none', margin: 0, padding: 0 }}>
              <li style={{ color: validacion.length ? '#28a745' : '#dc3545', display: 'flex', alignItems: 'center', margin: '4px 0' }}>
                <span style={{ marginRight: '8px' }}>✓</span> Mínimo 8 caracteres
              </li>
              <li style={{ color: validacion.upper ? '#28a745' : '#dc3545', display: 'flex', alignItems: 'center', margin: '4px 0' }}>
                <span style={{ marginRight: '8px' }}>✓</span> Una letra mayúscula
              </li>
              <li style={{ color: validacion.lower ? '#28a745' : '#dc3545', display: 'flex', alignItems: 'center', margin: '4px 0' }}>
                <span style={{ marginRight: '8px' }}>✓</span> Una letra minúscula
              </li>
              <li style={{ color: validacion.number ? '#28a745' : '#dc3545', display: 'flex', alignItems: 'center', margin: '4px 0' }}>
                <span style={{ marginRight: '8px' }}>✓</span> Un número
              </li>
            </ul>
          </div>

          <form onSubmit={handleSubmit}>
            <input type="hidden" name="token" value={data.token} />
            <input type="hidden" name="correo" value={data.correo} />

            <div className="form-group">
              <label>Nueva Contraseña</label>
              <div className="input-wrapper">
                <i className="fas fa-lock"></i>
                <input
                  type="password"
                  value={data.password}
                  onChange={(e) => {
                    setData('password', e.target.value);
                    validarPassword(e.target.value);
                    validarCoincidencia(e.target.value, data.password_confirmation);
                  }}
                  placeholder="••••••••"
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
                  value={data.password_confirmation}
                  onChange={(e) => {
                    setData('password_confirmation', e.target.value);
                    validarCoincidencia(data.password, e.target.value);
                  }}
                  placeholder="••••••••"
                  required
                />
              </div>
              {!coinciden && (
                <small style={{ color: '#dc3545' }}>Las contraseñas no coinciden</small>
              )}
            </div>

            <button type="submit" className="btn-submit" disabled={!isValid || processing}>
              {processing ? 'Enviando...' : '🔐 Restablecer Contraseña'}
            </button>
          </form>

          <div className="divider" style={{ marginTop: '20px' }}>
            <a href="/olvide-contraseña" style={{ color: 'var(--primary)', textDecoration: 'none' }}>
              ¿Necesitas ayuda? Solicitar nuevo enlace
            </a>
          </div>
        </div>
      </div>
    </div>
  );
}