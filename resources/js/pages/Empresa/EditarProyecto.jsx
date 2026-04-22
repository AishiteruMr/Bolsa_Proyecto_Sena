import React from 'react';
import { usePage, useForm } from '@inertiajs/react';

export default function EditarProyecto() {
  const { props } = usePage();
  const proyecto = props.proyecto;

  const { data, setData, put, processing } = useForm({
    titulo: proyecto.titulo || '',
    descripcion: proyecto.descripcion || '',
    categoria: proyecto.categoria || '',
    requisitos: proyecto.requisitos_especificos || '',
    habilidades: proyecto.habilidades_requeridas || '',
    duracion: proyecto.duracion_estimada_dias || 180,
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    put(`/empresa/proyectos/${proyecto.id}`);
  };

  return (
    <div style={{ padding: '40px 20px', maxWidth: '800px', margin: '0 auto' }}>
      <a href="/empresa/proyectos" style={{ color: 'var(--primary)', textDecoration: 'none', fontSize: '14px' }}>
        ← Volver a Proyectos
      </a>

      <h1 style={{ fontSize: '28px', fontWeight: '800', margin: '20px 0' }}>
        Editar Proyecto
      </h1>

      <form onSubmit={handleSubmit} style={{ background: 'white', padding: '30px', borderRadius: '12px' }}>
        <div className="form-group" style={{ marginBottom: '20px' }}>
          <label style={{ display: 'block', marginBottom: '8px', fontWeight: '600' }}>Título</label>
          <input
            type="text"
            value={data.titulo}
            onChange={(e) => setData('titulo', e.target.value)}
            required
            style={{ width: '100%', padding: '12px', borderRadius: '6px', border: '1px solid #e2e8f0' }}
          />
        </div>

        <div className="form-group" style={{ marginBottom: '20px' }}>
          <label style={{ display: 'block', marginBottom: '8px', fontWeight: '600' }}>Descripción</label>
          <textarea
            value={data.descripcion}
            onChange={(e) => setData('descripcion', e.target.value)}
            required
            rows={4}
            style={{ width: '100%', padding: '12px', borderRadius: '6px', border: '1px solid #e2e8f0' }}
          />
        </div>

        <div className="form-group" style={{ marginBottom: '20px' }}>
          <label style={{ display: 'block', marginBottom: '8px', fontWeight: '600' }}>Categoría</label>
          <select
            value={data.categoria}
            onChange={(e) => setData('categoria', e.target.value)}
            style={{ width: '100%', padding: '12px', borderRadius: '6px', border: '1px solid #e2e8f0' }}
          >
            <option value="">Seleccionar</option>
            <option value="tecnologia">Tecnología</option>
            <option value="ingenieria">Ingeniería</option>
            <option value="salud">Salud</option>
            <option value="comercio">Comercio</option>
          </select>
        </div>

        <div style={{ display: 'flex', gap: '20px' }}>
          <button type="submit" className="btn-submit" disabled={processing}>
            {processing ? 'Guardando...' : 'Guardar Cambios'}
          </button>
          <a href="/empresa/proyectos" className="btn-submit" style={{ background: '#6b7280', textAlign: 'center' }}>
            Cancelar
          </a>
        </div>
      </form>
    </div>
  );
}