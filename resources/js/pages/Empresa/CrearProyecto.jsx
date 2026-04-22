import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function CrearProyecto() {
  const { props } = usePage();
  const { categorias = [] } = props;
  
  const { data, setData, post, errors } = useForm({
    titulo: '',
    categoria: '',
    descripcion: '',
    requisitos: '',
    habilidades: '',
    fecha_publi: new Date().toISOString().split('T')[0],
    latitud: '',
    longitud: '',
    imagen: null
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/empresa/proyectos', {
      forceFormData: true
    });
  };

  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setData('imagen', file);
    }
  };

  return (
    <div style={{ maxWidth: '1200px', margin: '0 auto', paddingBottom: '40px' }}>
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
              <i className="fas fa-arrow-left"></i> Volver al Portafolio
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
          <p style={{ color: 'rgba(255,255,255,0.6)', fontSize: '16px', fontWeight: 500 }}>
            Conecta con el ecosistema de talento más grande del país.
          </p>
        </div>
      </div>

      <form onSubmit={handleSubmit} encType="multipart/form-data" style={{ background: 'white', borderRadius: '24px', overflow: 'hidden', boxShadow: 'var(--shadow)' }}>
        <div style={{
          background: 'linear-gradient(135deg, #0a1a15, #1a2e28)',
          padding: '32px 48px'
        }}>
          <h3 style={{ fontSize: '22px', fontWeight: 800, color: 'white', display: 'flex', alignItems: 'center', gap: '14px' }}>
            <i className="fas fa-file-signature" style={{ color: '#3eb489' }}></i>
            Especificaciones del Proyecto
          </h3>
          <p style={{ color: 'rgba(255,255,255,0.6)', fontSize: '14px', marginTop: '4px', fontWeight: 500 }}>
            Completa los campos
          </p>
        </div>

        <div style={{ padding: '48px', display: 'grid', gap: '48px' }}>
          <div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '24px', paddingBottom: '16px', borderBottom: '1px solid rgba(62,180,137,0.1)' }}>
              <span style={{
                width: '36px',
                height: '36px',
                borderRadius: '10px',
                background: 'rgba(62,180,137,0.1)',
                color: '#3eb489',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontWeight: 800,
                fontSize: '14px'
              }}>
                1
              </span>
              <h3 style={{ fontSize: '18px', fontWeight: 800, color: 'var(--text)' }}>Identidad y Clasificación</h3>
            </div>
            
            <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: '24px' }}>
              <div>
                <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                  Título Descriptivo
                </label>
                <div style={{ position: 'relative' }}>
                  <i className="fas fa-tag" style={{ position: 'absolute', left: '16px', top: '50%', transform: 'translateY(-50%)', color: '#94a3b8' }}></i>
                  <input
                    type="text"
                    value={data.titulo}
                    onChange={(e) => setData('titulo', e.target.value)}
                    required
                    style={{ width: '100%', padding: '14px 16px 14px 48px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 600, outline: 'none' }}
                    placeholder="Ej: Rediseño de Plataforma Logística"
                  />
                </div>
                {errors.titulo && <span style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px', display: 'block' }}>{errors.titulo}</span>}
              </div>
              <div>
                <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                  Sector Económico
                </label>
                <div style={{ position: 'relative' }}>
                  <i className="fas fa-layer-group" style={{ position: 'absolute', left: '16px', top: '50%', transform: 'translateY(-50%)', color: '#94a3b8' }}></i>
                  <select
                    value={data.categoria}
                    onChange={(e) => setData('categoria', e.target.value)}
                    required
                    style={{ width: '100%', padding: '14px 16px 14px 48px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 600, outline: 'none', background: 'white' }}
                  >
                    <option value="">Seleccionar Sector...</option>
                    <option value="Tecnología">Tecnología e Información</option>
                    <option value="Agrícola">Gestión Agrícola</option>
                    <option value="Industrial">Manufactura Industrial</option>
                    <option value="Salud">Salud y Bienestar</option>
                    <option value="Ambiental">Sostenibilidad Ambiental</option>
                    <option value="Otro">Otros Sectores</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '24px', paddingBottom: '16px', borderBottom: '1px solid rgba(62,180,137,0.1)' }}>
              <span style={{
                width: '36px',
                height: '36px',
                borderRadius: '10px',
                background: 'rgba(62,180,137,0.1)',
                color: '#3eb489',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontWeight: 800,
                fontSize: '14px'
              }}>
                2
              </span>
              <h3 style={{ fontSize: '18px', fontWeight: 800, color: 'var(--text)' }}>Definición y Requisitos</h3>
            </div>

            <div style={{ marginBottom: '24px' }}>
              <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                Memoria Descriptiva
              </label>
              <textarea
                value={data.descripcion}
                onChange={(e) => setData('descripcion', e.target.value)}
                required
                rows="5"
                style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 500, outline: 'none', resize: 'vertical' }}
                placeholder="Describe los objetivos, alcance y el impacto esperado..."
              />
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '24px' }}>
              <div>
                <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                  Perfil Técnico (Hardskills)
                </label>
                <textarea
                  value={data.requisitos}
                  onChange={(e) => setData('requisitos', e.target.value)}
                  required
                  rows="3"
                  style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 500, outline: 'none', resize: 'vertical' }}
                  placeholder="Herramientas, lenguajes o conocimientos específicos..."
                />
              </div>
              <div>
                <label style={{ display: 'block', fontSize: '12px', fontWeight: 800, color: 'var(--text-light)', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                  Cualidades de Equipo (Softskills)
                </label>
                <textarea
                  value={data.habilidades}
                  onChange={(e) => setData('habilidades', e.target.value)}
                  required
                  rows="3"
                  style={{ width: '100%', padding: '14px 16px', border: '1.5px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 500, outline: 'none', resize: 'vertical' }}
                  placeholder="Liderazgo, comunicación, resolución de problemas..."
                />
              </div>
            </div>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: '1.2fr 1fr', gap: '48px' }}>
            <div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '24px', paddingBottom: '16px', borderBottom: '1px solid rgba(62,180,137,0.1)' }}>
                <span style={{
                  width: '36px',
                  height: '36px',
                  borderRadius: '10px',
                  background: 'rgba(62,180,137,0.1)',
                  color: '#3eb489',
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'center',
                  fontWeight: 800,
                  fontSize: '14px'
                }}>
                  3
                </span>
                <h3 style={{ fontSize: '18px', fontWeight: 800, color: 'var(--text)' }}>Planificación Temporal</h3>
              </div>
              
              <div style={{ background: '#f8fafc', padding: '28px', borderRadius: '20px', border: '1.5px solid #e2e8f0', display: 'grid', gap: '20px' }}>
                <div>
                  <label style={{ display: 'block', fontSize: '11px', fontWeight: 800, color: '#64748b', textTransform: 'uppercase', letterSpacing: '0.5px', marginBottom: '8px' }}>
                    Fecha de Apertura
                  </label>
                  <div style={{ position: 'relative' }}>
                    <i className="far fa-calendar-alt" style={{ position: 'absolute', left: '16px', top: '50%', transform: 'translateY(-50%)', color: '#94a3b8' }}></i>
                    <input
                      type="date"
                      value={data.fecha_publi}
                      onChange={(e) => setData('fecha_publi', e.target.value)}
                      required
                      style={{ width: '100%', padding: '12px 16px 12px 48px', border: '1px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 600, outline: 'none', background: 'white' }}
                    />
                  </div>
                </div>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px' }}>
                  <div>
                    <label style={{ display: 'block', fontSize: '11px', fontWeight: 800, color: '#64748b', textTransform: 'uppercase', marginBottom: '8px' }}>
                      Duración
                    </label>
                    <input
                      type="text"
                      readOnly
                      value="180 días"
                      style={{ width: '100%', padding: '12px', border: '1px solid rgba(62,180,137,0.2)', borderRadius: '12px', fontSize: '14px', fontWeight: 700, color: '#3eb489', background: 'rgba(62,180,137,0.1)', textAlign: 'center' }}
                    />
                  </div>
                  <div>
                    <label style={{ display: 'block', fontSize: '11px', fontWeight: 800, color: '#64748b', textTransform: 'uppercase', marginBottom: '8px' }}>
                      Cierre
                    </label>
                    <input
                      type="text"
                      readOnly
                      placeholder="6 meses después"
                      style={{ width: '100%', padding: '12px', border: '1px solid #e2e8f0', borderRadius: '12px', fontSize: '14px', fontWeight: 700, color: 'var(--text)', background: 'white', textAlign: 'center' }}
                    />
                  </div>
                </div>
              </div>
            </div>

            <div>
              <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: '16px', marginBottom: '24px', paddingBottom: '16px', borderBottom: '1px solid rgba(62,180,137,0.1)' }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: '16px' }}>
                  <span style={{
                    width: '36px',
                    height: '36px',
                    borderRadius: '10px',
                    background: 'rgba(62,180,137,0.1)',
                    color: '#3eb489',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    fontWeight: 800,
                    fontSize: '14px'
                  }}>
                    4
                  </span>
                  <h3 style={{ fontSize: '18px', fontWeight: 800, color: 'var(--text)' }}>Localización</h3>
                </div>
                <button
                  type="button"
                  onClick={() => {
                    if (navigator.geolocation) {
                      navigator.geolocation.getCurrentPosition((position) => {
                        setData('latitud', position.coords.latitude.toString());
                        setData('longitud', position.coords.longitude.toString());
                      });
                    }
                  }}
                  style={{
                    display: 'inline-flex',
                    alignItems: 'center',
                    gap: '8px',
                    background: 'white',
                    color: '#3eb489',
                    border: '1px solid rgba(62,180,137,0.2)',
                    padding: '8px 16px',
                    borderRadius: '10px',
                    fontSize: '12px',
                    fontWeight: 700,
                    cursor: 'pointer'
                  }}
                >
                  <i className="fas fa-location-arrow"></i> GPS
                </button>
              </div>
              
              <div style={{ border: '2px dashed #e2e8f0', borderRadius: '16px', overflow: 'hidden', marginBottom: '12px', height: '180px', display: 'flex', alignItems: 'center', justifyContent: 'center', background: '#f8fafc' }}>
                <div style={{ textAlign: 'center', color: 'var(--text-light)' }}>
                  <i className="fas fa-map-marker-alt" style={{ fontSize: '32px', marginBottom: '8px', color: '#94a3b8' }}></i>
                  <p style={{ fontSize: '12px', fontWeight: 600 }}>Habilita la ubicación para marcar la sede</p>
                </div>
              </div>
              <input type="hidden" value={data.latitud} />
              <input type="hidden" value={data.longitud} />
            </div>
          </div>

          <div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '24px', paddingBottom: '16px', borderBottom: '1px solid rgba(62,180,137,0.1)' }}>
              <span style={{
                width: '36px',
                height: '36px',
                borderRadius: '10px',
                background: 'rgba(62,180,137,0.1)',
                color: '#3eb489',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontWeight: 800,
                fontSize: '14px'
              }}>
                5
              </span>
              <h3 style={{ fontSize: '18px', fontWeight: 800, color: 'var(--text)' }}>Material de Referencia</h3>
            </div>

            <div style={{
              border: '2px dashed #cbd5e1',
              borderRadius: '20px',
              padding: '60px 40px',
              textAlign: 'center',
              background: '#f8fafc',
              transition: 'all 0.3s',
              position: 'relative',
              overflow: 'hidden'
            }}>
              <div>
                <div style={{
                  width: '80px',
                  height: '80px',
                  background: 'white',
                  borderRadius: '50%',
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'center',
                  margin: '0 auto 24px',
                  boxShadow: '0 10px 25px rgba(0,0,0,0.05)'
                }}>
                  <i className="fas fa-cloud-arrow-up" style={{ fontSize: '32px', color: '#3eb489' }}></i>
                </div>
                <h4 style={{ fontSize: '18px', fontWeight: 800, color: 'var(--text)', marginBottom: '8px' }}>
                  Identity Branding del Proyecto
                </h4>
                <p style={{ fontSize: '14px', color: 'var(--text-light)', fontWeight: 500 }}>
                  Sube una imagen de alta calidad para destacar tu convocatoria.
                </p>
                <div style={{ marginTop: '20px', display: 'flex', justifyContent: 'center', gap: '12px' }}>
                  <span style={{
                    background: 'white',
                    padding: '6px 14px',
                    borderRadius: '30px',
                    border: '1px solid #e2e8f0',
                    fontSize: '11px',
                    fontWeight: 800,
                    color: '#64748b'
                  }}>
                    PNG, JPG
                  </span>
                  <span style={{
                    background: 'white',
                    padding: '6px 14px',
                    borderRadius: '30px',
                    border: '1px solid #e2e8f0',
                    fontSize: '11px',
                    fontWeight: 800,
                    color: '#64748b'
                  }}>
                    MÁX 3MB
                  </span>
                </div>
              </div>
              <input
                type="file"
                accept="image/*"
                onChange={handleImageChange}
                style={{ position: 'absolute', top: 0, left: 0, width: '100%', height: '100%', opacity: 0, cursor: 'pointer', zIndex: 5 }}
              />
            </div>
          </div>

          <div style={{ display: 'flex', gap: '20px', justifyContent: 'flex-end', paddingTop: '32px', borderTop: '2px solid #f1f5f9' }}>
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
              Descartar
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
                padding: '14px 40px',
                borderRadius: '12px',
                fontWeight: 700,
                fontSize: '14px',
                cursor: 'pointer'
              }}
            >
              <i className="fas fa-rocket"></i> Lanzar Convocatoria
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}