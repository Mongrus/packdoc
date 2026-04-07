<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    categories: Array,
});

const icons = {
    'Фриланс и услуги': `<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />`,
    'Мелкий бизнес / сервисные услуги': `<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.349m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016A3.001 3.001 0 0021 9.349m-18 0A2.999 2.999 0 017.5 6.75h9A2.999 2.999 0 0121 9.349" />`,
    'Консалтинг / юридическая поддержка': `<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" />`,
};

const colors = {
    'Фриланс и услуги': { bg: 'bg-violet-50', text: 'text-violet-600', ring: 'hover:ring-violet-400', iconBg: 'bg-violet-100' },
    'Мелкий бизнес / сервисные услуги': { bg: 'bg-emerald-50', text: 'text-emerald-600', ring: 'hover:ring-emerald-400', iconBg: 'bg-emerald-100' },
    'Консалтинг / юридическая поддержка': { bg: 'bg-amber-50', text: 'text-amber-600', ring: 'hover:ring-amber-400', iconBg: 'bg-amber-100' },
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
                    <Link
                        v-for="cat in categories"
                        :key="cat.id"
                        :href="route('packages.questionnaire', cat.id)"
                        class="group flex flex-col rounded-2xl bg-white p-6 ring-1 ring-gray-200 transition hover:shadow-md"
                        :class="getColor(cat.name).ring"
                    >
                        <!-- Icon -->
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

                        <!-- Title -->
                        <h3 class="mb-1.5 text-base font-bold text-gray-900">{{ cat.name }}</h3>

                        <!-- Description -->
                        <p v-if="cat.description" class="mb-4 text-sm leading-relaxed text-gray-500">
                            {{ cat.description }}
                        </p>

                        <!-- Document templates list -->
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

                        <!-- Arrow -->
                        <div class="mt-5 flex items-center gap-1.5 text-sm font-medium" :class="getColor(cat.name).text">
                            Выбрать
                            <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </Link>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
