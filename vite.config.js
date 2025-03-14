import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
        minify: 'terser', // Usa Terser para minificar
        terserOptions: {
            compress: {
                drop_console: true, // Elimina console.log
                drop_debugger: true, // Elimina debugger
                passes: 3, // Aplica múltiples pasadas de compresión
            },
            format: {
                comments: false, // Elimina comentarios
            },
            mangle: true, // Ofusca nombres de variables
        },
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'assets/app-[hash].css'; // Usa hash dinámico
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
    },
});
