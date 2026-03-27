/**
 * Dashboard & Global UI Utilities
 */
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts
    document.querySelectorAll('.alert').forEach(el => {
        setTimeout(() => { 
            el.style.opacity = '0'; 
            el.style.transition = 'opacity .5s ease'; 
            setTimeout(() => el.remove(), 500); 
        }, 4000);
    });

    // Mobile Sidebar Toggle (if needed in future)
    const sidebar = document.querySelector('.sidebar');
    const main = document.querySelector('.main');
    
    // Smooth scroll for anchors
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Date Time Update Helper (if element exists)
    const timeEl = document.getElementById('current-time');
    if (timeEl) {
        const updateDateTime = () => {
            const now = new Date();
            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            timeEl.textContent = now.toLocaleDateString('es-ES', options);
        };
        updateDateTime();
    }
});
