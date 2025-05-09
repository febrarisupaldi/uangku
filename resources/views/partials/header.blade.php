<header class="bg-white dark:bg-gray-800 shadow p-4 flex justify-between items-center lg:pl-4">
    <div class="flex items-center gap-3">
    <button class="lg:hidden text-gray-900 dark:text-gray-300" onclick="openMobileSidebar()">
        <i data-lucide="menu" class="w-6 h-6"></i>
    </button>
        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100"></h1>
    </div>
    <div class="flex items-center">
        <button onclick="toggleDarkMode()" class="text-gray-500 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white mr-4 hover:cursor-pointer">
            <i id="themeIcon" data-lucide="moon" class="w-5 h-5"></i>
        </button>
        <!-- Dropdown Menu -->
        <div class="relative ml-4">
            <button id="userMenuButton" class="flex items-center gap-2 text-sm text-gray-900 hover:text-green-700 dark:text-gray-200 dark:hover:text-green-400 focus:outline-none hover:cursor-pointer">
                <i data-lucide="user" class="w-5 h-5"></i>
                <span>Admin</span>
                <i data-lucide="chevron-down" class="w-4 h-4"></i>
            </button>
            <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border dark:border-gray-700 border rounded-lg shadow-lg py-2 hidden z-50">
                <a href="#" class="block px-4 py-2 text-sm text-gray-900 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profil</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-900 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Ganti Password</a>
            <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900">Logout</a>
            </div>
        </div>
    </div>
</header>