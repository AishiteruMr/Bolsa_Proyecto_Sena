import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Index() {
  const { props } = usePage();
  const { totalProyectos, totalEmpresas, totalAprendices } = props;

  return (
    <>
      <nav className="navbar">
        <a href="/" className="logo">
          <img src="/assets/logo.png" alt="SENA" />
          <span>Inspírate<br />SENA</span>
        </a>
        <div className="menu">
          <a href="/nosotros">Nosotros</a>
          <a href="/login" className="btn-login">Iniciar Sesión</a>
        </div>
      </nav>

      <main>
        <section className="hero-section">
          <div className="hero-bg-blobs">
            <div className="hero-blob" style={{ top: '-100px', right: '-100px' }}></div>
            <div className="hero-blob" style={{ bottom: '-100px', left: '-100px', background: 'rgba(59,130,246,0.1)' }}></div>
          </div>

          <div className="hero-layout">
            <div className="hero-content">
              <div className="hero-badge">
                <i className="fas fa-bolt" style={{ marginRight: '6px' }}></i> Portal de Innovación
              </div>
              <h1 className="hero-title">
                Conectamos <span>Talento</span> con<br /><span>Empresa</span>
              </h1>
              <p className="hero-desc">
                La plataforma definitiva donde aprendices e instructores colaboran en proyectos reales que transforman el ecosistema empresarial de Colombia.
              </p>
              <div className="hero-actions">
                <Link href="/login" className="btn btn-primary">
                  Comenzar Ahora <i className="fas fa-rocket" style={{ marginLeft: '10px' }}></i>
                </Link>
                <Link href="/nosotros" className="btn btn-outline">
                  Ver Nosotros <i className="fas fa-arrow-right" style={{ marginLeft: '10px' }}></i>
                </Link>
              </div>
            </div>

            <div className="hero-visual">
              <div className="hero-image-wrapper">
                <img src="/assets/sena1.png" alt="SENA" />
              </div>
            </div>
          </div>
        </section>

        <section className="bento-grid">
          <div className="bento-item bento-stats">
            <div style={{ textAlign: 'center' }}>
              <div style={{ fontSize: '64px', fontWeight: 900, color: 'var(--primary)', lineHeight: 1 }}>{totalProyectos}</div>
              <div style={{ color: 'var(--text-light)', fontSize: '13px', fontWeight: 600, textTransform: 'uppercase' }}>Proyectos</div>
            </div>
            <div style={{ textAlign: 'center' }}>
              <div style={{ fontSize: '64px', fontWeight: 900, color: 'var(--secondary)', lineHeight: 1 }}>{totalEmpresas}</div>
              <div style={{ color: 'var(--text-light)', fontSize: '13px', fontWeight: 600, textTransform: 'uppercase' }}>Empresas</div>
            </div>
            <div style={{ textAlign: 'center' }}>
              <div style={{ fontSize: '64px', fontWeight: 900, color: 'var(--primary)', lineHeight: 1 }}>{totalAprendices}</div>
              <div style={{ color: 'var(--text-light)', fontSize: '13px', fontWeight: 600, textTransform: 'uppercase' }}>Aprendices</div>
            </div>
          </div>

          <div className="bento-item" style={{ background: 'linear-gradient(145deg, #ffffff 0%, #f0fdf4 100%)' }}>
            <div className="bento-icon" style={{ background: 'linear-gradient(135deg, var(--primary), #059669)', color: '#fff' }}>
              <i className="fas fa-building"></i>
            </div>
            <h3>Empresas</h3>
            <p>Encuentra soluciones innovadoras para tus desafíos técnicos encargando proyectos a equipos de aprendices calificados.</p>
            <Link href="/registro/empresa" className="btn btn-primary">
              Registrar empresa <i className="fas fa-arrow-right"></i>
            </Link>
          </div>

          <div className="bento-item" style={{ background: 'linear-gradient(145deg, #ffffff 0%, #fffbeb 100%)' }}>
            <div className="bento-icon" style={{ background: 'linear-gradient(135deg, #f59e0b, #d97706)', color: '#fff' }}>
              <i className="fas fa-chalkboard-teacher"></i>
            </div>
            <h3>Instructores</h3>
            <p>Lidera el desarrollo de competencias prácticas guiando a los aprendices en la ejecución de proyectos de alto valor.</p>
            <Link href="/registro/instructor" className="btn btn-primary">
              Unirme como guía <i className="fas fa-arrow-right"></i>
            </Link>
          </div>

          <div className="bento-item" style={{ background: 'linear-gradient(145deg, #ffffff 0%, #eff6ff 100%)' }}>
            <div className="bento-icon" style={{ background: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff' }}>
              <i className="fas fa-user-graduate"></i>
            </div>
            <h3>Aprendices</h3>
            <p>Participa en retos reales, adquiere experiencia certificable y conecta directamente con empresas aliadas.</p>
            <Link href="/registro/aprendiz" className="btn btn-primary">
              Postular talento <i className="fas fa-arrow-right"></i>
            </Link>
          </div>
        </section>

        <section className="cta-section">
          <h2>¿Listo para transformar el futuro?</h2>
          <p>Únete hoy a la mayor comunidad de innovación técnica.</p>
          <Link href="/login" className="btn btn-primary">
            Comenzar Ahora <i className="fas fa-rocket"></i>
          </Link>
        </section>
      </main>

      <footer className="footer">
        <div className="footer-col">
          <h3>Bolsa de Proyectos</h3>
          <p>Conectando talento con empresa.</p>
        </div>
        <div className="footer-bottom">
          © 2026 Bolsa de Proyectos SENA. Todos los derechos reservados.
        </div>
      </footer>
    </>
  );
}