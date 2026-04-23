import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function PublicarProyecto() {
  const { props } = usePage();
  const { success } = props;
  
  const { data, setData, post, errors } = useForm({
    titulo: '',
    categoria: '',
    descripcion: '',
    requisitos: '',
    habilidades: '',
    fecha_publicacion: '',
    duracion: ''
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/empresa/publicar/post');
  };

  return (
    <div style={{ maxWidth: '900px', margin: '0 auto', paddingBottom: '40px' }}>
      <div style={{
        background: 'linear-gradient(135deg, #0a1a15, #1a2e28)',
        borderRadius: '32px',
        padding: '60px 48px',
        marginBottom: '32px',
        position: 'relative'
      }}>
        <div style={{ position: 'relative', zIndex: 1 }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '12px' }}>
            <a href="/empresa/proyectos" style={{ color: 'rgba(255,255,255,0.6)', textDecoration: 'none', fontSize: '13px', fontWeight: 600 }}>
              <i className="fas fa-arrow-left"></i> Volver
            </a>
          </div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '12px' }}>
            <span style={{
              background: 'rgba(62,180,137,0.2)',
              color: '#3eb489',
              padding: '6px 14px',
              borderRadius: '20px',
              fontSize: '11px',
              fontWeight: 700,
              textTransform: 'uppercase'
            }}>
              Nueva Convocatoria
            </span>
          </div>
          <h1 style={{ color: 'white', fontSize: '38px', fontWeight: 800 }}>
            Publicar <span style={{ color: '#3eb489' }}>Proyecto</span>
          </h1>
          <p style={{ color: 'rgba(255,255,255,0.6)', fontSize: '15px', fontWeight: 500 }}>
            Completa los campos para crear un nuevo proyecto.
          </p>
        </div>
      </div>

      {success && (
        <div style={{ 
          padding: '20px', 
          marginBottom: '24px', 
          background: '#f0fdf4', 
          border: '1px solid #bbf7d0', 
          borderRadius: '12px' 
        }}>
          <p style={{ color: '#16a34a', fontWeight: 700, margin: 0 }}>
            <i className="fas fa-check-circle"></i> {success}
          </p>
        </div>
      )}

      <form onSubmit={handleSubmit} style={{ background: 'white', borderRadius: '24px', padding: '32px', boxShadow: 'var(--shadow)' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '24px', paddingBottom: '20px', borderBottom: '1px solid rgba(62,180,137,0.1)' }}>
          <div style={{
            width: '48px',
            height: '48px',
            borderRadius: '14px',
            background: 'rgba(62,180,137,0.1)',
            color: '#3eb489',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            fontSize: '20px'
          }}>
            <i className="fas fa-file-signature"></i>
          </div>
          <div>
            <h3 style={{ fontSize: '18px', fontWeight: 800, color: 'var(--text)' }}>Detalles del Proyecto</h3>
            <p style={{ fontSize: '13px', color: 'var(--text-light)', fontWeight: 500, marginTop: '2px' }}>Completa todos los campos.</p>
          </div>
        </div>

        <div style={{ display: 'grid', gap: '20px' }}>
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
            <div>
              <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                Título del Proyecto *
              </label>
              <input
                type="text"
                value={data.titulo}
                onChange={(e) => setData('titulo', e.target.value)}
                required
                style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 600, outline: 'none' }}
              />
              {errors.titulo && <span style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px', display: 'block' }}>{errors.titulo}</span>}
            </div>
            <div>
              <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                Categoría *
              </label>
              <select
                value={data.categoria}
                onChange={(e) => setData('categoria', e.target.value)}
                required
                style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 600, outline: 'none', background: 'white' }}
              >
                <option value="">Seleccionar...</option>
                <option value="Agrícola">Agrícola</option>
                <option value="Industrial">Industrial</option>
                <option value="Tecnología">Tecnología</option>
              </select>
            </div>
          </div>

          <div>
            <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
              Descripción *
            </label>
            <textarea
              value={data.descripcion}
              onChange={(e) => setData('descripcion', e.target.value)}
              required
              rows="4"
              style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 500, outline: 'none', resize: 'vertical' }}
            />
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
            <div>
              <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                Requisitos
              </label>
              <textarea
                value={data.requisitos}
                onChange={(e) => setData('requisitos', e.target.value)}
                rows="3"
                style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 500, outline: 'none', resize: 'vertical' }}
              />
            </div>
            <div>
              <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                Habilidades
              </label>
              <textarea
                value={data.habilidades}
                onChange={(e) => setData('habilidades', e.target.value)}
                rows="3"
                style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 500, outline: 'none', resize: 'vertical' }}
              />
            </div>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
            <div>
              <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                Fecha de Publicación *
              </label>
              <input
                type="date"
                value={data.fecha_publicacion}
                onChange={(e) => setData('fecha_publicacion', e.target.value)}
                required
                style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 600, outline: 'none' }}
              />
            </div>
            <div>
              <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                Duración (días) *
              </label>
              <input
                type="number"
                value={data.duracion}
                onChange={(e) => setData('duracion', e.target.value)}
                required
                style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 600, outline: 'none' }}
              />
            </div>
          </div>
        </div>

        <div style={{ display: 'flex', gap: '16px', justifyContent: 'flex-end', marginTop: '28px', paddingTop: '24px', borderTop: '1px solid #f1f5f9' }}>
          <a
            href="/empresa/proyectos"
            style={{
              display: 'inline-flex',
              alignItems: 'center',
              gap: '10px',
              background: 'white',
              color: 'var(--text-light)',
              border: '1px solid #e2e8f0',
              padding: '14px 28px',
              borderRadius: '12px',
              fontWeight: 600,
              fontSize: '14px',
              textDecoration: 'none'
            }}
          >
            Cancelar
          </a>
          <button
            type="submit"
            style={{
              display: 'inline-flex',
              alignItems: 'center',
              gap: '10px',
              background: '#3eb489',
              color: 'white',
              border: 'none',
              padding: '14px 32px',
              borderRadius: '12px',
              fontWeight: 700,
              fontSize: '14px',
              cursor: 'pointer'
            }}
          >
            <i className="fas fa-paper-plane"></i> Publicar Proyecto
          </button>
        </div>
      </form>
    </div>
  );
}