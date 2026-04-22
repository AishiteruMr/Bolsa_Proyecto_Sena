import React from 'react';
import { Link } from '@inertiajs/react';

export function DashboardHeader({ 
  title, 
  subtitle,
  roles = [],
  nombre,

}) {
  const roleColors = {
    aprendiz: { tag: 'Portal del Talento', icon: 'fa-rocket', color: '#3eb489' },
    instructor: { tag: 'Panel Instructor', icon: 'fa-chalkboard-teacher', color: '#8b5cf6' },
    empresa: { tag: 'Portal Empresa', icon: 'fa-building', color: '#3b82f6' },
    admin: { tag: 'Administración', icon: 'fa-shield-alt', color: '#ef4444' },
  };

  const currentRole = roles.find(r => roleColors[r]) || roleColors.aprendiz;

  return (
    <div className="instructor-hero">
      <div className="instructor-hero-bg-icon">
        <i className={`fas ${currentRole.icon}`}></i>
      </div>
      <div>
        <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '10px' }}>
          <span className="instructor-tag">{currentRole.tag}</span>
        </div>
        <h1>
          ¡Hola de nuevo, <span style={{ color: currentRole.color }}>{nombre}</span>!
        </h1>
        <p>{subtitle}</p>
      </div>
    </div>
  );
}

export function DashboardStatGrid({ children }) {
  return (
    <div className="instructor-stat-grid">
      {children}
    </div>
  );
}

export function DashboardStatCard({ 
  icon = 'fa-chart-line',
  iconBg = 'linear-gradient(135deg, #3eb489, #2d9d74)',
  title,
  value,
  subtitle,
  colspan,
  style = {},
}) {
  return (
    <div className="glass-card" style={{ gridColumn: colspan ? 'span 2' : 'span 1', ...style }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: '32px' }}>
        <div style={{ 
          width: '80px', 
          height: '80px', 
          borderRadius: '24px', 
          background: iconBg, 
          color: 'white', 
          display: 'flex', 
          alignItems: 'center', 
          justifyContent: 'center', 
          fontSize: '32px' 
        }}>
          <i className={`fas ${icon}`}></i>
        </div>
        <div>
          {title && <span style={{ fontSize: '13px', color: 'var(--text-light)', fontWeight: '600' }}>{title}</span>}
          <h3>{value}</h3>
          {subtitle && <p>{subtitle}</p>}
        </div>
      </div>
    </div>
  );
}

export function DashboardSmallStat({ icon, color, label, value }) {
  return (
    <div className="glass-card">
      <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
          <div style={{ 
            width: '40px', 
            height: '40px', 
            borderRadius: '10px', 
            background: `${color}15`, 
            color: color, 
            display: 'flex', 
            alignItems: 'center', 
            justifyContent: 'center' 
          }}>
            <i className={`fas ${icon}`}></i>
          </div>
          <span>{label}</span>
        </div>
        <h4>{value}</h4>
      </div>
    </div>
  );
}

export function DashboardSection({ title, icon, color, link, linkText, children }) {
  return (
    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', margin: '40px 0 28px' }}>
      <h3>
        <i className={`fas ${icon}`} style={{ color: color }}></i> {title}
      </h3>
      {link && (
        <Link href={link} style={{ color: color || '#3eb489', fontWeight: '700' }}>
          {linkText || 'Ver todos'} <i className="fas fa-arrow-right"></i>
        </Link>
      )}
    </div>
  );
}

export function DashboardEmpty({ icon = 'fa-folder-open', title = 'No hay datos', message }) {
  return (
    <div style={{ textAlign: 'center', padding: '60px 20px', background: 'white', borderRadius: '12px' }}>
      <div style={{ fontSize: '48px', marginBottom: '16px' }}>
        <i className={`fas ${icon}`}></i>
      </div>
      <h3 style={{ color: 'var(--text)', marginBottom: '8px' }}>{title}</h3>
      {message && <p style={{ color: 'var(--text-light)', fontSize: '15px' }}>{message}</p>}
    </div>
  );
}

export default { 
  DashboardHeader, 
  DashboardStatGrid, 
  DashboardStatCard, 
  DashboardSmallStat,
  DashboardSection,
  DashboardEmpty,
};