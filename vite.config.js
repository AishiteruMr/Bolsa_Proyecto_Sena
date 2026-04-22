import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['public/css/app.css', 'public/css/index.css', 'resources/js/main.jsx'],
            refresh: true,
        }),
        react(),
    ],
    server: {
        hmr: {
            host: 'localhost',
            port: 5173,
            strictPort: false,
        },
        host: 'localhost',
        port: 5173,
    },
});
