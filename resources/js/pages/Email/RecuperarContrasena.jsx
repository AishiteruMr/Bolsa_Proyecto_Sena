import React from 'react';

export default function RecuperarContrasena({ nombre, enlaceRecuperacion }) {
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
    warningBox: {
      background: "#fffbeb",
      borderLeft: "4px solid #f59e0b",
      padding: "16px",
      borderRadius: "8px",
      marginBottom: "24px"
    },
    warningText: { margin: 0, fontSize: "14px", color: "#b45309", lineHeight: 1.5 },
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
    linkBox: {
      background: "#f8fafc",
      padding: "20px",
      borderRadius: "12px",
      marginBottom: "24px"
    },
    linkLabel: { fontSize: "13px", color: "#64748b", margin: "0 0 8px 0", fontWeight: 600 },
    link: { color: "#047857", textDecoration: "underline", wordBreak: "break-all", display: "inline-block", fontSize: "13px" },
    tipsSection: {
      borderTop: "1px solid #f1f5f9",
      paddingTop: "20px"
    },
    tipsTitle: { fontSize: "14px", fontWeight: 600, color: "#334155", margin: "0 0 12px 0" },
    tipsList: { margin: 0, paddingLeft: "20px", color: "#64748b", fontSize: "13px", lineHeight: 1.6 },
    footerBox: {
      background: "#f8fafc",
      padding: "20px",
      borderRadius: "12px",
      textAlign: "center",
      border: "1px solid #e2e8f0"
    },
    footerText: { margin: "0 0 8px 0", fontSize: "13px", color: "#64748b" }
  };

  return (
    <div style={styles.container}>
      <div style={styles.mainCard}>
        <div style={styles.header}>
          <div style={styles.headerIcon}>🔐</div>
          <h1 style={styles.headerTitle}>Recuperar Contraseña</h1>
          <p style={styles.headerSubtitle}>Bolsa de Proyectos SENA</p>
        </div>
        
        <div style={styles.content}>
          <p style={styles.greeting}>
            ¡Hola <strong style={{ color: "#0f172a" }}>{nombre}</strong>!
          </p>
          
          <p style={styles.text}>
            Recibimos una solicitud para recuperar la contraseña de tu cuenta. Si no realizaste esta solicitud, puedes ignorar este correo con seguridad y tu contraseña no cambiará.
          </p>
          
          <div style={styles.warningBox}>
            <p style={styles.warningText}>
              ⏳ Este enlace de recuperación expirará en <strong>30 minutos</strong>. Asegúrate de actuar rápidamente.
            </p>
          </div>
          
          <p style={{ ...styles.text, marginBottom: "30px" }}>
            Para restablecer tu contraseña nueva, haz clic en el botón de abajo:
          </p>
          
          <div style={styles.buttonWrapper}>
            <a href={enlaceRecuperacion} style={styles.button}>
              🔑 Recuperar Contraseña
            </a>
          </div>
          
          <div style={styles.linkBox}>
            <p style={styles.linkLabel}>O copia y pega este enlace en tu navegador:</p>
            <a href={enlaceRecuperacion} style={styles.link}>
              {enlaceRecuperacion}
            </a>
          </div>
          
          <div style={styles.tipsSection}>
            <p style={styles.tipsTitle}>🛡️ Consejos de seguridad:</p>
            <ul style={styles.tipsList}>
              <li style={{ marginBottom: "4px" }}>Nunca compartas este correo o el enlace con nadie.</li>
              <li style={{ marginBottom: "4px" }}>Los enlaces de recuperación son de un solo uso y expiran en 30 minutos.</li>
              <li style={{ marginBottom: "4px" }}>✅ Nota de seguridad: Este enlace no incluye tu correo en la URL para mayor seguridad.</li>
              <li>Si tuviste problemas, contáctanos a <a href="mailto:bolsadeproyectossena@gmail.com" style={{ color: "#047857" }}>bolsadeproyectossena@gmail.com</a>.</li>
            </ul>
          </div>
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