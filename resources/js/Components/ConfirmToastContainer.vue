<script setup>
import ConfirmToast from '@/Components/ConfirmToast.vue';
import { useConfirmToast } from '@/Composables/useConfirmToast';

const { toasts, resolve, dismiss, expire } = useConfirmToast();
</script>

<template>
    <Teleport to="body">
        <div
            v-if="toasts.length"
            class="fixed bottom-6 right-6 z-50 flex flex-col-reverse gap-3 pointer-events-none"
        >
            <TransitionGroup
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="translate-y-4 opacity-0 scale-95"
                enter-to-class="translate-y-0 opacity-100 scale-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="translate-y-0 opacity-100 scale-100"
                leave-to-class="translate-y-2 opacity-0 scale-95"
                move-class="transition duration-300 ease-in-out"
            >
                <ConfirmToast
                    v-for="toast in toasts"
                    :key="toast.id"
                    :toast="toast"
                    @confirm="resolve(toast.id)"
                    @dismiss="dismiss(toast.id)"
                    @expire="expire(toast.id)"
                />
            </TransitionGroup>
        </div>
    </Teleport>
</template>
