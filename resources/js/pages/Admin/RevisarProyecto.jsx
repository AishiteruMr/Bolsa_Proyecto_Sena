import React from 'react';
import { usePage } from '@inertiajs/react';

export default function RevisarProyecto() {
  const { props } = usePage();
  const proyecto = props.proyecto;
  const calidad = props.calidad || {};

  const getScoreColor = (porcentaje) => {
    if (porcentaje >= 75) return '#10b981';
    if (porcentaje >= 50) return '#f59e0b';
    return '#ef4444';
  };

  const getScoreBg = (porcentaje) => {
    if (porcentaje >= 75) return '#f0fdf4';
    if (porcentaje >= 50) return '#fffbeb';
    return '#fef2f2';
  };

  const getIcon = (ok) => ok ? '✓' : '✗';

  return (
    <div style={{ padding: '40px 20px', maxWidth: '1200px', margin: '0 auto' }}>
      <a href="/admin/proyectos" style={{ color: 'var(--primary)', textDecoration: 'none', fontSize: '14px', marginBottom: '8px', display: 'inline-block' }}>
        ← Volver a Proyectos
      </a>

      <div style={{ display: 'grid', gridTemplateColumns: '1fr 350px', gap: '30px', marginTop: '20px' }}>
        <div style={{ background: 'white', borderRadius: '12px', padding: '30px', boxShadow: '0 1px 3px rgba(0,0,0,0.1)' }}>
          <h1 style={{ fontSize: '24px', fontWeight: '800', marginBottom: '20px' }}>{proyecto.titulo}</h1>
          
          <div style={{ marginBottom: '30px' }}>
            <span style={{
              background: proyecto.estado === 'aprobado' ? '#f0fdf4' : proyecto.estado === 'rechazado' ? '#fef2f2' : '#fff7ed',
              color: proyecto.estado === 'aprobado' ? '#10b981' : proyecto.estado === 'rechazado' ? '#ef4444' : '#d97706',
              padding: '6px 14px',
              borderRadius: '20px',
              fontSize: '12px',
              fontWeight: '600',
              textTransform: 'uppercase',
            }}>
              {proyecto.estado}
            </span>
          </div>

          <div style={{ marginBottom: '20px' }}>
            <h3 style={{ fontSize: '14px', fontWeight: '600', marginBottom: '8px' }}>Descripción</h3>
            <p style={{ fontSize: '14px', color: 'var(--text-light)', lineHeight: '1.7' }}>{proyecto.descripcion}</p>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px', marginBottom: '20px' }}>
            <div>
              <h3 style={{ fontSize: '14px', fontWeight: '600', marginBottom: '8px' }}>Requisitos</h3>
              <p style={{ fontSize: '14px', color: 'var(--text-light)' }}>{proyecto.requisitos_especificos}</p>
            </div>
            <div>
              <h3 style={{ fontSize: '14px', fontWeight: '600', marginBottom: '8px' }}>Habilidades</h3>
              <p style={{ fontSize: '14px', color: 'var(--text-light)' }}>{proyecto.habilidades_requeridas}</p>
            </div>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
            <div>
              <h3 style={{ fontSize: '14px', fontWeight: '600', marginBottom: '8px' }}>Categoría</h3>
              <p style={{ fontSize: '14px', color: 'var(--text-light)' }}>{proyecto.categoria}</p>
            </div>
            <div>
              <h3 style={{ fontSize: '14px', fontWeight: '600', marginBottom: '8px' }}>Duración</h3>
              <p style={{ fontSize: '14px', color: 'var(--text-light)' }}>{proyecto.duracion_estimada_dias} días</p>
            </div>
          </div>
        </div>

        <div>
          <div style={{ background: 'white', borderRadius: '12px', padding: '25px', boxShadow: '0 1px 3px rgba(0,0,0,0.1)', marginBottom: '20px' }}>
            <h3 style={{ fontSize: '16px', fontWeight: '700', marginBottom: '20px' }}>Análisis de Calidad</h3>
            
            <div style={{ textAlign: 'center', marginBottom: '25px' }}>
              <div style={{
                width: '100px',
                height: '100px',
                borderRadius: '50%',
                background: getScoreBg(calidad.porcentaje),
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                margin: '0 auto 10px',
                border: `4px solid ${getScoreColor(calidad.porcentaje)}`,
              }}>
                <span style={{ fontSize: '28px', fontWeight: '800', color: getScoreColor(calidad.porcentaje) }}>
                  {calidad.porcentaje}%
                </span>
              </div>
              <p style={{ fontSize: '14px', color: 'var(--text-light)' }}>
                {calidad.puede_publicarse ? '✅ Aprobado' : '❌ No aprobado'}
              </p>
            </div>

            <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
              {Object.entries(calidad.detalles || {}).map(([key, item]) => (
                <div key={key} style={{ display: 'flex', justifyContent: 'space-between', fontSize: '13px' }}>
                  <span style={{ color: 'var(--text-light)' }}>{item.descripcion}</span>
                  <span style={{ color: item.ok ? '#10b981' : '#ef4444', fontWeight: '600' }}>
                    {getIcon(item.ok)}
                  </span>
                </div>
              ))}
            </div>
          </div>

          {proyecto.estado === 'pendiente' && (
            <form method="POST" action={`/admin/proyectos/${proyecto.id}/estado`}>
              <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').content} />
              <div style={{ display: 'flex', flexDirection: 'column', gap: '10px' }}>
                <button
                  name="estado"
                  value="aprobado"
                  className="btn-submit"
                  style={{ background: '#10b981' }}
                >
                  ✅ Aprobar Proyecto
                </button>
                <button
                  name="estado"
                  value="rechazado"
                  className="btn-submit"
                  style={{ background: '#ef4444' }}
                >
                  ❌ Rechazar Proyecto
                </button>
              </div>
            </form>
          )}
        </div>
      </div>
    </div>
  );
}