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
