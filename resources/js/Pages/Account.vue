<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UserProfileForm from '@/Components/UserProfileForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    userProfile: Object,
    status:      String,
});
</script>

<template>
    <Head title="Профиль — Packdock" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Профиль
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="border-b border-gray-100 px-6 py-5">
                        <h2 class="text-lg font-semibold text-gray-900">Данные профиля</h2>
                        <p class="mt-0.5 text-sm text-gray-500">
                            Заполните данные один раз — они автоматически подставятся при создании документов.
                        </p>
                    </div>
                    <div class="p-6">
                        <UserProfileForm
                            :user-profile="userProfile"
                            :status="status"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
