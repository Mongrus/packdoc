<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const benefits = [
    {
        text: 'Безопасность данных',
        icon: 'shield',
    },
    {
        text: 'Пакет документов за минуты',
        icon: 'stack',
    },
    {
        text: 'Готовые шаблоны под задачи',
        icon: 'template',
    },
    {
        text: 'PDF и печать одним кликом',
        icon: 'pdf',
    },
    {
        text: 'Договоры, акты, счета',
        icon: 'files',
    },
    {
        text: 'Без установки программ',
        icon: 'cloud',
    },
    {
        text: 'Фриланс и самозанятые',
        icon: 'user',
    },
    {
        text: 'Актуальные формулировки',
        icon: 'check',
    },
];
</script>

<template>
    <Head title="Packdock — пакеты документов онлайн" />

    <AppLayout>
        <section class="flex flex-col items-center justify-center px-4 pb-12 pt-20 text-center sm:pb-16 sm:pt-24">
            <div class="mx-auto max-w-3xl">
                <span class="mb-4 inline-block rounded-full bg-indigo-100 px-4 py-1 text-sm font-medium text-indigo-700">
                    Бета-версия
                </span>

                <h1 class="mt-4 text-5xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                    Документы для работы —<br />
                    <span class="text-indigo-600">за несколько минут</span>
                </h1>

                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Packdock помогает фрилансерам, самозанятым и малому бизнесу быстро собирать
                    пакеты документов: договоры, акты выполненных работ, счета и другие шаблоны.
                </p>

                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <template v-if="$page.props.auth.user">
                        <Link
                            :href="route('dashboard')"
                            class="rounded-lg bg-indigo-600 px-8 py-3 text-base font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            Продолжить работу →
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="route('register')"
                            class="rounded-lg bg-indigo-600 px-8 py-3 text-base font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            Начать бесплатно
                        </Link>
                        <Link
                            :href="route('login')"
                            class="rounded-lg border border-gray-300 bg-white px-8 py-3 text-base font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                        >
                            Войти
                        </Link>
                    </template>
                </div>
            </div>
        </section>

        <section
            class="border-y border-gray-200/80 bg-gradient-to-b from-white to-indigo-50/40 py-8"
            aria-label="Преимущества сервиса"
        >
            <div
                class="relative overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_8%,black_92%,transparent)]"
            >
                <div
                    class="welcome-marquee flex w-max items-center gap-x-10 gap-y-4 pr-10 animate-marquee motion-reduce:animate-none"
                >
                    <template v-for="pass in 2" :key="`pass-${pass}`">
                        <div
                            v-for="(item, idx) in benefits"
                            :key="`${pass}-${idx}`"
                            class="flex shrink-0 items-center gap-3 rounded-full border border-indigo-100 bg-white/90 px-5 py-2.5 shadow-sm shadow-indigo-500/5 backdrop-blur-sm"
                        >
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-indigo-600"
                                aria-hidden="true"
                            >
                                <!-- shield -->
                                <svg
                                    v-if="item.icon === 'shield'"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.75"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"
                                    />
                                </svg>
                                <!-- stack -->
                                <svg
                                    v-else-if="item.icon === 'stack'"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.75"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122"
                                    />
                                </svg>
                                <!-- template -->
                                <svg
                                    v-else-if="item.icon === 'template'"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.75"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 4.5v15m6-15v15m-10.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125Z"
                                    />
                                </svg>
                                <!-- pdf -->
                                <svg
                                    v-else-if="item.icon === 'pdf'"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.75"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"
                                    />
                                </svg>
                                <!-- files -->
                                <svg
                                    v-else-if="item.icon === 'files'"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.75"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9 9 0 0 1 9 9ZM18.75 9h1.5a1.5 1.5 0 0 0 1.5-1.5v-3A1.5 1.5 0 0 0 20.25 3h-3a1.5 1.5 0 0 0-1.5 1.5V9Z"
                                    />
                                </svg>
                                <!-- cloud -->
                                <svg
                                    v-else-if="item.icon === 'cloud'"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.75"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5h7.692a4.5 4.5 0 0 0 4.5-4.5v-1.125a4.5 4.5 0 0 0-4.5-4.5h-1.305a6 6 0 1 0-11.214 3.791A4.5 4.5 0 0 0 2.25 15Z"
                                    />
                                </svg>
                                <!-- user -->
                                <svg
                                    v-else-if="item.icon === 'user'"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.75"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                                    />
                                </svg>
                                <!-- check -->
                                <svg
                                    v-else
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.75"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                    />
                                </svg>
                            </span>
                            <span class="whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ item.text }}
                            </span>
                        </div>
                    </template>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
@media (prefers-reduced-motion: reduce) {
    .welcome-marquee {
        animation: none;
    }
}
</style>
