<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    toast: { type: Object, required: true },
});

const emit = defineEmits(['confirm', 'dismiss', 'expire']);

const progress = ref(100);
let start = null;
let raf = null;

function tick(ts) {
    if (!start) start = ts;
    const elapsed = ts - start;
    progress.value = Math.max(0, 100 - (elapsed / props.toast.duration) * 100);

    if (elapsed >= props.toast.duration) {
        emit('expire');
        return;
    }
    raf = requestAnimationFrame(tick);
}

onMounted(() => {
    raf = requestAnimationFrame(tick);
});

onUnmounted(() => {
    if (raf) cancelAnimationFrame(raf);
});
</script>

<template>
    <div class="pointer-events-auto relative w-full max-w-sm overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-gray-200">
        <div class="px-5 py-4">
            <div class="mb-3 flex items-start gap-3">
                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-4.5 w-4.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </span>
                <p class="text-sm leading-snug text-gray-700">
                    {{ toast.message }}
                </p>
            </div>

            <div class="flex items-center justify-end gap-2">
                <button
                    @click="$emit('dismiss')"
                    class="rounded-lg px-3.5 py-1.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100"
                >
                    Отмена
                </button>
                <button
                    @click="$emit('confirm')"
                    class="rounded-lg bg-red-600 px-3.5 py-1.5 text-sm font-medium text-white transition hover:bg-red-700"
                >
                    Удалить
                </button>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 h-1 w-full bg-gray-100">
            <div
                class="h-full bg-red-500 transition-none"
                :style="{ width: progress + '%' }"
            />
        </div>
    </div>
</template>
