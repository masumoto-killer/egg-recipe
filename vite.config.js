import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['public/bootstrap.css', 'public/bootstrap.js'],
            refresh: true,
        }),
    ],
});
