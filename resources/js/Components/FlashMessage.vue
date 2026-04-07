<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    duration: { type: Number, default: 5000 },
    type:     { type: String, default: 'success' },
});

const visible = ref(true);
const progress = ref(100);
let start = null;
let raf = null;

const styles = {
    success: { bar: 'bg-green-500', border: 'border-green-200', bg: 'bg-green-50',  text: 'text-green-700' },
    info:    { bar: 'bg-blue-500',  border: 'border-blue-200',  bg: 'bg-blue-50',   text: 'text-blue-700' },
    error:   { bar: 'bg-red-500',   border: 'border-red-200',   bg: 'bg-red-50',    text: 'text-red-700' },
    warning: { bar: 'bg-yellow-500', border: 'border-yellow-200', bg: 'bg-yellow-50', text: 'text-yellow-700' },
};

const s = styles[props.type] ?? styles.success;

function tick(ts) {
    if (!start) start = ts;
    const elapsed = ts - start;
    progress.value = Math.max(0, 100 - (elapsed / props.duration) * 100);

    if (elapsed >= props.duration) {
        visible.value = false;
        return;
    }
    raf = requestAnimationFrame(tick);
}

function dismiss() {
    visible.value = false;
    if (raf) cancelAnimationFrame(raf);
}

onMounted(() => {
    raf = requestAnimationFrame(tick);
});

onUnmounted(() => {
    if (raf) cancelAnimationFrame(raf);
});
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-y-2 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="-translate-y-1 opacity-0"
    >
        <div
            v-if="visible"
            class="relative overflow-hidden rounded-lg border"
            :class="[s.border, s.bg]"
        >
            <div class="flex items-center justify-between px-4 py-3">
                <p class="text-sm font-medium" :class="s.text">
                    <slot />
                </p>
                <button
                    @click="dismiss"
                    class="ml-4 shrink-0 rounded p-0.5 transition hover:opacity-70"
                    :class="s.text"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Progress bar -->
            <div class="absolute bottom-0 left-0 h-0.5 w-full bg-black/5">
                <div
                    class="h-full transition-none"
                    :class="s.bar"
                    :style="{ width: progress + '%' }"
                />
            </div>
        </div>
    </Transition>
</template>
