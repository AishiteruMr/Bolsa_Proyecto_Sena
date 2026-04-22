import React from 'react';
import { usePage } from '@inertiajs/react';

export default function ReporteProyecto() {
  const { props } = usePage();
  const proyecto = props.proyecto;
  const etapas = props.etapas || [];
  const aprendices = props.aprendices || [];
  const evidencias = props.evidencias || [];

  return (
    <div style={{ padding: '40px 20px', maxWidth: '1200px', margin: '0 auto' }}>
      <a href="/empresa/proyectos" style={{ color: 'var(--primary)', textDecoration: 'none', fontSize: '14px' }}>
        ← Volver a Proyectos
      </a>

      <h1 style={{ fontSize: '28px', fontWeight: '800', margin: '20px 0' }}>
        Reporte del Proyecto
      </h1>
      <h2 style={{ fontSize: '20px', fontWeight: '600', color: 'var(--text-light)', marginBottom: '30px' }}>
        {proyecto?.titulo}
      </h2>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: '20px', marginBottom: '40px' }}>
        <div style={{ background: 'white', padding: '20px', borderRadius: '12px', textAlign: 'center' }}>
          <div style={{ fontSize: '32px', fontWeight: '800', color: 'var(--primary)' }}>{etapas?.length || 0}</div>
          <div style={{ fontSize: '14px', color: 'var(--text-light)' }}>Etapas</div>
        </div>
        <div style={{ background: 'white', padding: '20px', borderRadius: '12px', textAlign: 'center' }}>
          <div style={{ fontSize: '32px', fontWeight: '800', color: '#10b981' }}>{aprendices?.length || 0}</div>
          <div style={{ fontSize: '14px', color: 'var(--text-light)' }}>Participantes</div>
        </div>
        <div style={{ background: 'white', padding: '20px', borderRadius: '12px', textAlign: 'center' }}>
          <div style={{ fontSize: '32px', fontWeight: '800', color: '#3b82f6' }}>{evidencias?.filter(e => e.estado === 'aprobada').length || 0}</div>
          <div style={{ fontSize: '14px', color: 'var(--text-light)' }}>Evidencias Aprobadas</div>
        </div>
        <div style={{ background: 'white', padding: '20px', borderRadius: '12px', textAlign: 'center' }}>
          <div style={{ fontSize: '32px', fontWeight: '800', color: '#f59e0b' }}>{evidencias?.filter(e => e.estado === 'pendiente').length || 0}</div>
          <div style={{ fontSize: '14px', color: 'var(--text-light)' }}>Pendientes</div>
        </div>
      </div>

      <div style={{ background: 'white', borderRadius: '12px', padding: '30px' }}>
        <h3 style={{ fontSize: '18px', fontWeight: '700', marginBottom: '20px' }}>Participantes</h3>
        {aprendices?.length === 0 ? (
          <p style={{ color: 'var(--text-light)' }}>No hay participantes.</p>
        ) : (
          <div style={{ display: 'flex', flexDirection: 'column', gap: '15px' }}>
            {aprendices.map((apr) => (
              <div key={apr.id} style={{ padding: '15px', background: '#f8fafc', borderRadius: '8px', display: 'flex', justifyContent: 'space-between' }}>
                <div>
                  <div style={{ fontWeight: '600' }}>{apr.aprendiz_nombres} {apr.aprendiz_apellidos}</div>
                  <div style={{ fontSize: '14px', color: 'var(--text-light)' }}>{apr.usr_correo}</div>
                </div>
                <span style={{ background: '#10b98120', color: '#10b981', padding: '4px 12px', borderRadius: '12px', fontSize: '12px' }}>
                  Activo
                </span>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}