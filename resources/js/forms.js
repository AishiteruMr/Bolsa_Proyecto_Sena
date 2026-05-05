/**
 * Forms & Interactive Inputs
 */
document.addEventListener('DOMContentLoaded', function() {
    // Image Preview Utility
    const container = document.getElementById('image-upload-container');
    if (container) {
        const input = document.getElementById('imagen-input');
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');

        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Date Calculation for Projects
    const fechaPubliInput = document.getElementById('fecha_publi');
    if (fechaPubliInput) {
        const duracionInput = document.getElementById('duracion');
        const fechaFinalizacionInput = document.getElementById('fecha_finalizacion');

        function calcularFechas() {
            const fechaPubli = new Date(fechaPubliInput.value);
            if (!isNaN(fechaPubli.getTime())) {
                const fechaFinalizacion = new Date(fechaPubli);
                fechaFinalizacion.setMonth(fechaFinalizacion.getMonth() + 6);
                const duracionDias = Math.ceil((fechaFinalizacion - fechaPubli) / (1000 * 60 * 60 * 24));
                const opcionesFormato = { year: 'numeric', month: 'short', day: 'numeric' };
                duracionInput.value = duracionDias + ' días (6 meses)';
                fechaFinalizacionInput.value = fechaFinalizacion.toLocaleDateString('es-ES', opcionesFormato);
            }
        }
        fechaPubliInput.addEventListener('change', calcularFechas);
        calcularFechas();
    }
});
