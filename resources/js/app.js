require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { createI18n } from 'vue-i18n';
import en from './locales/en';
import fr from './locales/fr';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const i18n = createI18n({
    locale: localStorage.getItem('tcdd:language') || 'en',
    fallbackLocale: 'fr',
    messages: {
        en,
        fr
    }
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(i18n)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
