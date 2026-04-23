import React from 'react';

const colorMap = {
  pendiente: { bg: '#fff7ed', color: '#d97706', border: '#fed7aa', icon: 'fa-clock' },
  aprobda: { bg: '#f0fdf4', color: '#16a34a', border: '#bbf7d0', icon: 'fa-check-circle' },
  rechazada: { bg: '#fef2f2', color: '#dc2626', border: '#fecaca', icon: 'fa-times-circle' },
  aprobado: { bg: '#f0fdf4', color: '#16a34a', border: '#bbf7d0', icon: 'fa-check' },
  rechzo: { bg: '#fef2f2', color: '#dc2626', border: '#fecaca', icon: 'fa-times' },
  en_progreso: { bg: '#eff6ff', color: '#2563eb', border: '#bfdbfe', icon: 'fa-spinner' },
  cerrado: { bg: '#f1f5f9', color: '#64748b', border: '#e2e8f0', icon: 'fa-lock' },
  activo: { bg: '#f0fdf4', color: '#16a34a', border: '#bbf7d0', icon: 'fa-check' },
  inactivo: { bg: '#fef2f2', color: '#dc2626', border: '#fecaca', icon: 'fa-ban' },
};

const defaultColors = { bg: '#f1f5f9', color: '#64748b', border: '#e2e8f0', icon: 'fa-circle' };

export function Badge({ 
  label, 
  estado, 
  color,
  size = 'md',
  showIcon = true,
}) {
  const status = colorMap[estado?.toLowerCase()] || color || defaultColors;
  
  const sizes = {
    sm: { padding: '3px 8px', fontSize: '10px', icono: '12px' },
    md: { padding: '4px 12px', fontSize: '11px', icono: '14px' },
    lg: { padding: '6px 14px', fontSize: '12px', icono: '16px' },
  };
  
  const s = sizes[size] || sizes.md;

  return (
    <span style={{
      background: status.bg,
      color: status.color,
      padding: s.padding,
      borderRadius: '20px',
      fontSize: s.fontSize,
      fontWeight: '700',
      display: 'inline-flex',
      alignItems: 'center',
      gap: '6px',
      border: `1px solid ${status.border}`,
      textTransform: 'uppercase',
      letterSpacing: '0.5px',
    }}>
      {showIcon && <i className={`fas ${status.icon}`} style={{ fontSize: s.icono }}></i>}
      {label || estado}
    </span>
  );
}

export function StatusSelect({ value, onChange, options = ['pendiente', 'aprobada', 'rechazada'] }) {
  return (
    <select
      value={value}
      onChange={(e) => onChange(e.target.value)}
      style={{
        padding: '8px 12px',
        borderRadius: '6px',
        border: '1px solid #e2e8f0',
        background: 'white',
        fontSize: '14px',
        cursor: 'pointer',
      }}
    >
      {options.map((opt) => (
        <option key={opt} value={opt}>{opt}</option>
      ))}
    </select>
  );
}

export function ActionButtons({ onEdit, onDelete, onView, editLabel = 'Editar', deleteLabel = 'Eliminar', verLabel = 'Ver' }) {
  return (
    <div style={{ display: 'flex', gap: '8px' }}>
      {onView && (
        <button onClick={onView} className="btn-sm" title={verLabel}>
          <i className="fas fa-eye"></i>
        </button>
      )}
      {onEdit && (
        <button onClick={onEdit} className="btn-sm" title={editLabel}>
          <i className="fas fa-edit"></i>
        </button>
      )}
      {onDelete && (
        <button onClick={onDelete} className="btn-sm btn-danger" title={deleteLabel}>
          <i className="fas fa-trash"></i>
        </button>
      )}
    </div>
  );
}

export function SearchBar({ value, onChange, placeholder = 'Buscar...' }) {
  return (
    <div style={{ position: 'relative' }}>
      <i className="fas fa-search" style={{ position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)', color: '#94a3b8' }}></i>
      <input
        type="text"
        value={value}
        onChange={(e) => onChange(e.target.value)}
        placeholder={placeholder}
        style={{
          width: '100%',
          padding: '10px 12px 10px 36px',
          borderRadius: '8px',
          border: '1px solid #e2e8f0',
          fontSize: '14px',
        }}
      />
    </div>
  );
}

export default { Badge, StatusSelect, ActionButtons, SearchBar };
}