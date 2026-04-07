<script setup>
import { computed, nextTick, ref, watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DocumentPreview from '@/Components/DocumentPreview.vue';
import { Head } from '@inertiajs/vue3';

const previewForm = ref(null);
const previewExpanded = ref(false);
const mobilePreview = ref(false);

watch(previewExpanded, (open) => {
    document.body.style.overflow = open ? 'hidden' : '';
});

watch(mobilePreview, (open) => {
    document.body.style.overflow = open ? 'hidden' : '';
});
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

const props = defineProps({
    category: Object,
    profile: Object,
    package: { type: Object, default: null },
});

const page = usePage();
const isEditing = computed(() => !!props.package);
const pkg = props.package?.data;

const form = useForm({
    type: props.package?.type ?? 'freelance',

    contract_number: pkg?.contract?.number ?? '',
    contract_date: pkg?.contract?.date ?? '',
    contract_city: pkg?.contract?.city ?? '',

    contractor_name: pkg?.contractor?.name ?? '',
    contractor_email: pkg?.contractor?.email ?? '',
    contractor_phone: pkg?.contractor?.phone ?? '',

    client_name: pkg?.client?.name ?? '',
    client_email: pkg?.client?.email ?? '',

    service_name: pkg?.service?.name ?? '',
    service_description: pkg?.service?.description ?? '',
    start_date: pkg?.service?.start_date ?? '',
    end_date: pkg?.service?.end_date ?? '',

    price: pkg?.payment?.price ?? '',
    currency: pkg?.payment?.currency ?? 'USD',
    payment_terms: pkg?.payment?.terms ?? '',
    payment_details: pkg?.payment?.details ?? '',
    due_date: pkg?.payment?.due_date ?? '',

    act_number: pkg?.meta?.act_number ?? '',
    invoice_number: pkg?.meta?.invoice_number ?? '',
    acceptance_days: pkg?.meta?.acceptance_days ?? 5,
    penalty_terms: pkg?.meta?.penalty_terms ?? '',
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
    form.contract_number = '001';
    form.contract_date = new Date().toISOString().slice(0, 10);
    form.contract_city = 'Москва';
    form.contractor_name = 'Серенко Роман Александрович';
    form.contractor_email = 'roman@example.com';
    form.contractor_phone = '+7 (999) 123-45-67';
    form.client_name = 'ООО «Ромашка»';
    form.client_email = 'info@romashka.ru';
    form.service_name = 'Разработка веб-приложения';
    form.service_description = 'Полный цикл разработки SPA на Vue 3 + Laravel, включая дизайн, вёрстку, backend API и деплой.';
    form.start_date = new Date().toISOString().slice(0, 10);
    form.end_date = new Date(Date.now() + 30 * 86400000).toISOString().slice(0, 10);
    form.price = '150000';
    form.currency = 'RUB';
    form.payment_terms = '5 рабочих дней после подписания акта';
    form.payment_details = 'Банковский перевод';
    form.due_date = new Date(Date.now() + 35 * 86400000).toISOString().slice(0, 10);
    form.act_number = 'A-001';
    form.invoice_number = 'INV-001';
    form.acceptance_days = 3;
    form.penalty_terms = '0.1% за каждый день просрочки';
}

function buildPayload(fields) {
    return {
        type: fields.type,
        data: {
            contract: {
                number: fields.contract_number,
                date: fields.contract_date,
                city: fields.contract_city,
            },
            contractor: {
                name: fields.contractor_name,
                email: fields.contractor_email,
                phone: fields.contractor_phone,
            },
            client: {
                name: fields.client_name,
                email: fields.client_email,
            },
            service: {
                name: fields.service_name,
                description: fields.service_description,
                start_date: fields.start_date,
                end_date: fields.end_date,
            },
            payment: {
                price: fields.price,
                currency: fields.currency,
                terms: fields.payment_terms,
                details: fields.payment_details,
                due_date: fields.due_date,
            },
            meta: {
                act_number: fields.act_number,
                invoice_number: fields.invoice_number,
                acceptance_days: fields.acceptance_days,
                penalty_terms: fields.penalty_terms,
            },
        },
    };
}

function generate() {
    if (isEditing.value) {
        form.transform(buildPayload).put(route('packages.update', props.package.id));
    } else {
        form.transform(buildPayload).post(route('packages.store'));
    }
}

function openPreview() {
    previewForm.value.submit();
}

function saveDraft() {
    if (isEditing.value) {
        form.transform(buildPayload).post(route('packages.draft', props.package.id));
    } else {
        form.transform(buildPayload).post(route('packages.storeDraft'));
    }
}

function focusField(fieldId) {
    previewExpanded.value = false;
    nextTick(() => {
        const el = document.getElementById(fieldId);
        if (!el) return;
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => {
            el.focus();
            el.classList.add('ring-2', 'ring-indigo-400', 'ring-offset-1');
            setTimeout(() => el.classList.remove('ring-2', 'ring-indigo-400', 'ring-offset-1'), 1500);
        }, 300);
    });
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

        <div class="py-10 pb-28 lg:pb-10">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

                <nav class="mb-6 flex items-center gap-2 text-sm">
                    <Link
                        :href="isEditing ? route('packages.index') : route('packages.create')"
                        class="text-gray-400 hover:text-gray-600 transition"
                    >
                        {{ isEditing ? 'Мои пакеты' : 'Выбор категории' }}
                    </Link>
                    <svg class="h-4 w-4 shrink-0 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <span class="font-medium text-gray-700">{{ isEditing ? 'Редактирование' : 'Заполнение пакета' }}</span>
                </nav>

                <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-gray-200">
                    <div class="h-1.5 w-full bg-gradient-to-r from-indigo-400 to-violet-400" />

                    <div class="px-8 py-8">
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
                            <!-- Contract info -->
                            <fieldset>
                                <legend class="mb-4 text-sm font-semibold text-gray-900">Договор</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label for="contract_number" class="mb-1 block text-sm font-medium text-gray-700">Номер договора</label>
                                        <input id="contract_number" v-model="form.contract_number" type="text" placeholder="001"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p v-if="form.errors['data.contract.number']" class="mt-1 text-xs text-red-500">{{ form.errors['data.contract.number'] }}</p>
                                    </div>
                                    <div>
                                        <label for="contract_date" class="mb-1 block text-sm font-medium text-gray-700">Дата</label>
                                        <input id="contract_date" v-model="form.contract_date" type="date"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p v-if="form.errors['data.contract.date']" class="mt-1 text-xs text-red-500">{{ form.errors['data.contract.date'] }}</p>
                                    </div>
                                    <div>
                                        <label for="contract_city" class="mb-1 block text-sm font-medium text-gray-700">Город</label>
                                        <input id="contract_city" v-model="form.contract_city" type="text" placeholder="Москва"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Contractor -->
                            <fieldset>
                                <legend class="mb-4 text-sm font-semibold text-gray-900">Исполнитель</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="contractor_name" class="mb-1 block text-sm font-medium text-gray-700">ФИО</label>
                                        <input id="contractor_name" v-model="form.contractor_name" type="text" placeholder="Иванов Иван Иванович"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p v-if="form.errors['data.contractor.name']" class="mt-1 text-xs text-red-500">{{ form.errors['data.contractor.name'] }}</p>
                                    </div>
                                    <div>
                                        <label for="contractor_email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                                        <input id="contractor_email" v-model="form.contractor_email" type="email" placeholder="executor@example.com"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p v-if="form.errors['data.contractor.email']" class="mt-1 text-xs text-red-500">{{ form.errors['data.contractor.email'] }}</p>
                                    </div>
                                    <div>
                                        <label for="contractor_phone" class="mb-1 block text-sm font-medium text-gray-700">Телефон</label>
                                        <input id="contractor_phone" v-model="form.contractor_phone" type="tel" placeholder="+7 (900) 000-00-00"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Client -->
                            <fieldset>
                                <legend class="mb-4 text-sm font-semibold text-gray-900">Заказчик</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="client_name" class="mb-1 block text-sm font-medium text-gray-700">ФИО / Компания</label>
                                        <input id="client_name" v-model="form.client_name" type="text" placeholder="ООО «Компания» или ФИО"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p v-if="form.errors['data.client.name']" class="mt-1 text-xs text-red-500">{{ form.errors['data.client.name'] }}</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="client_email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                                        <input id="client_email" v-model="form.client_email" type="email" placeholder="client@example.com"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p v-if="form.errors['data.client.email']" class="mt-1 text-xs text-red-500">{{ form.errors['data.client.email'] }}</p>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Service -->
                            <fieldset>
                                <legend class="mb-4 text-sm font-semibold text-gray-900">Услуга</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="service_name" class="mb-1 block text-sm font-medium text-gray-700">Название услуги</label>
                                        <input id="service_name" v-model="form.service_name" type="text" placeholder="Разработка сайта"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p v-if="form.errors['data.service.name']" class="mt-1 text-xs text-red-500">{{ form.errors['data.service.name'] }}</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="service_description" class="mb-1 block text-sm font-medium text-gray-700">Описание</label>
                                        <textarea id="service_description" v-model="form.service_description" rows="3" placeholder="Опишите объём работ…"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label for="start_date" class="mb-1 block text-sm font-medium text-gray-700">Дата начала</label>
                                        <input id="start_date" v-model="form.start_date" type="date"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label for="end_date" class="mb-1 block text-sm font-medium text-gray-700">Дата окончания</label>
                                        <input id="end_date" v-model="form.end_date" type="date"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Payment -->
                            <fieldset>
                                <legend class="mb-4 text-sm font-semibold text-gray-900">Оплата</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label for="price" class="mb-1 block text-sm font-medium text-gray-700">Сумма</label>
                                        <input id="price" v-model="form.price" type="text" placeholder="50000"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        <p v-if="form.errors['data.payment.price']" class="mt-1 text-xs text-red-500">{{ form.errors['data.payment.price'] }}</p>
                                    </div>
                                    <div>
                                        <label for="currency" class="mb-1 block text-sm font-medium text-gray-700">Валюта</label>
                                        <select id="currency" v-model="form.currency"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="RUB">RUB</option>
                                            <option value="USD">USD</option>
                                            <option value="EUR">EUR</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="due_date" class="mb-1 block text-sm font-medium text-gray-700">Срок оплаты (дата)</label>
                                        <input id="due_date" v-model="form.due_date" type="date"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="payment_terms" class="mb-1 block text-sm font-medium text-gray-700">Условия оплаты</label>
                                        <input id="payment_terms" v-model="form.payment_terms" type="text" placeholder="5 рабочих дней после подписания акта"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label for="payment_details" class="mb-1 block text-sm font-medium text-gray-700">Реквизиты</label>
                                        <input id="payment_details" v-model="form.payment_details" type="text" placeholder="Расчётный счёт"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Meta -->
                            <fieldset>
                                <legend class="mb-4 text-sm font-semibold text-gray-900">Дополнительно</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="act_number" class="mb-1 block text-sm font-medium text-gray-700">Номер акта</label>
                                        <input id="act_number" v-model="form.act_number" type="text" placeholder="A-001"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label for="invoice_number" class="mb-1 block text-sm font-medium text-gray-700">Номер инвойса</label>
                                        <input id="invoice_number" v-model="form.invoice_number" type="text" placeholder="INV-001"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label for="acceptance_days" class="mb-1 block text-sm font-medium text-gray-700">Дней на приёмку</label>
                                        <input id="acceptance_days" v-model="form.acceptance_days" type="number" min="1" max="30" placeholder="5"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label for="penalty_terms" class="mb-1 block text-sm font-medium text-gray-700">Штрафные санкции</label>
                                        <input id="penalty_terms" v-model="form.penalty_terms" type="text" placeholder="0.1% за каждый день просрочки"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Actions -->
                            <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                                <button
                                    type="button"
                                    @click="openPreview"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-white px-4 py-2.5 text-sm font-medium text-gray-700 ring-1 ring-gray-200 transition hover:bg-gray-50"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Предпросмотр PDF
                                </button>
                                <div class="flex items-center gap-3">
                                    <button
                                        type="button"
                                        :disabled="form.processing"
                                        @click="saveDraft"
                                        class="rounded-lg bg-white px-5 py-2.5 text-sm font-medium text-gray-700 ring-1 ring-gray-200 transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        Сохранить черновик
                                    </button>
                                    <button
                                        type="submit"
                                        :disabled="form.processing"
                                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        {{ isEditing ? 'Сохранить и сгенерировать' : 'Сгенерировать' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Mobile: sticky bottom bar -->
        <div class="fixed inset-x-0 bottom-0 z-30 lg:hidden border-t border-gray-200 bg-white/95 backdrop-blur-sm px-4 py-3 safe-bottom">
            <button
                type="button"
                @click="mobilePreview = true"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-medium text-white shadow-lg transition active:scale-[0.98]"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Предпросмотр документа
            </button>
        </div>

        <!-- Mobile: full-screen overlay -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="translate-y-full"
                enter-to-class="translate-y-0"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="translate-y-0"
                leave-to-class="translate-y-full"
            >
                <div
                    v-if="mobilePreview"
                    class="fixed inset-0 z-50 flex flex-col bg-white lg:hidden"
                >
                    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3">
                        <h3 class="text-sm font-semibold text-gray-900">Предпросмотр</h3>
                        <button
                            type="button"
                            @click="mobilePreview = false"
                            class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto px-4 py-4">
                        <DocumentPreview :form="form" @focus-field="(id) => { mobilePreview = false; focusField(id); }" />
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Fixed right-side drawer (GPU translateX, zero reflow) -->
        <div
            class="fixed inset-y-0 right-0 z-40 hidden lg:flex pointer-events-none"
            @mouseleave="previewExpanded = false"
        >
            <div
                class="relative flex h-full w-[680px] will-change-transform pointer-events-auto"
                :style="{
                    transform: previewExpanded ? 'translateX(0)' : 'translateX(calc(100% - 48px))',
                    transition: 'transform 0.3s cubic-bezier(.4,0,.2,1)',
                }"
            >
                <!-- Side tab (hover trigger) -->
                <div
                    class="flex w-[48px] shrink-0 flex-col items-center justify-center border-l border-gray-200 bg-gray-50/90 cursor-pointer"
                    @mouseenter="previewExpanded = true"
                >
                    <div class="flex flex-col items-center gap-3">
                        <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span class="text-[10px] font-semibold uppercase tracking-widest text-gray-400" style="writing-mode: vertical-lr;">Предпросмотр</span>
                    </div>
                </div>

                <!-- Preview panel -->
                <div class="flex-1 overflow-y-auto border-l border-gray-200 bg-white shadow-2xl">
                    <div class="p-5">
                        <DocumentPreview :form="form" @focus-field="focusField" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Hidden form for preview in new tab -->
    <form
        ref="previewForm"
        :action="route('packages.previewAll')"
        method="POST"
        target="_blank"
        class="hidden"
    >
        <input type="hidden" name="_token" :value="csrfToken" />
        <input type="hidden" name="type" :value="form.type" />
        <input type="hidden" name="data[contract][number]" :value="form.contract_number" />
        <input type="hidden" name="data[contract][date]" :value="form.contract_date" />
        <input type="hidden" name="data[contract][city]" :value="form.contract_city" />
        <input type="hidden" name="data[contractor][name]" :value="form.contractor_name" />
        <input type="hidden" name="data[contractor][email]" :value="form.contractor_email" />
        <input type="hidden" name="data[contractor][phone]" :value="form.contractor_phone" />
        <input type="hidden" name="data[client][name]" :value="form.client_name" />
        <input type="hidden" name="data[client][email]" :value="form.client_email" />
        <input type="hidden" name="data[service][name]" :value="form.service_name" />
        <input type="hidden" name="data[service][description]" :value="form.service_description" />
        <input type="hidden" name="data[service][start_date]" :value="form.start_date" />
        <input type="hidden" name="data[service][end_date]" :value="form.end_date" />
        <input type="hidden" name="data[payment][price]" :value="form.price" />
        <input type="hidden" name="data[payment][currency]" :value="form.currency" />
        <input type="hidden" name="data[payment][terms]" :value="form.payment_terms" />
        <input type="hidden" name="data[payment][details]" :value="form.payment_details" />
        <input type="hidden" name="data[payment][due_date]" :value="form.due_date" />
        <input type="hidden" name="data[meta][act_number]" :value="form.act_number" />
        <input type="hidden" name="data[meta][invoice_number]" :value="form.invoice_number" />
        <input type="hidden" name="data[meta][acceptance_days]" :value="form.acceptance_days" />
        <input type="hidden" name="data[meta][penalty_terms]" :value="form.penalty_terms" />
    </form>
</template>
