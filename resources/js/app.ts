import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import 'filepond/dist/filepond.min.css';
import 'vue-toastification/dist/index.css';
import '../theme/scss/material-dashboard.scss';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import { Component, createApp, DefineComponent, h } from 'vue';
import vueFilePond from 'vue-filepond';
import Toast from 'vue-toastification';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { inputFocusDirective } from './Supports/Diretives/InputFocusDirective';
import translator from './Supports/translator';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const FilePond = vueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType,
);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(createPinia())
            .use(plugin)
            .use(ZiggyVue)
            .use(translator)
            .use(Toast, {
                transition: 'Vue-Toastification__fade',
                maxToasts: 20,
                newestOnTop: true,
                position: 'bottom-right',
            })
            .component('FilePond', FilePond as Component)
            .directive('input-focus', inputFocusDirective)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
