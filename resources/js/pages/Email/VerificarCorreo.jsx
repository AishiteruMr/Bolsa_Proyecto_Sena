import React from 'react';

export default function VerificarCorreo({ nombre, verificationUrl }) {
  const styles = {
    container: {
      fontFamily: "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif",
      background: "#f8fafc",
      padding: "40px 20px",
      minHeight: "100vh"
    },
    mainCard: {
      maxWidth: "600px",
      margin: "0 auto",
      background: "#ffffff",
      borderRadius: "16px",
      overflow: "hidden",
      boxShadow: "0 10px 25px -5px rgba(0, 0, 0, 0.05)",
      border: "1px solid #f1f5f9"
    },
    header: {
      background: "linear-gradient(135deg, #047857 0%, #10b981 100%)",
      padding: "45px 20px",
      textAlign: "center",
      borderBottom: "3px solid #065f46"
    },
    headerIcon: { fontSize: "42px", marginBottom: "12px" },
    headerTitle: { color: "#ffffff", fontSize: "24px", fontWeight: 700, margin: 0 },
    headerSubtitle: { color: "#d1fae5", fontSize: "15px", margin: "8px 0 0 0" },
    content: { padding: "40px 35px" },
    greeting: { fontSize: "16px", color: "#334155", margin: "0 0 20px 0" },
    text: { fontSize: "15px", color: "#475569", lineHeight: 1.6, margin: "0 0 16px 0" },
    buttonWrapper: { textAlign: "center", marginBottom: "30px" },
    button: {
      display: "inline-block",
      background: "linear-gradient(135deg, #047857 0%, #10b981 100%)",
      color: "#ffffff",
      textDecoration: "none",
      padding: "14px 32px",
      borderRadius: "30px",
      fontWeight: 600,
      fontSize: "15px"
    },
    warningBox: {
      background: "#fffbeb",
      borderLeft: "4px solid #f59e0b",
      padding: "16px",
      borderRadius: "8px",
      marginBottom: "24px"
    },
    warningText: { margin: 0, fontSize: "14px", color: "#b45309", lineHeight: 1.5 },
    footerBox: {
      background: "#f8fafc",
      padding: "20px",
      borderRadius: "12px",
      textAlign: "center",
      border: "1px solid #e2e8f0"
    },
    footerText: { margin: 0, fontSize: "13px", color: "#64748b" }
  };

  return (
    <div style={styles.container}>
      <div style={styles.mainCard}>
        <div style={styles.header}>
          <div style={styles.headerIcon}>✉️</div>
          <h1 style={styles.headerTitle}>Verifica tu correo</h1>
          <p style={styles.headerSubtitle}>Paso final para activar tu cuenta</p>
        </div>
        
        <div style={styles.content}>
          <p style={styles.greeting}>
            Hola <strong style={{ color: "#0f172a" }}>{nombre}</strong>,
          </p>
          
          <p style={styles.text}>
            Gracias por registrarte en la <strong>Bolsa de Proyecto SENA</strong>. Para proteger tu seguridad y asegurar que este correo te pertenece, necesitamos que lo verifiques.
          </p>
          
          <p style={{ ...styles.text, marginBottom: "30px" }}>
            Haz clic en el siguiente botón para confirmar tu correo electrónico:
          </p>
          
          <div style={styles.buttonWrapper}>
            <a href={verificationUrl} style={styles.button}>
              ✅ Verificar Correo Electrónico
            </a>
          </div>
          
          <div style={styles.warningBox}>
            <p style={styles.warningText}>
              <strong>Importante:</strong> Este enlace de verificación expirará en <strong>60 minutos</strong> por razones de seguridad.
            </p>
          </div>
          
          <p style={{ fontSize: "14px", color: "#64748b", lineHeight: 1.6, margin: 0 }}>
            Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:<br />
            <a href={verificationUrl} style={{ color: "#047857", textDecoration: "underline", wordBreak: "break-all", marginTop: "5px", display: "inline-block" }}>
              {verificationUrl}
            </a>
          </p>
        </div>
        
        <div style={{ padding: "0 35px 35px 35px" }}>
          <div style={styles.footerBox}>
            <p style={styles.footerText}>
              Si no realizaste esta acción o desconoces este correo, ignóralo de forma segura.
            </p>
            <p style={{ margin: "8px 0 0 0", fontSize: "14px", fontWeight: 600, color: "#0f172a" }}>
              Equipo Bolsa de Proyecto — Inspírate SENA
            </p>
          </div>
        </div>
      </div>
      
      <div style={{ textAlign: "center", padding: "24px 0" }}>
        <p style={{ fontSize: "12px", color: "#94a3b8", margin: 0 }}>
          © {new Date().getFullYear()} SENA. Todos los derechos reservados.
        </p>
      </div>
    </div>
  );
}