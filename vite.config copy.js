import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        //host: '192.168.10.147', // Hace que el servidor sea accesible desde todos los dispositivos en la red local
        host: '192.168.10.172', // Hace que el servidor sea accesible desde todos los dispositivos en la red local
        port: 5173, // El puerto en el que Vite servirá tu aplicación
    },
});
