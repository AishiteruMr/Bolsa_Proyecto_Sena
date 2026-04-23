import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Usuarios() {
  const { props } = usePage();
  const { aprendices, instructores, empresas } = props;

  const totalUsuarios = (aprendices?.length || 0) + (instructores?.length || 0);

  return (
    <div style={{ paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-users"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
            <span className="admin-badge-hub">Gestión de Usuarios</span>
          </div>
          <h1 className="admin-header-title">
            Gestión de <span style={{ color: 'var(--primary)' }}>Usuarios</span>
          </h1>
          <p>Administra aprendices, instructores y empresas.</p>
        </div>
      </div>

      {/* Stats */}
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: '20px', marginBottom: '32px' }}>
        <div className="stat-card-premium" style={{ padding: '24px', background: 'white' }}>
          <div style={{ fontSize: '32px', fontWeight: 800, color: '#3b82f6' }}>{aprendices?.length || 0}</div>
          <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Aprendices</div>
        </div>
        <div className="stat-card-premium" style={{ padding: '24px', background: 'white' }}>
          <div style={{ fontSize: '32px', fontWeight: 800, color: '#d97706' }}>{instructores?.length || 0}</div>
          <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Instructores</div>
        </div>
        <div className="stat-card-premium" style={{ padding: '24px', background: 'white' }}>
          <div style={{ fontSize: '32px', fontWeight: 800, color: '#16a34a' }}>{empresas?.length || 0}</div>
          <div style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase' }}>Empresas</div>
        </div>
      </div>

      {/* Aprendices Table */}
      <div style={{ background: 'white', borderRadius: '24px', padding: '24px', boxShadow: 'var(--shadow)', marginBottom: '24px' }}>
        <h3 style={{ fontSize: '18px', fontWeight: 700, marginBottom: '20px' }}>Aprendices</h3>
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '12px' }}>
          {aprendices?.map((apr) => (
            <div key={apr.id} style={{ padding: '12px 16px', background: '#f8fafc', borderRadius: '12px', minWidth: '200px' }}>
              <div style={{ fontWeight: 600 }}>{apr.nombres} {apr.apellidos}</div>
              <div style={{ fontSize: '12px', color: 'var(--text-light)' }}>{apr.usuario?.correo}</div>
            </div>
          ))}
        </div>
      </div>

      {/* Instructores Table */}
      <div style={{ background: 'white', borderRadius: '24px', padding: '24px', boxShadow: 'var(--shadow)' }}>
        <h3 style={{ fontSize: '18px', fontWeight: 700, marginBottom: '20px' }}>Instructores</h3>
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '12px' }}>
          {instructores?.map((ins) => (
            <div key={ins.id} style={{ padding: '12px 16px', background: '#f8fafc', borderRadius: '12px', minWidth: '200px' }}>
              <div style={{ fontWeight: 600 }}>{ins.nombres} {ins.apellidos}</div>
              <div style={{ fontSize: '12px', color: 'var(--text-light)' }}>{ins.especialidad}</div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}