import React from 'react';

export default function PostulacionExitosa({ aprendizNombre, proyecto }) {
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
    text: { fontSize: "15px", color: "#475569", lineHeight: 1.6, margin: "0 0 24px 0" },
    projectCard: {
      background: "#f8fafc",
      border: "1px solid #e2e8f0",
      borderRadius: "12px",
      padding: "24px",
      marginBottom: "24px"
    },
    projectTitle: {
      color: "#0f172a",
      fontSize: "18px",
      margin: "0 0 16px 0",
      borderBottom: "2px solid #047857",
      paddingBottom: "10px"
    },
    projectMeta: { padding: "8px 0", color: "#475569", fontSize: "14px" },
    projectLabel: { fontWeight: 600, color: "#334155" },
    projectDesc: { marginTop: "20px", paddingTop: "20px", borderTop: "1px solid #e2e8f0" },
    descLabel: { fontSize: "14px", color: "#334155", margin: "0 0 12px 0" },
    descBox: {
      background: "#ffffff",
      padding: "16px",
      borderRadius: "8px",
      borderLeft: "4px solid #047857",
      color: "#475569",
      fontSize: "14px",
      lineHeight: 1.6
    },
    requirementsSection: { marginTop: "20px" },
    reqLabel: { fontSize: "14px", color: "#334155", margin: "0 0 8px 0" },
    reqText: { fontSize: "14px", color: "#475569", margin: 0, lineHeight: 1.5 },
    statusBox: {
      background: "#fef3c7",
      border: "1px solid #fde68a",
      borderRadius: "12px",
      padding: "16px 20px",
      marginBottom: "30px",
      textAlign: "center"
    },
    statusText: { margin: 0, color: "#92400e", fontSize: "15px", fontWeight: 600 },
    statusBadge: {
      background: "#f59e0b",
      color: "#ffffff",
      padding: "4px 12px",
      borderRadius: "20px",
      fontSize: "12px",
      display: "inline-block",
      marginLeft: "8px"
    },
    statusNote: {
      margin: "8px 0 0 0",
      color: "#92400e",
      opacity: 0.8,
      fontSize: "13px"
    },
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

  const formatDate = (dateStr) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
  };

  return (
    <div style={styles.container}>
      <div style={styles.mainCard}>
        <div style={styles.header}>
          <div style={styles.headerIcon}>📋</div>
          <h1 style={styles.headerTitle}>¡Postulación Enviada!</h1>
          <p style={styles.headerSubtitle}>Tu solicitud ha sido recibida correctamente</p>
        </div>
        
        <div style={styles.content}>
          <p style={styles.greeting}>
            Hola <strong style={{ color: "#047857" }}>{aprendizNombre}</strong>,
          </p>
          
          <p style={styles.text}>
            Hemos registrado exitosamente tu postulación al proyecto. A continuación, encontrarás todos los detalles de la oferta a la que has aplicado:
          </p>
          
          <div style={styles.projectCard}>
            <h2 style={styles.projectTitle}>{proyecto?.titulo}</h2>
            
            <div style={styles.projectMeta}>
              <span style={{
                display: "inline-block",
                backgroundColor: "#047857",
                color: "#ffffff",
                borderRadius: "20px",
                padding: "4px 12px",
                fontSize: "12px",
                fontWeight: 600,
                letterSpacing: "0.5px"
              }}>
                {proyecto?.categoria}
              </span>
            </div>
            
            <div style={styles.projectMeta}>
              🏢 <span style={styles.projectLabel}>Empresa:</span> {proyecto?.nombre}
            </div>
            
            {proyecto?.pro_ubicacion && (
              <div style={styles.projectMeta}>
                📍 <span style={styles.projectLabel}>Ubicación:</span> {proyecto?.pro_ubicacion}
              </div>
            )}
            
            <div style={styles.projectMeta}>
              📅 <span style={styles.projectLabel}>Fecha de publicación:</span> {formatDate(proyecto?.fecha_publicacion)}
            </div>
            
            {proyecto?.fecha_finalizacion && (
              <div style={styles.projectMeta}>
                🏁 <span style={styles.projectLabel}>Fecha de finalización:</span> {formatDate(proyecto?.fecha_finalizacion)}
              </div>
            )}
            
            {proyecto?.duracion_estimada_dias && (
              <div style={styles.projectMeta}>
                ⏳ <span style={styles.projectLabel}>Duración estimada:</span> {proyecto?.duracion_estimada_dias} días
              </div>
            )}
            
            <div style={styles.projectDesc}>
              <p style={styles.descLabel}><strong>📝 Descripción:</strong></p>
              <div style={styles.projectDesc}>
                {proyecto?.descripcion}
              </div>
            </div>
            
            {proyecto?.requisitos_especificos && (
              <div style={styles.requirementsSection}>
                <p style={styles.reqLabel}><strong>📌 Requisitos Específicos:</strong></p>
                <p style={styles.reqText}>{proyecto?.requisitos_especificos}</p>
              </div>
            )}
            
            {proyecto?.habilidades_requeridas && (
              <div style={styles.requirementsSection}>
                <p style={styles.reqLabel}><strong>💡 Habilidades requeridas:</strong></p>
                <p style={styles.reqText}>{proyecto?.habilidades_requeridas}</p>
              </div>
            )}
          </div>
          
          <div style={styles.statusBox}>
            <p style={styles.statusText}>
              🕐 Estado actual: <span style={styles.statusBadge}>Pendiente</span>
            </p>
            <p style={styles.statusNote}>
              El instructor revisará tu postulación. Recibirás un correo cuando el estado cambie.
            </p>
          </div>
          
          <div style={styles.buttonWrapper}>
            <a href="/aprendiz/mis-postulaciones" style={styles.button}>
              👀 Ver Mis Postulaciones
            </a>
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