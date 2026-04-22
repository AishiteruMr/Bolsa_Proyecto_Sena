import React from 'react';

export default function InstructorDesasignado({ instructorNombre, proyectoTitulo, empresaNombre }) {
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
      background: "linear-gradient(135deg, #ea580c 0%, #f97316 100%)",
      padding: "45px 20px",
      textAlign: "center",
      borderBottom: "3px solid #c2410c"
    },
    headerIcon: { fontSize: "42px", marginBottom: "12px" },
    headerTitle: { color: "#ffffff", fontSize: "24px", fontWeight: 700, margin: 0 },
    headerSubtitle: { color: "#ffedd5", fontSize: "15px", margin: "8px 0 0 0" },
    content: { padding: "40px 35px" },
    greeting: { fontSize: "16px", color: "#334155", margin: "0 0 20px 0" },
    text: { fontSize: "15px", color: "#475569", lineHeight: 1.6, margin: "0 0 24px 0" },
    projectCard: {
      background: "#fffaf0",
      border: "1px solid #fbd38d",
      borderRadius: "12px",
      padding: "24px",
      marginBottom: "24px"
    },
    projectTitle: {
      color: "#0f172a",
      fontSize: "17px",
      margin: "0 0 4px 0"
    },
    projectSubtitle: { color: "#64748b", fontSize: "14px", margin: 0 },
    projectInfo: {
      background: "#ffffff",
      borderRadius: "8px",
      padding: "12px 16px",
      borderLeft: "4px solid #f6ad55"
    },
    projectInfoText: { fontSize: "13px", color: "#9c4221", margin: 0, lineHeight: 1.5 },
    infoBox: {
      background: "#f0f9ff",
      border: "1px solid #bae6fd",
      borderRadius: "12px",
      padding: "20px",
      marginBottom: "30px"
    },
    infoTitle: { fontSize: "14px", color: "#0369a1", fontWeight: 700, margin: "0 0 10px 0" },
    infoList: { margin: 0, paddingLeft: "20px", color: "#0c4a6e", fontSize: "13px", lineHeight: 1.8 },
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
    footerNote: { fontSize: "13px", color: "#94a3b8", textAlign: "center", margin: "24px 0 0 0" },
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
          <div style={styles.headerIcon}>⚠️</div>
          <h1 style={styles.headerTitle}>Desasignado de Proyecto</h1>
          <p style={styles.headerSubtitle}>El proyecto ha sido desactivado o reasignado</p>
        </div>
        
        <div style={styles.content}>
          <p style={styles.greeting}>
            Hola <strong style={{ color: "#0f172a" }}>{instructorNombre}</strong>,
          </p>
          
          <p style={styles.text}>
            Te informamos que has sido <strong style={{ color: "#ea580c" }}>desasignado</strong> del siguiente proyecto:
          </p>
          
          <div style={styles.projectCard}>
            <div style={{ marginBottom: "12px" }}>
              <h2 style={styles.projectTitle}>📁 {proyectoTitulo}</h2>
              <p style={styles.projectSubtitle}>🏢 {empresaNombre}</p>
            </div>
            
            <div style={styles.projectInfo}>
              <p style={styles.projectInfoText}>
                Este proyecto ha sido <strong>desactivado</strong> o fue reasignado a otro instructor por decisión del administrador.
              </p>
            </div>
          </div>
          
          <div style={styles.infoBox}>
            <p style={styles.infoTitle}>ℹ️ ¿Qué significa esto?</p>
            <ul style={styles.infoList}>
              <li>Ya no tienes acceso a gestionar este proyecto.</li>
              <li>Tu historial de actividad en él se conserva en la plataforma.</li>
              <li>Puedes seguir gestionando tus otros proyectos asignados normalmente.</li>
            </ul>
          </div>
          
          <div style={styles.buttonWrapper}>
            <a href="/instructor/dashboard" style={styles.button}>
              📊 Ver Mis Proyectos
            </a>
          </div>
          
          <p style={styles.footerNote}>
            Si tienes alguna duda sobre esta decisión, por favor contacta al administrador.
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