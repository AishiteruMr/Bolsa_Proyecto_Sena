/**
 * Admin Module Logic
 */
function showTable(type) {
    const aprDiv = document.getElementById('aprendices');
    const insDiv = document.getElementById('instructores');
    const btnApr = document.getElementById('btn-apr');
    const btnIns = document.getElementById('btn-ins');

    if (!aprDiv || !insDiv || !btnApr || !btnIns) return;

    if (type === 'aprendices') {
        aprDiv.style.display = 'block';
        insDiv.style.display = 'none';
        btnApr.classList.add('active');
        btnApr.classList.remove('inactive');
        btnIns.classList.add('inactive');
        btnIns.classList.remove('active');
    } else {
        aprDiv.style.display = 'none';
        insDiv.style.display = 'block';
        btnIns.classList.add('active');
        btnIns.classList.remove('inactive');
        btnApr.classList.add('inactive');
        btnApr.classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Admin specific initialization
    console.log('Admin Module Loaded');
});
