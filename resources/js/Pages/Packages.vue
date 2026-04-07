<script setup>
import { ref, computed } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    packages: Object,
    status:   String,
});

const activeFilter = ref('all');

const filtered = computed(() => {
    if (activeFilter.value === 'all') return props.packages.data;
    return props.packages.data.filter(p => p.status === activeFilter.value);
});

const filters = [
    { id: 'all',       label: 'Все' },
    { id: 'draft',     label: 'Черновики' },
    { id: 'completed', label: 'Завершённые' },
];

function duplicate(pkg) {
    router.post(route('packages.duplicate', pkg.id));
}

function destroy(pkg) {
    if (!confirm(`Удалить пакет "${pkg.template?.name ?? '—'}"?`)) return;
    router.delete(route('packages.destroy', pkg.id));
}

function formatDate(iso) {
    return new Date(iso).toLocaleDateString('ru-RU', {
        day: '2-digit', month: 'short', year: 'numeric',
    });
}
</script>

<template>
    <Head title="Мои пакеты — Packdock" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Мои пакеты документов
            </h2>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

                <div class="mb-5 space-y-3">
                    <FlashMessage v-if="status === 'package-duplicated'" type="info">
                        Пакет скопирован как новый черновик.
                    </FlashMessage>
                    <FlashMessage v-if="status === 'package-deleted'" type="error">
                        Пакет удалён.
                    </FlashMessage>
                </div>

                <!-- Header row -->
                <div class="mb-5 flex items-center justify-between">
                    <!-- Filter pills -->
                    <div class="flex gap-2">
                        <button
                            v-for="f in filters"
                            :key="f.id"
                            @click="activeFilter = f.id"
                            :class="[
                                'rounded-md px-3 py-1.5 text-sm font-medium transition',
                                activeFilter === f.id
                                    ? 'bg-indigo-600 text-white'
                                    : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:bg-gray-50',
                            ]"
                        >
                            {{ f.label }}
                        </button>
                    </div>

                    <Link
                        :href="route('packages.create')"
                        class="inline-flex items-center gap-1.5 rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Новый пакет
                    </Link>
                </div>

                <!-- Empty state -->
                <div
                    v-if="filtered.length === 0"
                    class="flex flex-col items-center justify-center rounded-xl bg-white py-20 ring-1 ring-gray-200"
                >
                    <svg class="mb-4 h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.75h16.5M3.75 14.25h16.5M9 4.5h6M5.25 19.5h13.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H5.25A1.5 1.5 0 003.75 6v12a1.5 1.5 0 001.5 1.5z" />
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Пакетов пока нет</p>
                    <p class="mt-1 text-xs text-gray-400">Создайте первый пакет документов</p>
                </div>

                <!-- Table -->
                <div v-else class="overflow-hidden rounded-xl bg-white ring-1 ring-gray-200">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-3 pl-5 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Название
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Тип
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Статус
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Создан
                                </th>
                                <th class="py-3 pl-3 pr-5 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr
                                v-for="pkg in filtered"
                                :key="pkg.id"
                                class="group transition hover:bg-gray-50"
                            >
                                <!-- Name -->
                                <td class="py-3.5 pl-5 pr-3">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ pkg.template?.name ?? '—' }}
                                    </span>
                                </td>

                                <!-- Type badge -->
                                <td class="px-3 py-3.5">
                                    <span
                                        :class="[
                                            'inline-flex items-center rounded px-2 py-0.5 text-xs font-semibold uppercase',
                                            pkg.template?.type === 'pdf'
                                                ? 'bg-red-50 text-red-600'
                                                : 'bg-blue-50 text-blue-600',
                                        ]"
                                    >
                                        {{ pkg.template?.type ?? '—' }}
                                    </span>
                                </td>

                                <!-- Status badge -->
                                <td class="px-3 py-3.5">
                                    <span
                                        :class="[
                                            'inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium',
                                            pkg.status === 'completed'
                                                ? 'bg-green-50 text-green-700 ring-1 ring-green-200'
                                                : 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200',
                                        ]"
                                    >
                                        <span
                                            :class="[
                                                'h-1.5 w-1.5 rounded-full',
                                                pkg.status === 'completed' ? 'bg-green-500' : 'bg-yellow-500',
                                            ]"
                                        />
                                        {{ pkg.status === 'completed' ? 'Завершён' : 'Черновик' }}
                                    </span>
                                </td>

                                <!-- Date -->
                                <td class="px-3 py-3.5 text-sm text-gray-500">
                                    {{ formatDate(pkg.created_at) }}
                                </td>

                                <!-- Actions -->
                                <td class="py-3.5 pl-3 pr-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Preview -->
                                        <a
                                            v-if="pkg.file_path"
                                            :href="pkg.file_path"
                                            target="_blank"
                                            class="inline-flex items-center gap-1 rounded-md bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 ring-1 ring-gray-200 hover:bg-gray-50 transition"
                                            title="Просмотр файла"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Просмотр
                                        </a>
                                        <span
                                            v-else
                                            class="inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-medium text-gray-300 ring-1 ring-gray-100 cursor-not-allowed"
                                            title="Файл ещё не сгенерирован"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Просмотр
                                        </span>

                                        <!-- Edit -->
                                        <button
                                            disabled
                                            class="inline-flex cursor-not-allowed items-center gap-1 rounded-md bg-white px-2.5 py-1.5 text-xs font-medium text-gray-300 ring-1 ring-gray-100"
                                            title="Редактирование — скоро"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                            </svg>
                                            Редактировать
                                        </button>

                                        <!-- Duplicate -->
                                        <button
                                            @click="duplicate(pkg)"
                                            class="inline-flex items-center gap-1 rounded-md bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 ring-1 ring-gray-200 hover:bg-gray-50 transition"
                                            title="Скопировать шаблон"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                            </svg>
                                            Копировать
                                        </button>

                                        <!-- Delete -->
                                        <button
                                            @click="destroy(pkg)"
                                            class="inline-flex items-center rounded-md bg-white p-1.5 text-gray-400 ring-1 ring-gray-200 hover:bg-red-50 hover:text-red-500 hover:ring-red-200 transition"
                                            title="Удалить"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div
                        v-if="packages.last_page > 1"
                        class="flex items-center justify-between border-t border-gray-100 px-5 py-3"
                    >
                        <span class="text-xs text-gray-500">
                            {{ packages.from }}–{{ packages.to }} из {{ packages.total }}
                        </span>
                        <div class="flex gap-1.5">
                            <Link
                                v-if="packages.prev_page_url"
                                :href="packages.prev_page_url"
                                class="rounded-md bg-white px-3 py-1.5 text-xs font-medium text-gray-700 ring-1 ring-gray-200 hover:bg-gray-50 transition"
                            >
                                ← Назад
                            </Link>
                            <Link
                                v-if="packages.next_page_url"
                                :href="packages.next_page_url"
                                class="rounded-md bg-white px-3 py-1.5 text-xs font-medium text-gray-700 ring-1 ring-gray-200 hover:bg-gray-50 transition"
                            >
                                Вперёд →
                            </Link>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
