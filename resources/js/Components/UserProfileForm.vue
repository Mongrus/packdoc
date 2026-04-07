<script setup>
import { useForm } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    userProfile: Object,
    status: String,
});

const form = useForm({
    full_name:        props.userProfile?.full_name        ?? '',
    company_name:     props.userProfile?.company_name     ?? '',
    job_title:        props.userProfile?.job_title        ?? '',
    address:          props.userProfile?.address          ?? '',
    tax_id:           props.userProfile?.tax_id           ?? '',
    phone:            props.userProfile?.phone            ?? '',
    employment_type:  props.userProfile?.employment_type  ?? 'freelancer',
    default_currency: props.userProfile?.default_currency ?? 'RUB',
});

const employmentTypes = [
    { value: 'freelancer',    label: 'Фриланс' },
    { value: 'employee',      label: 'Сотрудник' },
    { value: 'self-employed', label: 'Самозанятый' },
    { value: 'company',       label: 'Компания' },
];

const currencies = [
    { value: 'RUB', label: 'RUB — Российский рубль' },
    { value: 'USD', label: 'USD — Доллар США' },
    { value: 'EUR', label: 'EUR — Евро' },
    { value: 'GBP', label: 'GBP — Фунт стерлингов' },
    { value: 'CNY', label: 'CNY — Китайский юань' },
    { value: 'KZT', label: 'KZT — Казахстанский тенге' },
    { value: 'BYN', label: 'BYN — Белорусский рубль' },
    { value: 'TRY', label: 'TRY — Турецкая лира' },
    { value: 'AED', label: 'AED — Дирхам ОАЭ' },
];

const submit = () => {
    form.put(route('user-profile.update'));
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-8">
        <FlashMessage v-if="status === 'profile-updated'" type="success">
            Профиль успешно сохранён.
        </FlashMessage>

        <!-- Section: Личные данные -->
        <section>
            <div class="mb-4 border-b border-gray-200 pb-2">
                <h3 class="text-base font-semibold text-gray-900">Личные данные</h3>
                <p class="mt-0.5 text-sm text-gray-500">ФИО, должность и тип занятости</p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <InputLabel value="ФИО *" for="full_name" />
                    <TextInput
                        id="full_name"
                        v-model="form.full_name"
                        type="text"
                        class="mt-1 block w-full"
                        autocomplete="name"
                        required
                    />
                    <InputError class="mt-1" :message="form.errors.full_name" />
                </div>

                <div>
                    <InputLabel value="Должность" for="job_title" />
                    <TextInput
                        id="job_title"
                        v-model="form.job_title"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError class="mt-1" :message="form.errors.job_title" />
                </div>

                <div>
                    <InputLabel value="Тип занятости *" for="employment_type" />
                    <select
                        id="employment_type"
                        v-model="form.employment_type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option
                            v-for="type in employmentTypes"
                            :key="type.value"
                            :value="type.value"
                        >
                            {{ type.label }}
                        </option>
                    </select>
                    <InputError class="mt-1" :message="form.errors.employment_type" />
                </div>
            </div>
        </section>

        <!-- Section: Контакты -->
        <section>
            <div class="mb-4 border-b border-gray-200 pb-2">
                <h3 class="text-base font-semibold text-gray-900">Контакты</h3>
                <p class="mt-0.5 text-sm text-gray-500">Телефон и адрес</p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <InputLabel value="Телефон" for="phone" />
                    <TextInput
                        id="phone"
                        v-model="form.phone"
                        type="tel"
                        class="mt-1 block w-full"
                        autocomplete="tel"
                    />
                    <InputError class="mt-1" :message="form.errors.phone" />
                </div>

                <div class="sm:col-span-2">
                    <InputLabel value="Юридический / рабочий адрес" for="address" />
                    <TextInput
                        id="address"
                        v-model="form.address"
                        type="text"
                        class="mt-1 block w-full"
                        autocomplete="street-address"
                    />
                    <InputError class="mt-1" :message="form.errors.address" />
                </div>
            </div>
        </section>

        <!-- Section: Юридическая информация -->
        <section>
            <div class="mb-4 border-b border-gray-200 pb-2">
                <h3 class="text-base font-semibold text-gray-900">Юридическая информация</h3>
                <p class="mt-0.5 text-sm text-gray-500">Реквизиты компании и настройки документов</p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <InputLabel value="Название компании" for="company_name" />
                    <TextInput
                        id="company_name"
                        v-model="form.company_name"
                        type="text"
                        class="mt-1 block w-full"
                        autocomplete="organization"
                    />
                    <InputError class="mt-1" :message="form.errors.company_name" />
                </div>

                <div>
                    <InputLabel value="ИНН / ОГРН" for="tax_id" />
                    <TextInput
                        id="tax_id"
                        v-model="form.tax_id"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError class="mt-1" :message="form.errors.tax_id" />
                </div>

                <div>
                    <InputLabel value="Валюта по умолчанию *" for="default_currency" />
                    <select
                        id="default_currency"
                        v-model="form.default_currency"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option
                            v-for="currency in currencies"
                            :key="currency.value"
                            :value="currency.value"
                        >
                            {{ currency.label }}
                        </option>
                    </select>
                    <InputError class="mt-1" :message="form.errors.default_currency" />
                </div>
            </div>
        </section>

        <!-- Save button -->
        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
            <span v-if="form.recentlySuccessful" class="text-sm text-gray-500">Сохранено.</span>
            <PrimaryButton :disabled="form.processing">
                {{ form.processing ? 'Сохранение...' : 'Сохранить профиль' }}
            </PrimaryButton>
        </div>
    </form>
</template>
