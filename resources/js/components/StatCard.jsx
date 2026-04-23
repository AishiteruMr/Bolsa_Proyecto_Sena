import React from 'react';

const iconos = {
  proyectos: 'fa-project-diagram',
 postulaciones: 'fa-file-alt',
 usuarios: 'fa-users',
 empresas: 'fa-building',
 aprobar: 'fa-check-circle',
 pendiente: 'fa-clock',
  rechzar: 'fa-times-circle',
  default: 'fa-chart-line',
};

const colores = {
  primary: 'var(--primary)',
  success: '#10b981',
  warning: '#f59e0b',
  danger: '#ef4444',
  info: '#3b82f6',
};

export function StatCard({ titulo, valor, icono, color = 'primary', cambio }) {
  const iconClass = iconos[icono] || iconos.default;
  const colorValue = colores[color] || colores.primary;

  return (
    <div className="glass-card" style={{
      padding: '24px',
      display: 'flex',
      alignItems: 'center',
      gap: '16px',
    }}>
      <div style={{
        width: '56px',
        height: '56px',
        borderRadius: '12px',
        background: `${colorValue}15`,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        fontSize: '24px',
        color: colorValue,
      }}>
        <i className={`fas ${iconClass}`}></i>
      </div>
      <div>
        <div style={{ fontSize: '28px', fontWeight: '800', color: 'var(--text)' }}>
          {valor}
        </div>
        <div style={{ fontSize: '13px', color: 'var(--text-light)', fontWeight: '600' }}>
          {titulo}
        </div>
        {cambio && (
          <div style={{ fontSize: '12px', color: cambio > 0 ? '#10b981' : '#ef4444' }}>
            {cambio > 0 ? '↑' : '↓'} {Math.abs(cambio)}%
          </div>
        )}
      </div>
    </div>
  );
}

export function StatGrid({ stats = [] }) {
  if (stats.length === 0) {
    return (
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '16px' }}>
        <StatCard titulo="Sin datos" valor="-" />
      </div>
    );
  }

  return (
    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '16px' }}>
      {stats.map((stat, i) => (
        <StatCard key={i} {...stat} />
      ))}
    </div>
  );
}

export default { StatCard, StatGrid };
}