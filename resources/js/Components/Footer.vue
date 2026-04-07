<template>
    <footer class="border-t border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <div class="text-sm text-gray-500">
                    © {{ new Date().getFullYear() }} Packdock. Все права защищены.
                </div>

                <div class="flex gap-6 text-sm text-gray-400">
                    <a href="#" class="hover:text-gray-600 transition-colors">Политика конфиденциальности</a>
                    <a href="#" class="hover:text-gray-600 transition-colors">Условия использования</a>
                    <a href="#" class="hover:text-gray-600 transition-colors">Контакты</a>
                </div>
            </div>

            <p class="mt-4 text-center text-xs text-gray-400">
                Онлайн-сервис для формирования пакетов документов для фрилансеров и малого бизнеса
            </p>
        </div>
    </footer>
</template>
