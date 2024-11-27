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
        addIcons({
            name: 'contributors-badge',
            width: 50,
            height: 50,
            d: 'M25 4.6875C18.9594 4.6875 14.0625 9.58438 14.0625 15.625C14.0625 21.6656 18.9594 26.5625 25 26.5625C31.0406 26.5625 35.9375 21.6656 35.9375 15.625C35.9375 9.58438 31.0406 4.6875 25 4.6875ZM10.9375 15.625C10.9375 7.8585 17.2335 1.5625 25 1.5625C32.7665 1.5625 39.0625 7.8585 39.0625 15.625C39.0625 23.3915 32.7665 29.6875 25 29.6875C17.2335 29.6875 10.9375 23.3915 10.9375 15.625Z M14.7871 20.8822C15.5415 21.3012 15.8133 22.2525 15.3942 23.0068L7.35008 37.4871L13.162 37.459C13.1621 37.459 13.1623 37.459 13.1624 37.459C13.7058 37.4563 14.2405 37.5954 14.7138 37.8625C15.1872 38.1297 15.5827 38.5157 15.8612 38.9825L18.5627 43.5111L25.9535 27.2519C26.3106 26.4663 27.237 26.1189 28.0226 26.476C28.8082 26.8331 29.1555 27.7594 28.7984 28.545L20.1724 47.5216C19.9319 48.0509 19.4173 48.4028 18.8369 48.4351C18.2564 48.4674 17.706 48.1748 17.4081 47.6755L13.1778 40.584L4.69506 40.625C4.1401 40.6277 3.62536 40.3358 3.34276 39.8582C3.06016 39.3805 3.05211 38.7889 3.32161 38.3037L12.6624 21.4893C13.0815 20.7349 14.0327 20.4631 14.7871 20.8822Z M35.0384 20.5081C35.7933 20.0901 36.7442 20.3632 37.1622 21.1181L46.6798 38.3056C46.9485 38.7907 46.9398 39.382 46.6571 39.8591C46.3744 40.3362 45.8599 40.6277 45.3053 40.625L36.8226 40.584L32.5923 47.6755C32.2944 48.1748 31.744 48.4674 31.1635 48.4351C30.583 48.4028 30.0685 48.0508 29.8279 47.5216L23.5779 33.7716C23.2208 32.986 23.5682 32.0597 24.3538 31.7026C25.1394 31.3455 26.0657 31.6928 26.4228 32.4784L31.4377 43.5111L34.139 38.9827L34.1391 38.9825C34.4177 38.5157 34.8132 38.1297 35.2866 37.8625C35.7598 37.5954 36.2946 37.4563 36.838 37.459C36.8381 37.459 36.8382 37.459 36.8384 37.459L42.6545 37.4871L34.4284 22.6319C34.0103 21.877 34.2834 20.9261 35.0384 20.5081Z M25 10.9375C22.4112 10.9375 20.3125 13.0362 20.3125 15.625C20.3125 18.2138 22.4112 20.3125 25 20.3125C27.5888 20.3125 29.6875 18.2138 29.6875 15.625C29.6875 13.0362 27.5888 10.9375 25 10.9375ZM17.1875 15.625C17.1875 11.3103 20.6853 7.8125 25 7.8125C29.3147 7.8125 32.8125 11.3103 32.8125 15.625C32.8125 19.9397 29.3147 23.4375 25 23.4375C20.6853 23.4375 17.1875 19.9397 17.1875 15.625Z',
        });
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
