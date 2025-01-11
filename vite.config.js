import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.jsx",
                "public/assets/scss/app.scss",
                "public/assets/scss/pages/auth.scss",
                "public/assets/scss/pages/datatables.scss",
                "public/assets/scss/pages/error.scss",
                "public/assets/js/bootstrap.min.js",
                "public/assets/js/popper.min.js",
            ],
            refresh: true,
        }),
        react(),
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
