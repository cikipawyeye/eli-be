import { Directive } from 'vue';

export const inputFocusDirective: Directive = {
    mounted(el) {
        const input = el.querySelector('input');
        if (!input) return;

        const handleFocus = () => {
            updateFilledClass();
            el.classList.add('focused', 'is-focused');
        };
        const handleBlur = () => {
            updateFilledClass();
            el.classList.remove('focused', 'is-focused');
        };

        const updateFilledClass = () => {
            if (input.value.trim()) {
                el.classList.add('is-filled');
            } else {
                el.classList.remove('is-filled');
            }
        };

        // Event listener
        input.addEventListener('focus', handleFocus);
        input.addEventListener('blur', handleBlur);
        input.addEventListener('input', updateFilledClass);

        el._handlers = { handleFocus, handleBlur, updateFilledClass };

        updateFilledClass();
    },
    unmounted(el) {
        const input = el.querySelector('input');
        if (!input || !el._handlers) return;

        const { handleFocus, handleBlur, updateFilledClass } = el._handlers;

        // remove event listeners
        input.removeEventListener('focus', handleFocus);
        input.removeEventListener('blur', handleBlur);
        input.removeEventListener('input', updateFilledClass);

        // prevent memory leaks
        delete el._handlers;
    },
};
