export function executeWithDelay<T extends any[]>(
    cb: (...args: T) => void,
    delay = 250,
) {
    return (...args: T) => {
        const self = executeWithDelay as any;
        if (self.timeout) clearTimeout(self.timeout);
        self.timeout = setTimeout(() => cb(...args), delay);
    };
}

export function capWord(word: string): string {
    return word.charAt(0).toUpperCase() + word.slice(1);
}
