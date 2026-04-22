import React from 'react';
import { Link } from '@inertiajs/react';

export default function Nosotros() {
  return (
    <>
      <nav className="navbar">
        <Link href="/" className="logo">
          <img src="/img/logo.png" alt="SENA" />
          <span>Inspírate<br />SENA</span>
        </Link>
        <div className="menu">
          <Link href="/nosotros" className="active">Nosotros</Link>
          <Link href="/login" className="btn-login">Iniciar Sesión</Link>
        </div>
      </nav>

      <main>
        {/* Hero */}
        <section className="hero-nosotros">
          <span className="hero-badge" style={{ marginBottom: 24 }}>Nuestra Esencia</span>
          <h1>Transformando el <br /><span>Futuro del Talento</span></h1>
          <p>Somos el puente digital que conecta la pasión de los aprendices con la experiencia de los instructores y las necesidades reales del mundo empresarial.</p>
        </section>

        {/* About Grid */}
        <section className="about-grid">
          <div className="about-text">
            <h2>Misión Educativa de <span style={{ color: 'var(--primary)' }}>Impacto</span></h2>
            <p>
              En el corazón de la educación moderna se encuentra el desafío de convertir la teoría en <strong>acción tangible</strong>. Nuestra plataforma nace con la visión de crear un ecosistema donde cada proyecto sea una oportunidad de crecimiento.
            </p>
            <p>
              Diseñada como una <strong>Bolsa de Proyectos de alto impacto</strong>, conectamos a nuestra comunidad con retos de la industria, siempre bajo la guía experta de nuestros instructores.
            </p>
          </div>
          <div className="about-image">
            <img src="/assets/web1.jpg" alt="SENA" />
          </div>
        </section>

        {/* Values */}
        <section className="values-grid">
          <div className="value-card">
            <div className="value-icon">🎯</div>
            <h3>Misión</h3>
            <p>Fomentar la innovación social y económica de Colombia a través de la formación integral, capacitando ciudadanos con competencias disruptivas que respondan a los desafíos globales.</p>
          </div>
          <div className="value-card">
            <div className="value-icon">🔭</div>
            <h3>Visión</h3>
            <p>Liderar la transformación digital del talento humano en Latinoamérica, siendo reconocidos como el motor que impulsa la productividad y el desarrollo sostenible del país.</p>
          </div>
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