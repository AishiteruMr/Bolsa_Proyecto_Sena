import React from 'react';

export default function RegistroExitoso({ nombre, apellido }) {
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
    buttonWrapper: { textAlign: "center" },
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
          <div style={styles.headerIcon}>🎉</div>
          <h1 style={styles.headerTitle}>¡Registro Exitoso!</h1>
          <p style={styles.headerSubtitle}>Bienvenido a la plataforma</p>
        </div>
        
        <div style={styles.content}>
          <p style={styles.greeting}>
            Hola <strong style={{ color: "#0f172a" }}>{nombre} {apellido}</strong>,
          </p>
          
          <p style={styles.text}>
            Nos complace informarte que tu cuenta fue creada correctamente en la <strong>Bolsa de Proyecto SENA</strong>.
          </p>
          
          <p style={{ ...styles.text, marginBottom: "30px" }}>
            Para comenzar a explorar todas las funcionalidades disponibles para tu perfil, por favor verifica tu correo electrónico con el enlace que te hemos enviado en un mensaje separado y luego inicia sesión.
          </p>
          
          <div style={styles.buttonWrapper}>
            <a href="/login" style={styles.button}>
              🚀 Iniciar Sesión
            </a>
          </div>
        </div>
        
        <div style={{ padding: "0 35px 35px 35px" }}>
          <div style={styles.footerBox}>
            <p style={styles.footerText}>
              Si no realizaste esta acción o desconocidos este correo, ignóralo de forma segura.
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