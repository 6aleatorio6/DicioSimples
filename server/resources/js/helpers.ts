import { Ref, ref } from 'vue';

export function executeWithDelay(cb: () => void, delay = 300) {
    const self = executeWithDelay as any;
    if (self.timeout) clearTimeout(self.timeout);
    self.timeout = setTimeout(() => cb(), delay);
}

export function capWord(word: string): string {
    return word.charAt(0).toUpperCase() + word.slice(1);
}

export function useToggle(initial = false): [Ref<boolean>, () => any] {
    const value = ref(initial);
    return [value, () => (value.value = !value.value)];
}
