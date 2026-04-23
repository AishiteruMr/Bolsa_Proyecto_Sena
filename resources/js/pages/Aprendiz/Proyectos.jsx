import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Proyectos() {
  const { props } = usePage();
  const { proyectos, postulados, categorias, filtros } = props;

  return (
    <div style={{ maxWidth: '1200px', margin: '0 auto', paddingBottom: '60px' }}>
      {/* Search Hero */}
      <div style={{
        background: 'linear-gradient(135deg, #0a1a15 0%, #1a2e28 100%)',
        borderRadius: '32px',
        padding: '60px 48px',
        marginBottom: '40px',
        position: 'relative',
        overflow: 'hidden'
      }}>
        <div style={{ position: 'absolute', right: '-30px', bottom: '-30px', fontSize: '200px', color: 'rgba(62,180,137,0.06)', transform: 'rotate(-15deg)' }}>
          <i className="fas fa-search"></i>
        </div>

        <div style={{ position: 'relative', zIndex: 1 }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '16px' }}>
            <span style={{
              background: '#3eb489',
              color: 'white',
              padding: '8px 18px',
              borderRadius: '40px',
              fontSize: '11px',
              fontWeight: 800,
              textTransform: 'uppercase'
            }}>
              Banco de Proyectos
            </span>
          </div>
          <h2 style={{ color: 'white', fontSize: '38px', fontWeight: 800, marginBottom: '12px' }}>
            Descubre tu Siguiente Desafío
          </h2>
          <p style={{ color: 'rgba(255,255,255,0.7)', fontSize: '16px', marginBottom: '40px', maxWidth: '600px' }}>
            Explora cientos de proyectos de empresas líderes buscando el talento SENA.
          </p>

          {/* Search Form */}
          <form action="/aprendiz/proyectos" method="GET" style={{ position: 'relative', maxWidth: '700px' }}>
            <i className="fas fa-search" style={{ position: 'absolute', left: '24px', top: '50%', transform: 'translateY(-50%)', color: '#94a3b8' }}></i>
            <input
              type="text"
              name="buscar"
              defaultValue={filtros?.buscar}
              placeholder="¿Qué quieres aprender hoy?"
              style={{
                width: '100%',
                padding: '20px 24px 20px 60px',
                borderRadius: '20px',
                border: 'none',
                background: 'white',
                fontSize: '15px',
                fontWeight: 600
              }}
            />
            <button
              type="submit"
              style={{
                position: 'absolute',
                right: '12px',
                top: '12px',
                bottom: '12px',
                background: 'linear-gradient(135deg, #3eb489, #2d9d74)',
                color: 'white',
                border: 'none',
                padding: '0 28px',
                borderRadius: '14px',
                fontWeight: 700,
                cursor: 'pointer'
              }}
            >
              Buscar
            </button>
          </form>
        </div>
      </div>

      {/* Category Pills */}
      <div style={{ marginBottom: '32px' }}>
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '20px' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
            <div style={{
              width: '36px',
              height: '36px',
              background: 'rgba(62,180,137,0.1)',
              borderRadius: '10px',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center'
            }}>
              <i className="fas fa-filter" style={{ color: '#3eb489' }}></i>
            </div>
            <h4 style={{ fontSize: '14px', fontWeight: 800, margin: 0 }}>Filtrar por Especialidad</h4>
            <span style={{ fontSize: '12px', color: 'var(--text-light)' }}>({categorias?.length || 0} categorías)</span>
          </div>
          {(filtros?.buscar || filtros?.categoria) && (
            <Link href="/aprendiz/proyectos" style={{ fontSize: '12px', fontWeight: 700, color: '#ef4444', textDecoration: 'none' }}>
              <i className="fas fa-times"></i> Limpiar
            </Link>
          )}
        </div>

        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '10px' }}>
          <Link
            href="/aprendiz/proyectos"
            className={`category-pill ${!filtros?.categoria ? 'active' : ''}`}
            style={{
              padding: '10px 20px',
              borderRadius: '30px',
              background: !filtros?.categoria ? 'var(--primary)' : 'white',
              color: !filtros?.categoria ? 'white' : 'var(--text)',
              border: '1px solid var(--border)',
              fontWeight: 600,
              fontSize: '13px',
              textDecoration: 'none'
            }}
          >
            Todos
          </Link>
          {categorias?.map((cat) => (
            <Link
              key={cat}
              href={`/aprendiz/proyectos?categoria=${encodeURIComponent(cat)}`}
              style={{
                padding: '10px 20px',
                borderRadius: '30px',
                background: filtros?.categoria === cat ? 'var(--primary)' : 'white',
                color: filtros?.categoria === cat ? 'white' : 'var(--text)',
                border: '1px solid var(--border)',
                fontWeight: 600,
                fontSize: '13px',
                textDecoration: 'none'
              }}
            >
              {cat}
            </Link>
          ))}
        </div>
      </div>

      {/* Projects Grid */}
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(340px, 1fr))', gap: '24px' }}>
        {proyectos?.data?.map((proyecto) => (
          <div key={proyecto.id} className="project-card" style={{ background: 'white', borderRadius: '20px', padding: '24px', boxShadow: 'var(--shadow)' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '16px' }}>
              <span style={{ background: 'var(--primary-soft)', color: 'var(--primary)', padding: '4px 12px', borderRadius: '20px', fontSize: '11px', fontWeight: 700, textTransform: 'uppercase' }}>
                {proyecto.categoria}
              </span>
              <span style={{
                padding: '4px 12px',
                borderRadius: '20px',
                fontSize: '11px',
                fontWeight: 700,
                background: proyecto.estado === 'aprobado' ? '#dcfce7' : '#fef3c7',
                color: proyecto.estado === 'aprobado' ? '#166534' : '#92400e'
              }}>
                {proyecto.estado}
              </span>
            </div>

            <h3 style={{ fontSize: '20px', fontWeight: 800, marginBottom: '12px' }}>{proyecto.titulo}</h3>
            <p style={{ fontSize: '14px', color: 'var(--text-light)', marginBottom: '20px', lineHeight: 1.6 }}>
              {proyecto.descripcion}
            </p>

            <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '20px', fontSize: '13px', color: 'var(--text-light)' }}>
              <i className="fas fa-building"></i>
              <span>{proyecto.empresa?.nombre}</span>
            </div>

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              {postulados?.includes(proyecto.id) ? (
                <span style={{ color: 'var(--primary)', fontWeight: 700, display: 'flex', alignItems: 'center', gap: '8px' }}>
                  <i className="fas fa-check-circle"></i> Postulado
                </span>
              ) : (
                <form method="POST" action={`/aprendiz/proyectos/${proyecto.id}/postular`}>
                  <input type="hidden" name="_token" value={props.csrf} />
                  <button type="submit" className="btn btn-primary" style={{ padding: '12px 24px', fontSize: '13px' }}>
                    Postularme
                  </button>
                </form>
              )}
              <Link href={`/aprendiz/proyectos/${proyecto.id}/detalle`} style={{ color: 'var(--primary)', fontWeight: 700, display: 'flex', alignItems: 'center', gap: '8px' }}>
                Ver detalle <i className="fas fa-arrow-right"></i>
              </Link>
            </div>
          </div>
        ))}
      </div>

      {/* Pagination */}
      {proyectos?.last_page > 1 && (
        <div style={{ display: 'flex', justifyContent: 'center', gap: '8px', marginTop: '40px' }}>
          {proyectos?.links?.map((link, i) => (
            <Link
              key={i}
              href={link.url || '#'}
              style={{
                padding: '10px 16px',
                borderRadius: '10px',
                background: link.active ? 'var(--primary)' : 'white',
                color: link.active ? 'white' : 'var(--text)',
                fontWeight: 600,
                textDecoration: 'none'
              }}
              dangerouslySetInnerHTML={{ __html: link.label }}
            />
          ))}
        </div>
      )}
    </div>
  );
}