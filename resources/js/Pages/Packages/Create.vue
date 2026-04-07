<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
});

const activeCategories = ['Фриланс'];
const isActive = (name) => activeCategories.includes(name);

const sortedCategories = computed(() =>
    [...props.categories].sort((a, b) => {
        const ai = activeCategories.indexOf(a.name);
        const bi = activeCategories.indexOf(b.name);
        if (ai !== -1 && bi === -1) return -1;
        if (ai === -1 && bi !== -1) return 1;
        return 0;
    }),
);

const icons = {
    'Фриланс': `<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />`,
    'Обучение / репетиторство': `<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />`,
    'Бытовые услуги': `<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.349m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016A3.001 3.001 0 0021 9.349m-18 0A2.999 2.999 0 017.5 6.75h9A2.999 2.999 0 0121 9.349" />`,
    'Строительство / подряд': `<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384 5.384a2.025 2.025 0 01-2.853-2.853l5.384-5.384m2.853 2.853l5.384-5.384a2.025 2.025 0 00-2.853-2.853l-5.384 5.384m2.853 2.853L8.586 9.172a2.025 2.025 0 112.853-2.853l4.831 4.831" />`,
    'Юридические услуги': `<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" />`,
    'Консалтинг': `<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />`,
};

const colors = {
    'Фриланс': { bg: 'bg-violet-50', text: 'text-violet-600', ring: 'hover:ring-violet-400', iconBg: 'bg-violet-100' },
    'Обучение / репетиторство': { bg: 'bg-pink-50', text: 'text-pink-600', ring: 'hover:ring-pink-400', iconBg: 'bg-pink-100' },
    'Бытовые услуги': { bg: 'bg-emerald-50', text: 'text-emerald-600', ring: 'hover:ring-emerald-400', iconBg: 'bg-emerald-100' },
    'Строительство / подряд': { bg: 'bg-orange-50', text: 'text-orange-600', ring: 'hover:ring-orange-400', iconBg: 'bg-orange-100' },
    'Юридические услуги': { bg: 'bg-amber-50', text: 'text-amber-600', ring: 'hover:ring-amber-400', iconBg: 'bg-amber-100' },
    'Консалтинг': { bg: 'bg-sky-50', text: 'text-sky-600', ring: 'hover:ring-sky-400', iconBg: 'bg-sky-100' },
};

const fallbackColor = { bg: 'bg-indigo-50', text: 'text-indigo-600', ring: 'hover:ring-indigo-400', iconBg: 'bg-indigo-100' };
const fallbackIcon = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />`;

const getColor = (name) => colors[name] ?? fallbackColor;
const getIcon = (name) => icons[name] ?? fallbackIcon;
</script>

<template>
    <Head title="Создать пакет — Packdock" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Создать пакет документов
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

                <div class="mb-8">
                    <p class="text-sm text-gray-500">
                        Выберите направление — мы подготовим полный комплект документов: договоры, акты, счета.
                    </p>
                </div>

                <!-- Empty -->
                <div
                    v-if="!categories.length"
                    class="flex flex-col items-center justify-center rounded-xl bg-white py-24 ring-1 ring-gray-200"
                >
                    <svg class="mb-4 h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Категории ещё не добавлены</p>
                </div>

                <!-- Category cards -->
                <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <template v-for="cat in sortedCategories" :key="cat.id">
                        <!-- Active card -->
                        <Link
                            v-if="isActive(cat.name)"
                            :href="route('packages.questionnaire', cat.id)"
                            class="group flex flex-col rounded-2xl bg-white p-6 ring-1 ring-gray-200 transition hover:shadow-md"
                            :class="getColor(cat.name).ring"
                        >
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl transition"
                                :class="[getColor(cat.name).iconBg]"
                            >
                                <svg
                                    class="h-6 w-6"
                                    :class="getColor(cat.name).text"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    v-html="getIcon(cat.name)"
                                />
                            </div>

                            <h3 class="mb-1.5 text-base font-bold text-gray-900">{{ cat.name }}</h3>

                            <p v-if="cat.description" class="mb-4 text-sm leading-relaxed text-gray-500">
                                {{ cat.description }}
                            </p>

                            <div v-if="cat.document_templates?.length" class="mt-auto">
                                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Документы в пакете</p>
                                <ul class="space-y-1.5">
                                    <li
                                        v-for="tpl in cat.document_templates"
                                        :key="tpl.id"
                                        class="flex items-start gap-2 text-sm text-gray-600"
                                    >
                                        <svg class="mt-0.5 h-4 w-4 shrink-0" :class="getColor(cat.name).text" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        <span>{{ tpl.name }}</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-5 flex items-center gap-1.5 text-sm font-medium" :class="getColor(cat.name).text">
                                Выбрать
                                <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </div>
                        </Link>

                        <!-- Disabled card -->
                        <div
                            v-else
                            class="group/disabled relative flex flex-col rounded-2xl bg-gray-50 p-6 ring-1 ring-gray-200 opacity-60 cursor-default select-none transition hover:opacity-80"
                        >
                            <span class="absolute top-4 right-4 inline-flex items-center rounded-full bg-gray-200 px-2.5 py-0.5 text-xs font-medium text-gray-500">
                                В разработке
                            </span>

                            <!-- Hover overlay -->
                            <div class="pointer-events-none absolute inset-0 z-10 flex items-center justify-center rounded-2xl bg-gray-900/50 opacity-0 transition group-hover/disabled:opacity-100">
                                <div class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-lg">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384 5.384a2.025 2.025 0 01-2.853-2.853l5.384-5.384m2.853 2.853l5.384-5.384a2.025 2.025 0 00-2.853-2.853l-5.384 5.384m2.853 2.853L8.586 9.172a2.025 2.025 0 112.853-2.853l4.831 4.831" />
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-700">Скоро будет доступно</span>
                                </div>
                            </div>

                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100">
                                <svg
                                    class="h-6 w-6 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    v-html="getIcon(cat.name)"
                                />
                            </div>

                            <h3 class="mb-1.5 text-base font-bold text-gray-500">{{ cat.name }}</h3>

                            <p v-if="cat.description" class="mb-4 text-sm leading-relaxed text-gray-400">
                                {{ cat.description }}
                            </p>

                            <div v-if="cat.document_templates?.length" class="mt-auto">
                                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-300">Документы в пакете</p>
                                <ul class="space-y-1.5">
                                    <li
                                        v-for="tpl in cat.document_templates"
                                        :key="tpl.id"
                                        class="flex items-start gap-2 text-sm text-gray-400"
                                    >
                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        <span>{{ tpl.name }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </template>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
