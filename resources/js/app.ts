import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import { addIcons, OhVueIcon } from "oh-vue-icons";
import * as SiIcons from "oh-vue-icons/icons/si";
import * as HiIcons from "oh-vue-icons/icons/hi";
import * as FaIcons from "oh-vue-icons/icons/fa";
import ToastService from 'primevue/toastservice'
import { i18nVue } from "laravel-vue-i18n";
import { definePreset } from "@primevue/themes";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        addIcons(...Object.values(SiIcons), ...Object.values(HiIcons), ...Object.values(FaIcons));
        createApp({ render: () => h(App, props) })
            .use(i18nVue, {
                resolve: async (lang: string) => {
                    const langs = import.meta.glob('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();
                },
            })
            .use(plugin)
            .use(PrimeVue, {
                theme: {
                    preset: definePreset(Aura, {
                        semantic: {
                            primary: {
                                '50': '#f0ffe6',
                                '100': '#dffec9',
                                '200': '#bffd99',
                                '300': '#96f85e',
                                '400': '#72ed2f',
                                '500': '#50d30f',
                                '600': '#3aa907',
                                '700': '#2f800b',
                                '800': '#28650f',
                                '900': '#245512',
                                '950': '#0e3003',
                            },
                        },
                    }),
                },
            })
            .use(ToastService)
            .use(ZiggyVue)
            .component('Icon', OhVueIcon)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
