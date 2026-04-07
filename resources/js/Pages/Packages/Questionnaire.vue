<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    category: Object,
    profile: Object,
});

const page = usePage();

const form = useForm({
    type: 'freelance',
    contractor_name: '',
    contractor_email: '',
    contractor_phone: '',
    client_name: '',
    client_email: '',
    service: '',
    service_description: '',
    price: '',
    date: '',
});

const isDevUser = page.props.auth?.user?.id === 1;
const hasProfile = !!props.profile?.full_name;

function fillFromProfile() {
    const p = props.profile;
    if (!p) return;
    if (p.full_name) form.contractor_name = p.full_name;
    if (page.props.auth?.user?.email) form.contractor_email = page.props.auth.user.email;
    if (p.phone) form.contractor_phone = p.phone;
}

function autofill() {
    form.contractor_name = 'Серенко Роман Александрович';
    form.contractor_email = 'roman@example.com';
    form.contractor_phone = '+7 (999) 123-45-67';
    form.client_name = 'ООО «Ромашка»';
    form.client_email = 'info@romashka.ru';
    form.service = 'Разработка веб-приложения';
    form.service_description = 'Полный цикл разработки SPA на Vue 3 + Laravel, включая дизайн, вёрстку, backend API и деплой.';
    form.price = '150 000 ₽';
    form.date = new Date().toISOString().slice(0, 10);
}

function generate() {
    form.transform((fields) => ({
        type: fields.type,
        data: {
            contractor_name: fields.contractor_name,
            contractor_email: fields.contractor_email,
            contractor_phone: fields.contractor_phone,
            client_name: fields.client_name,
            client_email: fields.client_email,
            service: fields.service,
            service_description: fields.service_description,
            price: fields.price,
            date: fields.date,
        },
    })).post(route('packages.store'));
}
</script>

<template>
    <Head :title="`${category.name} — Packdock`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ category.name }}
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

                <!-- Breadcrumbs -->
                <nav class="mb-6 flex items-center gap-2 text-sm">
                    <Link
                        :href="route('packages.create')"
                        class="text-gray-400 hover:text-gray-600 transition"
                    >
                        Выбор категории
                    </Link>
                    <svg class="h-4 w-4 shrink-0 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <span class="font-medium text-gray-700">Заполнение пакета</span>
                </nav>

                <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-gray-200">
                    <div class="h-1.5 w-full bg-gradient-to-r from-indigo-400 to-violet-400" />

                    <div class="px-8 py-8">
                        <!-- Documents list -->
                        <div v-if="category.document_templates?.length" class="mb-8">
                            <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Документы в пакете
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="tpl in category.document_templates"
                                    :key="tpl.id"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-gray-50 px-3 py-1.5 text-sm text-gray-600 ring-1 ring-gray-100"
                                >
                                    <span
                                        :class="[
                                            'inline-flex items-center rounded px-1.5 py-0.5 text-[10px] font-bold uppercase',
                                            tpl.type === 'pdf' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600',
                                        ]"
                                    >{{ tpl.type }}</span>
                                    {{ tpl.name }}
                                </span>
                            </div>
                        </div>

                        <div v-if="hasProfile || isDevUser" class="mb-4 flex flex-wrap gap-2">
                            <button
                                v-if="hasProfile"
                                type="button"
                                @click="fillFromProfile"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 ring-1 ring-indigo-200 transition hover:bg-indigo-100"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Подставить из профиля
                            </button>
                            <button
                                v-if="isDevUser"
                                type="button"
                                @click="autofill"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 ring-1 ring-amber-200 transition hover:bg-amber-100"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z" />
                                </svg>
                                Автозаполнение (dev)
                            </button>
                        </div>

                        <form @submit.prevent="generate" class="space-y-8">
                            <!-- Executor -->
                            <fieldset>
                                <legend class="mb-4 text-sm font-semibold text-gray-900">Исполнитель</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="contractor_name" class="mb-1 block text-sm font-medium text-gray-700">ФИО</label>
                                        <input
                                            id="contractor_name"
                                            v-model="form.contractor_name"
                                            type="text"
                                            placeholder="Иванов Иван Иванович"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                        <p v-if="form.errors['data.contractor_name']" class="mt-1 text-xs text-red-500">{{ form.errors['data.contractor_name'] }}</p>
                                    </div>
                                    <div>
                                        <label for="contractor_email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                                        <input
                                            id="contractor_email"
                                            v-model="form.contractor_email"
                                            type="email"
                                            placeholder="executor@example.com"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                        <p v-if="form.errors['data.contractor_email']" class="mt-1 text-xs text-red-500">{{ form.errors['data.contractor_email'] }}</p>
                                    </div>
                                    <div>
                                        <label for="contractor_phone" class="mb-1 block text-sm font-medium text-gray-700">Телефон</label>
                                        <input
                                            id="contractor_phone"
                                            v-model="form.contractor_phone"
                                            type="tel"
                                            placeholder="+7 (900) 000-00-00"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Client -->
                            <fieldset>
                                <legend class="mb-4 text-sm font-semibold text-gray-900">Заказчик</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="client_name" class="mb-1 block text-sm font-medium text-gray-700">ФИО / Компания</label>
                                        <input
                                            id="client_name"
                                            v-model="form.client_name"
                                            type="text"
                                            placeholder="ООО «Компания» или ФИО"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                        <p v-if="form.errors['data.client_name']" class="mt-1 text-xs text-red-500">{{ form.errors['data.client_name'] }}</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="client_email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                                        <input
                                            id="client_email"
                                            v-model="form.client_email"
                                            type="email"
                                            placeholder="client@example.com"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                        <p v-if="form.errors['data.client_email']" class="mt-1 text-xs text-red-500">{{ form.errors['data.client_email'] }}</p>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Service details -->
                            <fieldset>
                                <legend class="mb-4 text-sm font-semibold text-gray-900">Детали</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="service" class="mb-1 block text-sm font-medium text-gray-700">Название услуги</label>
                                        <input
                                            id="service"
                                            v-model="form.service"
                                            type="text"
                                            placeholder="Разработка сайта"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                        <p v-if="form.errors['data.service']" class="mt-1 text-xs text-red-500">{{ form.errors['data.service'] }}</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="service_description" class="mb-1 block text-sm font-medium text-gray-700">Описание</label>
                                        <textarea
                                            id="service_description"
                                            v-model="form.service_description"
                                            rows="3"
                                            placeholder="Опишите объём работ…"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                    </div>
                                    <div>
                                        <label for="price" class="mb-1 block text-sm font-medium text-gray-700">Стоимость</label>
                                        <input
                                            id="price"
                                            v-model="form.price"
                                            type="text"
                                            placeholder="50 000 ₽"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                        <p v-if="form.errors['data.price']" class="mt-1 text-xs text-red-500">{{ form.errors['data.price'] }}</p>
                                    </div>
                                    <div>
                                        <label for="date" class="mb-1 block text-sm font-medium text-gray-700">Дата</label>
                                        <input
                                            id="date"
                                            v-model="form.date"
                                            type="date"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        />
                                        <p v-if="form.errors['data.date']" class="mt-1 text-xs text-red-500">{{ form.errors['data.date'] }}</p>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                                <button
                                    type="button"
                                    disabled
                                    class="rounded-lg bg-white px-5 py-2.5 text-sm font-medium text-gray-700 ring-1 ring-gray-200 transition disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    Сохранить черновик
                                </button>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    Сгенерировать
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
