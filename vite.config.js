import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: 'localhost',
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/admin-audit.js',
                'resources/js/bootstrap.js',
                'resources/js/dashboard.js',
                'resources/js/realtime.js',
                'resources/js/forms.js',
                'resources/js/login.js',
                'resources/js/maps.js',
                'resources/js/chat.js',
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/aprendiz.css',
                'resources/css/auth_forms.css',
                'resources/css/cards-enhanced.css',
                'resources/css/dashboard.css',
                'resources/css/empresa.css',
                'resources/css/index.css',
                'resources/css/instructor.css',
                'resources/css/login.css',
                'resources/css/nosotros.css',
                'resources/css/register.css',
                'resources/css/notificaciones.css',
                'resources/css/soporte.css',
                'resources/css/chat.css'
            ],
            refresh: true,
        }),
    ],
});
