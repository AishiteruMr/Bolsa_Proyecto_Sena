import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Empresas() {
  const { props } = usePage();
  const { empresas } = props;

  return (
    <div style={{ paddingBottom: '40px' }}>
      {/* Hero */}
      <div className="instructor-hero">
        <div className="instructor-hero-bg-icon">
          <i className="fas fa-building"></i>
        </div>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '10px' }}>
            <span className="admin-badge-hub">Empresas Aliadas</span>
          </div>
          <h1 className="admin-header-title">
            Gestión de <span style={{ color: 'var(--primary)' }}>Empresas</span>
          </h1>
          <p>Administra las empresas registradas en la plataforma.</p>
        </div>
      </div>

      {/* Table */}
      <div style={{ background: 'white', borderRadius: '24px', overflow: 'hidden', boxShadow: 'var(--shadow)' }}>
        {empresas?.length > 0 ? (
          <table style={{ width: '100%', borderCollapse: 'collapse' }}>
            <thead>
              <tr style={{ background: '#f8fafc', borderBottom: '1px solid #e2e8f0' }}>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Empresa</th>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>NIT</th>
                <th style={{ padding: '16px 24px', textAlign: 'left', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Representante</th>
                <th style={{ padding: '16px 24px', textAlign: 'center', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Estado</th>
                <th style={{ padding: '16px 24px', textAlign: 'right', fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Acciones</th>
              </tr>
            </thead>
            <tbody>
              {empresas.map((emp) => (
                <tr key={emp.id} style={{ borderBottom: '1px solid #f1f5f9' }}>
                  <td style={{ padding: '20px 24px' }}>
                    <div style={{ fontWeight: 700 }}>{emp.nombre}</div>
                  </td>
                  <td style={{ padding: '20px 24px', fontFamily: 'monospace' }}>
                    {emp.nit}
                  </td>
                  <td style={{ padding: '20px 24px' }}>
                    {emp.representante}
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'center' }}>
                    <span style={{
                      padding: '6px 14px',
                      borderRadius: '20px',
                      fontSize: '12px',
                      fontWeight: 600,
                      background: emp.activo ? '#dcfce7' : '#fee2e2',
                      color: emp.activo ? '#16a34a' : '#dc2626'
                    }}>
                      {emp.activo ? 'Activa' : 'Inactiva'}
                    </span>
                  </td>
                  <td style={{ padding: '20px 24px', textAlign: 'right' }}>
                    <form method="POST" action={`/admin/empresas/${emp.id}/estado`}>
                      <input type="hidden" name="_token" value={props.csrf} />
                      <input type="hidden" name="estado" value={emp.activo ? 0 : 1} />
                      <button type="submit" style={{
                        padding: '8px 16px',
                        borderRadius: '10px',
                        background: emp.activo ? '#fee2e2' : '#dcfce7',
                        color: emp.activo ? '#dc2626' : '#16a34a',
                        border: 'none',
                        fontWeight: 600,
                        cursor: 'pointer'
                      }}>
                        <i className={`fas ${emp.activo ? 'fa-ban' : 'fa-check'}`}></i>
                        {emp.activo ? ' Desactivar' : ' Activar'}
                      </button>
                    </form>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        ) : (
          <div style={{ padding: '60px', textAlign: 'center' }}>
            <div style={{ fontSize: '48px', marginBottom: '16px', color: '#cbd5e1' }}>
              <i className="fas fa-building"></i>
            </div>
            <h3 style={{ fontSize: '20px', fontWeight: 700, marginBottom: '8px' }}>No hay empresas</h3>
            <p style={{ color: 'var(--text-light)' }}>No hay empresas registradas aún.</p>
          </div>
        )}
      </div>
    </div>
  );
}