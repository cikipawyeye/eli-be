import messages from '@intlify/unplugin-vue-i18n/messages';
import { createI18n } from 'vue-i18n';

export default createI18n({
    legacy: false,
    locale: document.documentElement.lang,
    fallbackLocale: 'en',
    globalInjection: true,
    messages,
});
