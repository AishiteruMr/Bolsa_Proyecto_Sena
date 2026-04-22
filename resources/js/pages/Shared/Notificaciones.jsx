import React from 'react';
import { usePage } from '@inertiajs/react';

export default function Notificaciones() {
  const { props } = usePage();
  const notificaciones = props.notificaciones || { data: [], links: [] };
  const previousUrl = props.returnUrl || null;

  const marcarLeida = (id) => {
    fetch(`/notificaciones/${id}/leer`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    }).then(() => window.location.reload());
  };

  const marcarTodasLeidas = () => {
    fetch('/notificaciones/leer-todas', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    }).then(() => window.location.reload());
  };

  const volverUrl = previousUrl || (props.auth?.rol === 1 ? '/aprendiz/dashboard' : '/');

  const getIcono = (tipo) => {
    const iconos = {
      'fa-paper-plane': '📨',
      'fa-check': '✅',
      'fa-times': '❌',
      'fa-star': '⭐',
      'fa-bell': '🔔',
    };
    return iconos[tipo] || '📌';
  };

  const formatearFecha = (fecha) => {
    const date = new Date(fecha);
    const ahora = new Date();
    const diffMs = ahora - date;
    const diffHoras = Math.floor(diffMs / (1000 * 60 * 60));
    
    if (diffHoras < 1) return 'Hace unos minutos';
    if (diffHoras < 24) return `Hace ${diffHoras} hora${diffHoras > 1 ? 's' : ''}`;
    const diffDias = Math.floor(diffHoras / 24);
    if (diffDias < 7) return `Hace ${diffDias} día${diffDias > 1 ? 's' : ''}`;
    return date.toLocaleDateString('es-CO');
  };

  return (
    <div style={{ padding: '40px 20px', maxWidth: '800px', margin: '0 auto' }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '30px' }}>
        <div>
          <a href={volverUrl} style={{ color: 'var(--primary)', textDecoration: 'none', fontSize: '14px', marginBottom: '8px', display: 'inline-block' }}>
            ← Volver
          </a>
          <h1 style={{ fontSize: '28px', fontWeight: '800', color: 'var(--text)', margin: '8px 0' }}>
            Notificaciones
          </h1>
        </div>
        {notificaciones.data.length > 0 && (
          <button onClick={marcarTodasLeidas} className="btn-submit" style={{ background: 'var(--primary)', padding: '10px 20px' }}>
            Marcar todas como leídas
          </button>
        )}
      </div>

      {notificaciones.data.length === 0 ? (
        <div style={{ textAlign: 'center', padding: '60px 20px' }}>
          <div style={{ fontSize: '60px', marginBottom: '20px' }}>🔔</div>
          <h3 style={{ color: 'var(--text)', marginBottom: '10px' }}>No hay notificaciones</h3>
          <p style={{ color: 'var(--text-light)' }}>Estás al día con todo.</p>
        </div>
      ) : (
        <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
          {notificaciones.data.map((notif) => (
            <div
              key={notif.id}
              style={{
                background: notif.read_at ? '#f8fafc' : 'white',
                border: '1px solid #e2e8f0',
                borderRadius: '12px',
                padding: '20px',
                display: 'flex',
                alignItems: 'flex-start',
                gap: '16px',
                transition: 'all 0.2s',
                boxShadow: notif.read_at ? 'none' : '0 2px 8px rgba(0,0,0,0.05)',
              }}
            >
              <div style={{ fontSize: '24px', width: '40px', textAlign: 'center' }}>
                {getIcono(notif.data?.icon)}
              </div>
              <div style={{ flex: 1 }}>
                <h4 style={{ fontSize: '16px', fontWeight: '600', color: 'var(--text)', marginBottom: '4px' }}>
                  {notif.data?.title || 'Notificación'}
                </h4>
                <p style={{ fontSize: '14px', color: 'var(--text-light)', marginBottom: '8px' }}>
                  {notif.data?.message}
                </p>
                <span style={{ fontSize: '12px', color: '#94a3b8' }}>
                  {formatearFecha(notif.created_at)}
                </span>
              </div>
              {!notif.read_at && (
                <button
                  onClick={() => marcarLeida(notif.id)}
                  style={{
                    background: 'none',
                    border: 'none',
                    color: 'var(--primary)',
                    cursor: 'pointer',
                    fontSize: '12px',
                  }}
                >
                  Marcar leída
                </button>
              )}
            </div>
          ))}
        </div>
      )}

      {notificaciones.links && notificaciones.links.length > 3 && (
        <div style={{ display: 'flex', justifyContent: 'center', gap: '8px', marginTop: '30px' }}>
          {notificaciones.links.map((link, i) => (
            <a
              key={i}
              href={link.url}
              dangerouslySetInnerHTML={{ __html: link.label }}
              style={{
                padding: '8px 12px',
                borderRadius: '6px',
                background: link.active ? 'var(--primary)' : 'transparent',
                color: link.active ? 'white' : 'var(--text)',
                textDecoration: 'none',
                fontSize: '14px',
              }}
            />
          ))}
        </div>
      )}
    </div>
  );
}