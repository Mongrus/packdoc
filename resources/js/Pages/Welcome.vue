<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <Head title="Packdock — пакеты документов онлайн" />

    <AppLayout>
        <section class="flex flex-1 flex-col items-center justify-center px-4 py-24 text-center">
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
    </AppLayout>
</template>
