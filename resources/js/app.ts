import './bootstrap';
import '../css/app.css';
import "vue-toastification/dist/index.css";
import 'flowbite';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import vueDebounce from 'vue-debounce';
import { createPinia } from 'pinia';
import Toast from "vue-toastification";


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const pinia = createPinia()

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .directive('debounce', vueDebounce({ lock: true }))
            .use(pinia)
            .use(Toast)
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
