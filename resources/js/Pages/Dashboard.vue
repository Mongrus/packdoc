<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    stats: Object,
    progress: Object,
});

const steps = computed(() => [
    {
        id: 'register',
        title: 'Регистрация',
        description: 'Спасибо, что присоединились! Наш инструмент поможет вам быстро и удобно формировать пакеты документов для любых направлений деятельности.',
        completed: true,
        active: false,
        link: null,
        linkText: null,
    },
    {
        id: 'profile',
        title: 'Заполните профиль',
        description: 'Заполните данные о себе — это ускорит создание пакетов документов, так как ваши данные уже будут подставлены автоматически.',
        completed: props.progress.profileFilled === props.progress.profileTotal,
        active: props.progress.profileFilled < props.progress.profileTotal,
        link: route('account'),
        linkText: props.progress.profileFilled === props.progress.profileTotal
            ? 'Перейти в профиль'
            : `Заполнить (${props.progress.profileFilled}/${props.progress.profileTotal})`,
    },
    {
        id: 'first-package',
        title: 'Создайте первый пакет',
        description: 'Посмотрите нашу небольшую инструкцию, как это сделать быстро и в удобном формате. Всё специально настроено для вас — просто начните!',
        completed: props.progress.hasPackages,
        active: !props.progress.hasPackages && props.progress.profileFilled === props.progress.profileTotal,
        link: props.progress.hasPackages ? route('packages.index') : route('packages.create'),
        linkText: props.progress.hasPackages ? 'Мои пакеты' : 'Создать пакет',
        instructionLink: '#instruction',
        instructionText: 'Читать инструкцию ↓',
    },
]);

const completedSteps = computed(() => steps.value.filter(s => s.completed).length);
const progressPercent = computed(() => Math.round((completedSteps.value / steps.value.length) * 100));

const statCards = computed(() => [
    {
        label: 'Всего пакетов',
        value: props.stats.total,
        icon: 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z',
        color: 'text-blue-600',
        bg: 'bg-blue-50',
    },
    {
        label: 'Черновиков',
        value: props.stats.drafts,
        icon: 'M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10',
        color: 'text-amber-600',
        bg: 'bg-amber-50',
    },
    {
        label: 'Завершённых',
        value: props.stats.completed,
        icon: 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        color: 'text-emerald-600',
        bg: 'bg-emerald-50',
    },
]);
</script>

<template>
    <Head title="Личный кабинет — Packdock" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Личный кабинет
            </h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

                <!-- Progress Section -->
                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="px-6 pt-6 pb-2">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Ваш прогресс</h3>
                            <span class="text-sm font-medium text-gray-500">
                                {{ completedSteps }} из {{ steps.length }} выполнено
                            </span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-gray-100">
                            <div
                                class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 transition-all duration-700 ease-out"
                                :style="{ width: progressPercent + '%' }"
                            />
                        </div>
                    </div>

                    <!-- Steps -->
                    <div class="divide-y divide-gray-100 px-6 pb-2">
                        <div
                            v-for="(step, index) in steps"
                            :key="step.id"
                            class="flex gap-4 py-5"
                        >
                            <!-- Step Indicator -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-bold transition-colors"
                                    :class="
                                        step.completed
                                            ? 'bg-emerald-500 text-white'
                                            : step.active
                                              ? 'bg-blue-500 text-white ring-4 ring-blue-100'
                                              : 'bg-gray-100 text-gray-400'
                                    "
                                >
                                    <svg v-if="step.completed" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    <span v-else>{{ index + 1 }}</span>
                                </div>
                                <div
                                    v-if="index < steps.length - 1"
                                    class="mt-1 w-0.5 flex-1"
                                    :class="step.completed ? 'bg-emerald-200' : 'bg-gray-100'"
                                />
                            </div>

                            <!-- Step Content -->
                            <div class="flex-1 pb-1">
                                <h4
                                    class="text-sm font-semibold"
                                    :class="step.completed ? 'text-emerald-700' : step.active ? 'text-gray-900' : 'text-gray-400'"
                                >
                                    {{ step.title }}
                                    <span v-if="step.completed" class="ml-1.5 text-xs font-medium text-emerald-500">Готово</span>
                                </h4>
                                <p class="mt-0.5 text-sm leading-relaxed text-gray-500">
                                    {{ step.description }}
                                </p>
                                <div v-if="step.link" class="mt-2 flex flex-wrap items-center gap-3">
                                    <Link
                                        :href="step.link"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-sm font-medium transition"
                                        :class="
                                            step.completed
                                                ? 'bg-gray-50 text-gray-600 hover:bg-gray-100'
                                                : 'bg-blue-50 text-blue-700 hover:bg-blue-100'
                                        "
                                    >
                                        {{ step.linkText }}
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                        </svg>
                                    </Link>
                                    <a
                                        v-if="step.instructionLink && !step.completed"
                                        :href="step.instructionLink"
                                        class="text-sm text-gray-400 transition hover:text-blue-600"
                                    >
                                        {{ step.instructionText }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div
                        v-for="card in statCards"
                        :key="card.label"
                        class="flex items-center gap-4 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200"
                    >
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl" :class="card.bg">
                            <svg class="h-6 w-6" :class="card.color" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="card.icon" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ card.value }}</p>
                            <p class="text-sm text-gray-500">{{ card.label }}</p>
                        </div>
                    </div>
                </div>

                <!-- Instruction Section -->
                <div id="instruction" class="scroll-mt-24 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="px-6 py-6">
                        <h3 class="text-lg font-semibold text-gray-900">Как создать пакет документов</h3>
                        <p class="mt-1 text-sm text-gray-500">Следуйте этим простым шагам, чтобы быстро сформировать все нужные документы.</p>

                        <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-3">
                            <!-- Step 1 -->
                            <div class="flex gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-sm font-bold text-blue-600">
                                    1
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">Выберите тип пакета</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-gray-500">
                                        Перейдите на страницу создания и выберите подходящую категорию документов — например, «Фриланс».
                                    </p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="flex gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-sm font-bold text-blue-600">
                                    2
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">Заполните данные</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-gray-500">
                                        Укажите информацию о заказчике, исполнителе и услугах. Если профиль заполнен — данные подставятся автоматически.
                                    </p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="flex gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-sm font-bold text-blue-600">
                                    3
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">Скачайте документы</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-gray-500">
                                        После создания пакета вы сможете просмотреть каждый документ и скачать его в формате PDF.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <Link
                                :href="route('packages.create')"
                                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
                            >
                                Создать пакет документов
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
