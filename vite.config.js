import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "public/assets/scss/app.scss",
                "public/assets/scss/pages/auth.scss",
                "public/assets/scss/pages/datatables.scss",
                "public/assets/scss/pages/error.scss",
                "public/assets/js/bootstrap.min.js",
                "public/assets/js/popper.min.js",
            ],
            refresh: true,
        }),
        vue(),
    ],
    server: {
        proxy: {
            "/placeholder": {
                target: "https://via.placeholder.com",
                changeOrigin: true,
                rewrite: (path) => path.replace(/^\/placeholder/, ""),
            },
        },
    },
});
