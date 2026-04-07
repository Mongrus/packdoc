<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    category: Object,
});
</script>

<template>
    <Head :title="`${category.name} — Packdock`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link
                    :href="route('packages.create')"
                    class="text-gray-400 hover:text-gray-600 transition"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ category.name }}
                </h2>
            </div>
        </template>

        <div class="py-16">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

                <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-gray-200">
                    <!-- Accent bar -->
                    <div class="h-1.5 w-full bg-gradient-to-r from-indigo-400 to-violet-400" />

                    <div class="flex flex-col items-center px-8 py-14 text-center">
                        <!-- Icon -->
                        <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-indigo-50">
                            <svg class="h-10 w-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </div>

                        <h3 class="mb-2 text-xl font-bold text-gray-900">
                            Опросник в разработке
                        </h3>
                        <p class="mb-1 max-w-sm text-sm leading-relaxed text-gray-500">
                            Умные опросники для автозаполнения документов появятся в ближайшее время.
                            Категория <strong class="text-gray-700">«{{ category.name }}»</strong> уже подготовлена.
                        </p>
                        <p v-if="category.description" class="text-xs text-gray-400">
                            {{ category.description }}
                        </p>

                        <!-- Documents in this category -->
                        <div v-if="category.document_templates?.length" class="mt-8 w-full max-w-sm">
                            <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Документы, которые будут сгенерированы
                            </p>
                            <ul class="space-y-2 text-left">
                                <li
                                    v-for="tpl in category.document_templates"
                                    :key="tpl.id"
                                    class="flex items-center gap-3 rounded-lg bg-gray-50 px-4 py-2.5"
                                >
                                    <span
                                        :class="[
                                            'inline-flex items-center rounded px-1.5 py-0.5 text-[10px] font-bold uppercase',
                                            tpl.type === 'pdf' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600',
                                        ]"
                                    >
                                        {{ tpl.type }}
                                    </span>
                                    <span class="text-sm text-gray-700">{{ tpl.name }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Roadmap -->
                        <div class="mt-8 flex flex-col gap-2 w-full max-w-xs">
                            <div class="flex items-center gap-3 rounded-lg bg-green-50 px-4 py-2.5 text-left">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs font-bold">&#10003;</span>
                                <span class="text-xs text-green-700 font-medium">Категория выбрана</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-lg bg-gray-50 px-4 py-2.5 text-left">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-400 text-xs font-bold">2</span>
                                <span class="text-xs text-gray-400">Заполнение данных — скоро</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-lg bg-gray-50 px-4 py-2.5 text-left">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-400 text-xs font-bold">3</span>
                                <span class="text-xs text-gray-400">Генерация пакета документов — скоро</span>
                            </div>
                        </div>

                        <div class="mt-8 flex gap-3">
                            <Link
                                :href="route('packages.create')"
                                class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 ring-1 ring-gray-200 hover:bg-gray-50 transition"
                            >
                                &larr; Другая категория
                            </Link>
                            <Link
                                :href="route('packages.index')"
                                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition"
                            >
                                Мои пакеты
                            </Link>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
