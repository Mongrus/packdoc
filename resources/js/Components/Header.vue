<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';

const page = usePage();
const dropdownOpen = ref(false);
const dropdownRef = ref(null);

function logout() {
    router.post(route('logout'));
}

function handleClickOutside(e) {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
        dropdownOpen.value = false;
    }
}

onMounted(() => document.addEventListener('mousedown', handleClickOutside));
onUnmounted(() => document.removeEventListener('mousedown', handleClickOutside));
</script>

<template>
    <header class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <Link :href="route('welcome')" class="flex items-center gap-2 text-xl font-bold text-gray-900 hover:text-indigo-600 transition-colors">
                <svg class="h-7 w-7 text-indigo-600" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z" opacity=".2"/>
                    <path d="M20 6H4a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h16a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3Zm1 9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v6ZM8 11H6a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2Zm10 0h-6a1 1 0 0 0 0 2h6a1 1 0 0 0 0-2Z"/>
                </svg>
                Packdock
            </Link>

            <nav class="flex items-center gap-2">
                <template v-if="page.props.auth.user">
                    <div class="relative" ref="dropdownRef">
                        <button
                            @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                        >
                            <span>{{ page.props.auth.user.name }}</span>
                            <svg
                                class="h-4 w-4 text-gray-400 transition-transform"
                                :class="{ 'rotate-180': dropdownOpen }"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <Transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="opacity-0 scale-95"
                            enter-to-class="opacity-100 scale-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="opacity-100 scale-100"
                            leave-to-class="opacity-0 scale-95"
                        >
                            <div
                                v-if="dropdownOpen"
                                class="absolute right-0 mt-1 w-52 origin-top-right rounded-xl border border-gray-100 bg-white py-1 shadow-lg ring-1 ring-black/5 z-50"
                            >
                                <div class="border-b border-gray-100 px-4 py-2">
                                    <p class="text-xs text-gray-400">Вы вошли как</p>
                                    <p class="truncate text-sm font-medium text-gray-700">{{ page.props.auth.user.email }}</p>
                                </div>

                                <Link
                                    :href="route('dashboard')"
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                                    @click="dropdownOpen = false"
                                >
                                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                    Личный кабинет
                                </Link>

                                <button
                                    @click="logout"
                                    class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                >
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    Выйти из аккаунта
                                </button>
                            </div>
                        </Transition>
                    </div>
                </template>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-md px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                    >
                        Войти
                    </Link>
                    <Link
                        :href="route('register')"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700"
                    >
                        Регистрация
                    </Link>
                </template>
            </nav>
        </div>
    </header>
</template>
