import React from 'react';

export default function PostulacionEstado({ 
  aprendizNombre, 
  proyectoTitulo, 
  nuevoEstado 
}) {
  const isAceptada = nuevoEstado?.toLowerCase() === 'aceptada';
  
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
      background: isAceptada ? "linear-gradient(135deg, #047857 0%, #10b981 100%)" : "linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%)",
      padding: "45px 20px",
      textAlign: "center",
      borderBottom: "3px solid #065f46"
    },
    headerIcon: { fontSize: "42px", marginBottom: "12px" },
    headerTitle: { color: "#ffffff", fontSize: "24px", fontWeight: 700, margin: 0 },
    headerSubtitle: { color: "#d1fae5", fontSize: "15px", margin: "8px 0 0 0" },
    content: { padding: "40px 35px" },
    greeting: { fontSize: "16px", color: "#334155", margin: "0 0 20px 0" },
    text: { fontSize: "15px", color: "#475569", lineHeight: 1.7, margin: "0 0 24px 0" },
    actionBox: {
      background: isAceptada ? "#f0fdf4" : "#fffbeb",
      border: `1px solid ${isAceptada ? '#bbf7d0' : '#fef3c7'}`,
      borderRadius: "12px",
      padding: "24px",
      marginBottom: "30px"
    },
    actionTitle: { 
      fontSize: "14px", 
      color: isAceptada ? "#166534" : "#92400e", 
      fontWeight: 700, 
      margin: "0 0 12px 0" 
    },
    actionList: { 
      margin: 0, 
      paddingLeft: "20px", 
      color: isAceptada ? "#14532d" : "#78350f", 
      fontSize: "14px", 
      lineHeight: 2 
    },
    buttonWrapper: { textAlign: "center" },
    button: {
      display: "inline-block",
      background: isAceptada ? "linear-gradient(135deg, #047857 0%, #10b981 100%)" : "linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%)",
      color: "#ffffff",
      textDecoration: "none",
      padding: "14px 32px",
      borderRadius: "30px",
      fontWeight: 600,
      fontSize: "15px"
    },
    projectMeta: { marginTop: "30px", paddingTop: "20px", borderTop: "1px solid #f1f5f9", textAlign: "center" },
    projectMetaText: { fontSize: "13px", color: "#94a3b8", margin: 0 },
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
          <div style={styles.headerIcon}>{isAceptada ? '🎉' : '📬'}</div>
          <h1 style={styles.headerTitle}>
            {isAceptada ? '¡Postulación Aprobada!' : 'Postulación No Aprobada'}
          </h1>
          <p style={styles.headerSubtitle}>
            {isAceptada ? '¡Felicitaciones! Has sido seleccionado' : 'Gracias por tu interés en este proyecto'}
          </p>
        </div>
        
        <div style={styles.content}>
          <p style={styles.greeting}>
            Hola <strong style={{ color: "#0f172a" }}>{aprendizNombre}</strong>,
          </p>
          
          {isAceptada ? (
            <>
              <p style={styles.text}>
                ¡Excelentes noticias! Tu postulación al proyecto <strong style={{ color: "#047857" }}>{proyectoTitulo}</strong> ha sido <strong style={{ color: "#047857" }}>aprobada</strong>.
                Ya puedes acceder a los detalles completos del proyecto, etapas y hacer seguimiento desde tu panel.
              </p>
              
              <div style={styles.actionBox}>
                <p style={styles.actionTitle}>📌 ¿Qué sigue ahora?</p>
                <ul style={styles.actionList}>
                  <li>Ingresa a tu panel de aprendiz.</li>
                  <li>Revisa las etapas definidas para el proyecto.</li>
                  <li>Sube tus evidencias a medida que avances.</li>
                  <li>El instructor asignado calificará tu progreso.</li>
                </ul>
              </div>
              
              <div style={styles.buttonWrapper}>
                <a href="/aprendiz/proyectos/aprobados" style={styles.button}>
                  🚀 Ver Mi Proyecto
                </a>
              </div>
            </>
          ) : (
            <>
              <p style={styles.text}>
                Lamentamos informarte que tu postulación al proyecto <strong>{proyectoTitulo}</strong> no ha sido seleccionada en esta ocasión.
              </p>
              
              <div style={styles.actionBox}>
                <p style={styles.actionTitle}>💪 ¡No te desanimes!</p>
                <p style={{ fontSize: "14px", color: "#78350f", lineHeight: 1.6, margin: 0 }}>
                  Hay muchos proyectos disponibles esperando por talentos como el tuyo en nuestra plataforma. Te invitamos a seguir explorando nuevas oportunidades y a postularte en aquellas que se ajusten a tu perfil.
                </p>
              </div>
              
              <div style={styles.buttonWrapper}>
                <a href="/aprendiz/proyectos" style={styles.button}>
                  🔍 Explorar Más Proyectos
                </a>
              </div>
            </>
          )}
          
          <div style={styles.projectMeta}>
            <p style={styles.projectMetaText}>Proyecto: <strong>{proyectoTitulo}</strong></p>
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