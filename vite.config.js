import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Components from "unplugin-vue-components/vite";
import { PrimeVueResolver } from "@primevue/auto-import-resolver";
import DefineOption from 'unplugin-vue-define-options/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            resolvers: [PrimeVueResolver()],
        }),
        DefineOption(),
    ],
    resolve: {
        alias: {
            '@images': '/resources/images',
        },
    },
    optimizeDeps: {
        exclude: ['oh-vue-icons/icons'],
    },
    server: {
        watch: {
            usePolling: true,
        },
    },
});
