import React from 'react';

export default function EmailLayout({ 
  children, 
  title = 'Notificación - SENA',
  headerIcon = '✉️',
  headerTitle,
  headerSubtitle 
}) {
  return (
    <!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>{title}</title>
    </head>
    <body style={{
      fontFamily: "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif",
      backgroundColor: '#f8fafc',
      margin: 0,
      padding: '40px 20px',
      color: '#1e293b'
    }}>
      <table width="100%" cellPadding="0" cellSpacing="0" border="0" style={{ backgroundColor: '#f8fafc', width: '100%' }}>
        <tbody>
          <tr>
            <td align="center">
              <table width="100%" cellPadding="0" cellSpacing="0" border="0" style={{
                maxWidth: '600px',
                width: '100%',
                backgroundColor: '#ffffff',
                borderRadius: '16px',
                overflow: 'hidden',
                boxShadow: '0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01)',
                margin: '0 auto',
                border: '1px solid #f1f5f9'
              }}>
                <tbody>
                  <tr>
                    <td align="center" style={{
                      background: 'linear-gradient(135deg, #047857 0%, #10b981 100%)',
                      padding: '45px 20px',
                      borderBottom: '3px solid #065f46'
                    }}>
                      <div style={{ fontSize: '42px', marginBottom: '12px', lineHeight: 1 }}>{headerIcon}</div>
                      <h1 style={{
                        color: '#ffffff',
                        fontSize: '24px',
                        fontWeight: 700,
                        margin: 0,
                        padding: 0,
                        letterSpacing: '-0.5px'
                      }}>
                        {headerTitle}
                      </h1>
                      {headerSubtitle && (
                        <p style={{ color: '#d1fae5', fontSize: '15px', margin: '8px 0 0 0', fontWeight: 500 }}>
                          {headerSubtitle}
                        </p>
                      )}
                    </td>
                  </tr>
                  <tr>
                    <td style={{ padding: '40px 35px', backgroundColor: '#ffffff' }}>
                      {children}
                    </td>
                  </tr>
                  <tr>
                    <td style={{ padding: '0 35px 35px 35px', backgroundColor: '#ffffff' }}>
                      <div style={{
                        backgroundColor: '#f8fafc',
                        borderRadius: '12px',
                        padding: '20px',
                        textAlign: 'center',
                        border: '1px solid #e2e8f0'
                      }}>
                        <p style={{ margin: '0 0 8px 0', fontSize: '13px', color: '#64748b', lineHeight: 1.5 }}>
                          Si no realizaste esta acción o desconoces este correo, ignóralo de forma segura.
                        </p>
                        <p style={{ margin: 0, fontSize: '14px', fontWeight: 600, color: '#0f172a' }}>
                          Equipo Bolsa de Proyecto — Inspírate SENA
                        </p>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <table width="100%" cellPadding="0" cellSpacing="0" border="0" style={{ maxWidth: '600px', width: '100%', margin: '0 auto' }}>
                <tbody>
                  <tr>
                    <td align="center" style={{ padding: '24px 0' }}>
                      <p style={{ fontSize: '12px', color: '#94a3b8', margin: 0, fontWeight: 500 }}>
                        &copy; {new Date().getFullYear()} SENA. Todos los derechos reservados.
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
    </body>
    </html>
  );
}