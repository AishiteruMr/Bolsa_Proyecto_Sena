import React from 'react';

export function Table({ 
  data = [], 
  columns = [], 
  emptyMessage = 'No hay datos',
  loading = false,
  onRowClick,
  sortable = false,
}) {
  if (loading) {
    return (
      <div style={{ textAlign: 'center', padding: '40px' }}>
        <i className="fas fa-spinner fa-spin" style={{ fontSize: '24px', color: 'var(--primary)' }}></i>
        <p style={{ marginTop: '10px', color: 'var(--text-light)' }}>Cargando...</p>
      </div>
    );
  }

  if (!data || data.length === 0) {
    return (
      <div style={{ textAlign: 'center', padding: '60px 20px', background: 'white', borderRadius: '12px' }}>
        <div style={{ fontSize: '48px', marginBottom: '16px' }}>📭</div>
        <p style={{ color: 'var(--text-light)', fontSize: '15px' }}>{emptyMessage}</p>
      </div>
    );
  }

  return (
    <div style={{ background: 'white', borderRadius: '12px', overflow: 'hidden', boxShadow: '0 1px 3px rgba(0,0,0,0.1)' }}>
      <table style={{ width: '100%', borderCollapse: 'collapse' }}>
        <thead>
          <tr style={{ background: '#f8fafc' }}>
            {columns.map((col, i) => (
              <th 
                key={i}
                style={{
                  padding: '12px 16px',
                  textAlign: col.align || 'left',
                  fontSize: '12px',
                  fontWeight: '600',
                  color: '#64748b',
                  borderBottom: '1px solid #e2e8f0',
                }}
              >
                {col.header}
              </th>
            ))}
          </tr>
        </thead>
        <tbody>
          {data.map((row, rowIndex) => (
            <tr 
              key={rowIndex}
              onClick={() => onRowClick && onRowClick(row)}
              style={{
                borderTop: '1px solid #f1f5f9',
                cursor: onRowClick ? 'pointer' : 'default',
                transition: 'background 0.2s',
              }}
              onMouseEnter={(e) => e.currentTarget.style.background = '#f8fafc'}
              onMouseLeave={(e) => e.currentTarget.style.background = 'white'}
            >
              {columns.map((col, colIndex) => (
                <td 
                  key={colIndex}
                  style={{
                    padding: '14px 16px',
                    textAlign: col.align || 'left',
                    fontSize: '14px',
                  }}
                >
                  {col.render ? col.render(row) : row[col.key]}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export function TablePagination({ links = [], current }) {
  if (!links || links.length <= 3) return null;

  return (
    <div style={{ display: 'flex', justifyContent: 'center', gap: '8px', marginTop: '20px' }}>
      {links.map((link, i) => (
        <a
          key={i}
          href={link.url}
          dangerouslySetInnerHTML={{ __html: link.label }}
          style={{
            padding: '8px 14px',
            borderRadius: '6px',
            background: link.active ? 'var(--primary)' : 'transparent',
            color: link.active ? 'white' : 'var(--text)',
            textDecoration: 'none',
            fontSize: '13px',
            fontWeight: '600',
          }}
        />
      ))}
    </div>
  );
}

export default { Table, TablePagination };
}