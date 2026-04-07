<template>
    <footer class="border-t border-gray-100 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-6">
                <!-- Logo -->
                <div class="flex items-center gap-2 text-gray-900">
                    <svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z" opacity=".2"/>
                        <path d="M20 6H4a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h16a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3Zm1 9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v6ZM8 11H6a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2Zm10 0h-6a1 1 0 0 0 0 2h6a1 1 0 0 0 0-2Z"/>
                    </svg>
                    <span class="text-lg font-bold tracking-tight">Packdock</span>
                </div>

                <!-- Divider -->
                <div class="h-px w-16 bg-gray-200" />

                <!-- Links -->
                <div class="flex gap-6 text-sm text-gray-400">
                    <a href="#" class="hover:text-gray-600 transition-colors">Политика конфиденциальности</a>
                    <a href="#" class="hover:text-gray-600 transition-colors">Условия использования</a>
                    <a href="#" class="hover:text-gray-600 transition-colors">Контакты</a>
                </div>

                <!-- Copyright -->
                <p class="text-xs text-gray-300">
                    &copy; {{ new Date().getFullYear() }} Packdock
                </p>
            </div>
        </div>
    </footer>
</template>
