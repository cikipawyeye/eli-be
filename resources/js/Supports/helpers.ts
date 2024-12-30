import { TYPE, useToast } from 'vue-toastification';
import { ToastOptions } from 'vue-toastification/dist/types/types';

export function debounce<T extends (...args: any[]) => void>(
    fn: T,
    wait = 500,
) {
    let timer: ReturnType<typeof setTimeout> | undefined;

    return function (this: ThisParameterType<T>, ...args: Parameters<T>) {
        if (timer) {
            clearTimeout(timer); // clear any pre-existing timer
        }

        const context = this; // get the current context
        timer = setTimeout(() => {
            fn.apply(context, args); // call the function if time expires
        }, wait);
    };
}

export function rowNumber(index: number, from: number | undefined = 0) {
    return from ? from + index : 1 + index;
}

const toast = useToast();

export function flashSuccess(
    message: string,
    config: ToastOptions & {
        type?: TYPE.INFO;
    } = {},
) {
    toast.info(message, {
        timeout: 5000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: 'button',
        icon: 'fas fa-circle-check',
        rtl: false,
        ...config,
    });
}

export function flashWarning(
    message: string,
    config: ToastOptions & {
        type?: TYPE.WARNING;
    } = {},
) {
    toast.warning(message, {
        timeout: 5000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: 'button',
        rtl: false,
        ...config,
    });
}

export function flashError(
    message: string,
    config: ToastOptions & {
        type?: TYPE.ERROR;
    } = {},
) {
    toast.error(message, {
        timeout: 5000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: 'button',
        rtl: false,
        ...config,
    });
}
