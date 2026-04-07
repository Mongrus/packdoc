<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    package: Object,
    documents: Array,
});
</script>

<template>
    <Head title="Документы — Packdock" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Пакет документов
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

                <!-- Breadcrumbs -->
                <nav class="mb-6 flex items-center gap-2 text-sm">
                    <Link
                        :href="route('packages.index')"
                        class="text-gray-400 hover:text-gray-600 transition"
                    >
                        Мои пакеты
                    </Link>
                    <svg class="h-4 w-4 shrink-0 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <span class="font-medium text-gray-700">Документы</span>
                </nav>

                <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-gray-200">
                    <div class="h-1.5 w-full bg-gradient-to-r from-indigo-400 to-violet-400" />

                    <div class="px-8 py-8">
                        <h3 class="mb-1 text-lg font-bold text-gray-900">Ваши документы готовы</h3>
                        <p class="mb-6 text-sm text-gray-500">Нажмите «Просмотр» чтобы открыть HTML-версию документа.</p>

                        <ul class="divide-y divide-gray-100">
                            <li
                                v-for="doc in documents"
                                :key="doc.slug"
                                class="flex items-center justify-between py-4"
                            >
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50">
                                        <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm font-medium text-gray-800">{{ doc.title }}</span>
                                </div>
                                <a
                                    :href="doc.url"
                                    target="_blank"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-white px-4 py-2 text-sm font-medium text-indigo-600 ring-1 ring-indigo-200 transition hover:bg-indigo-50"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                    Просмотр
                                </a>
                            </li>
                        </ul>

                        <div class="mt-6 flex justify-end">
                            <Link
                                :href="route('packages.index')"
                                class="rounded-lg bg-gray-100 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-200"
                            >
                                &larr; К моим пакетам
                            </Link>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
