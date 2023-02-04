import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import.meta.glob([
    '../images/**',
    '../fonts/**',
  ]);

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const options = {
    // You can set your default options here
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin, options }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast, options)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
