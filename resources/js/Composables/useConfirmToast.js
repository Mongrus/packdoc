import { reactive } from 'vue';

const toasts = reactive([]);
let nextId = 0;

export function useConfirmToast() {
    function confirm({ message, onConfirm, onCancel, duration = 18000 }) {
        const id = ++nextId;

        toasts.push({
            id,
            message,
            onConfirm,
            onCancel,
            duration,
            createdAt: performance.now(),
        });

        return id;
    }

    function resolve(id) {
        const idx = toasts.findIndex(t => t.id === id);
        if (idx === -1) return;
        const toast = toasts[idx];
        toast.onConfirm?.();
        toasts.splice(idx, 1);
    }

    function dismiss(id) {
        const idx = toasts.findIndex(t => t.id === id);
        if (idx === -1) return;
        const toast = toasts[idx];
        toast.onCancel?.();
        toasts.splice(idx, 1);
    }

    function expire(id) {
        const idx = toasts.findIndex(t => t.id === id);
        if (idx === -1) return;
        toasts.splice(idx, 1);
    }

    return { toasts, confirm, resolve, dismiss, expire };
}
