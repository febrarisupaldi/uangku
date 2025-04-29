<!-- Sidebar -->
<aside id="sidebar" class="sidebar fixed lg:static z-40 lg:z-auto top-0 left-0 h-full w-64 transition-all duration-300 bg-green-700 text-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 flex flex-col -translate-x-full lg:translate-x-0">
    <div class="p-4 flex items-center justify-center gap-4 mb-6">
        <img src="{{ asset('assets/img/logo3.png')}}" alt="Logo Koperasi" class="object-cover sidebar-label">
        <h1 class="text-2xl font-bold text-white" id="title-logo"></h1>
    </div>
    <nav class="flex-1 px-2 space-y-2 overflow-y-auto text-gray-100">
        <a href="/home" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-green-600">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span class="sidebar-label">Dashboard</span>
        </a>
        <a href="/wallets" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-green-600">
            <i data-lucide="wallet" class="w-5 h-5"></i>
            <span class="sidebar-label">Dompet</span>
        </a>
        <a href="/savings" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-green-600">
            <i data-lucide="credit-card" class="w-5 h-5"></i>
            <span class="sidebar-label">Kartu Kredit</span>
        </a>
        <a href="/loans" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-green-600">
            <i data-lucide="hand-coins" class="w-5 h-5"></i>
            <span class="sidebar-label">Investasi</span>
        </a>
        <a href="/cashflows" class="flex items-center gap-3 py-2 px-4 rounded hover:bg-green-600">
            <i data-lucide="weight" class="w-5 h-5"></i>
            <span class="sidebar-label">Hutang</span>
        </a>

    <!-- Submenu -->
    <div>
        <button onclick="toggleSubmenu('submenu-transaction', this)" class="w-full flex items-center justify-between gap-3 py-2 px-4 rounded hover:bg-green-600 focus:outline-none hover:cursor-pointer">
        <div class="flex items-center gap-3">
            <i data-lucide="notebook-pen" class="w-5 h-5"></i>
            <span class="sidebar-label">Transaksi</span>
        </div>
        <div class="sidebar-label flex items-center">
            <i data-lucide="chevron-down" class="w-4 h-4 icon-down"></i>
            <i data-lucide="chevron-up" class="w-4 h-4 icon-up hidden"></i>
        </div>
        </button>
        <div id="submenu-transaction" class="submenu hidden ml-10 mt-1 space-y-1 overflow-hidden transition-all">
            <a href="/admin/users" class="flex items-center gap-2 text-md py-1 px-2 rounded hover:bg-green-600"><i data-lucide="banknote-arrow-down" class="w-4 h-4"></i> Pemasukan</a>
            <a href="#" class="flex items-center gap-2 text-md py-1 px-2 rounded hover:bg-green-600"><i data-lucide="banknote-arrow-up" class="w-4 h-4"></i>Pengeluaran</a>
            <a href="#" class="flex items-center gap-2 text-md py-1 px-2 rounded hover:bg-green-600"><i data-lucide="refresh-ccw" class="w-4 h-4"></i>Mutasi Kas</a>
        </div>
    </div>

    <div>
        <button onclick="toggleSubmenu('submenu-report', this)" class="w-full flex items-center justify-between gap-3 py-2 px-4 rounded hover:bg-green-600 focus:outline-none hover:cursor-pointer">
        <div class="flex items-center gap-3">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span class="sidebar-label">Laporan</span>
        </div>
        <div class="sidebar-label flex items-center">
            <i data-lucide="chevron-down" class="w-4 h-4 icon-down"></i>
            <i data-lucide="chevron-up" class="w-4 h-4 icon-up hidden"></i>
        </div>
        </button>
        <div id="submenu-report" class="submenu hidden ml-10 mt-1 space-y-1 overflow-hidden transition-all">
            <a href="#" class="block text-md py-1 px-2 rounded hover:bg-green-600">Laporan Simpanan</a>
            <a href="#" class="block text-md py-1 px-2 rounded hover:bg-green-600">Laporan Pinjaman</a>
            <a href="#" class="block text-md py-1 px-2 rounded hover:bg-green-600">Laporan Kas</a>
        </div>
    </div>

    <div>
        <button onclick="toggleSubmenu('submenu-admin', this)" class="w-full flex items-center justify-between gap-3 py-2 px-4 rounded hover:bg-green-600 focus:outline-none hover:cursor-pointer">
        <div class="flex items-center gap-3">
            <i data-lucide="user-cog" class="w-5 h-5"></i>
            <span class="sidebar-label">Administrator</span>
        </div>
        <div class="sidebar-label flex items-center">
            <i data-lucide="chevron-down" class="w-4 h-4 icon-down"></i>
            <i data-lucide="chevron-up" class="w-4 h-4 icon-up hidden"></i>
        </div>
        </button>
        <div id="submenu-admin" class="submenu hidden ml-10 mt-1 space-y-1 overflow-hidden transition-all">
            <a href="/admin/users" class="flex items-center gap-2 text-md py-1 px-2 rounded hover:bg-green-600"><i data-lucide="circle-user-round" class="w-4 h-4"></i>Users</a>
        </div>
    </div>
    </nav>
    <div class="p-4 border-t border-green-600 text-sm sidebar-label">
    © 2025 Uangku
    </div>
</aside>