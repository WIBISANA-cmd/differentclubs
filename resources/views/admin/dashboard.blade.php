<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>differentclubs | Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .skeleton { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: skeleton-loading 1.5s infinite; }
        .dark .skeleton { background: linear-gradient(90deg, #1f2937 25%, #374151 50%, #1f2937 75%); background-size: 200% 100%; }
        @keyframes skeleton-loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .active-menu { @apply bg-black text-white dark:bg-white dark:text-black; }
    </style>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            light: '#f9fafb',
                            dark: '#111827',
                            accent: '#000000'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#fafafa] dark:bg-[#0a0a0a] text-zinc-900 dark:text-zinc-100 antialiased transition-colors duration-300">
    <script>
        window.__ADMIN__ = {
            metrics: @json($metrics ?? []),
            revenue: @json($revenueSeries ?? []),
            products: @json($productsData ?? []),
            orders: @json($ordersData ?? []),
            activities: @json($activities ?? []),
            customers: @json($customers ?? []),
            discounts: @json($discounts ?? []),
        };
    </script>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm"></div>

    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-white dark:bg-[#111] border-r border-zinc-200 dark:border-zinc-800 z-50 transform -translate-x-full lg:translate-x-0 sidebar-transition">
        <div class="p-6 flex flex-col h-full">
            <div class="flex items-center gap-3 mb-10 px-2">
                <div class="w-8 h-8 bg-black dark:bg-white rounded-lg flex items-center justify-center">
                    <div class="w-4 h-4 bg-white dark:bg-black rounded-full"></div>
                </div>
                <span class="text-xl font-bold tracking-tight">differentclubs</span>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto hide-scroll">
                <a href="#dashboard" data-page="dashboard" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>
                <a href="#products" data-page="products" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Products
                </a>
                <a href="#orders" data-page="orders" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Orders
                </a>
                <a href="#customers" data-page="customers" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Customers
                </a>
                
                <div class="pt-4 pb-2 text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest px-3">Marketing</div>
                <a href="#discounts" data-page="discounts" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Discounts
                </a>

                <div class="pt-4 pb-2 text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest px-3">System</div>
                <a href="#reports" data-page="reports" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Reports
                </a>
                <a href="#settings" data-page="settings" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Settings
                </a>
            </nav>

            <div class="mt-auto border-t border-zinc-200 dark:border-zinc-800 pt-6">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-800 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Admin+Differentclubs&background=000&color=fff" alt="Profile">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate">differentclubs Admin</p>
                        <p class="text-xs text-zinc-500 truncate">admin@differentclubs.com</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <main id="mainContent" class="lg:ml-64 min-h-screen transition-all duration-300">
        <header class="sticky top-0 z-30 bg-white/80 dark:bg-[#0a0a0a]/80 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800 px-4 py-3">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button id="sidebarToggle" class="p-2 lg:hidden rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="relative hidden md:block w-72">
                        <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" id="globalSearch" placeholder="Search anything..." class="w-full bg-zinc-100 dark:bg-zinc-900 border-none rounded-xl py-2 pl-10 pr-4 text-sm focus:ring-1 focus:ring-black dark:focus:ring-white transition-all">
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button id="themeToggle" class="p-2.5 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all" title="Toggle Theme">
                        <svg id="themeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                    <button class="p-2.5 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 relative transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-black"></span>
                    </button>
                    <div class="h-6 w-px bg-zinc-200 dark:bg-zinc-800 mx-2"></div>
                    <div class="relative" x-data="{ userMenu: false }" x-on:keydown.escape.window="userMenu = false">
                        <button x-on:click="userMenu = !userMenu" class="flex items-center gap-2 p-1 pl-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-xl transition-all">
                            <span class="text-sm font-medium hidden sm:inline">Administrator</span>
                            <img src="https://ui-avatars.com/api/?name=Admin+Differentclubs&background=000&color=fff" class="w-8 h-8 rounded-lg" alt="Avatar">
                        </button>
                        <div x-cloak x-show="userMenu" x-transition x-on:click.outside="userMenu = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#111] border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-800">
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">Administrator</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">admin@differentclubs.com</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-zinc-50 dark:hover:bg-zinc-900 text-zinc-700 dark:text-zinc-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm hover:bg-zinc-50 dark:hover:bg-zinc-900 text-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V7m5 5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="content" class="p-4 md:p-8 max-w-7xl mx-auto">
            <div id="loading" class="space-y-6">
                <div class="flex justify-between items-center mb-8">
                    <div class="h-8 w-48 skeleton rounded"></div>
                    <div class="h-10 w-32 skeleton rounded"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="h-32 skeleton rounded-2xl"></div>
                    <div class="h-32 skeleton rounded-2xl"></div>
                    <div class="h-32 skeleton rounded-2xl"></div>
                    <div class="h-32 skeleton rounded-2xl"></div>
                </div>
                <div class="h-96 skeleton rounded-2xl"></div>
            </div>
        </div>
    </main>

    <div id="modalContainer" class="fixed inset-0 z-[60] flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" id="modalOverlay"></div>
        <div id="modalContent" class="bg-white dark:bg-[#111] w-full max-w-3xl max-h-[85vh] overflow-y-auto rounded-2xl shadow-2xl relative z-10 transform transition-all scale-95 opacity-0 duration-300">
            </div>
    </div>

    <div id="toast" class="fixed bottom-6 right-6 z-[100] transform translate-y-20 transition-all duration-300 opacity-0 pointer-events-none">
        <div id="toastBody" class="px-5 py-3 rounded-xl shadow-xl bg-black dark:bg-white text-white dark:text-black flex items-center gap-3 font-medium">
            <span id="toastIcon"></span>
            <span id="toastMessage">Action successful</span>
        </div>
    </div>

    <script>
        // --- DATA STATE ---
        const formatRupiah = (v) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(Number(v) || 0);
        let metrics = window.__ADMIN__.metrics || {};
        let products = (window.__ADMIN__.products && window.__ADMIN__.products.length) ? window.__ADMIN__.products : [];
        let orders = (window.__ADMIN__.orders && window.__ADMIN__.orders.length) ? window.__ADMIN__.orders : [];
        let activities = (window.__ADMIN__.activities && window.__ADMIN__.activities.length) ? window.__ADMIN__.activities : [];
        let revenueSeries = (window.__ADMIN__.revenue && window.__ADMIN__.revenue.length) ? window.__ADMIN__.revenue : [];
        let customers = (window.__ADMIN__.customers && window.__ADMIN__.customers.length) ? window.__ADMIN__.customers : [];
        let discounts = (window.__ADMIN__.discounts && window.__ADMIN__.discounts.length) ? window.__ADMIN__.discounts : [];
        let selectedOrder = null;

        // --- CORE UI FUNCTIONS ---
        const $ = (id) => document.getElementById(id);
        const contentArea = $('content');

        // Theme Toggle
        const initTheme = () => {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                updateThemeIcon(true);
            } else {
                document.documentElement.classList.remove('dark');
                updateThemeIcon(false);
            }
        }

        const updateThemeIcon = (isDark) => {
            $('themeIcon').innerHTML = isDark 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />';
        }

        $('themeToggle').onclick = () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
            updateThemeIcon(isDark);
        }

        // Sidebar Toggle
        const toggleSidebar = () => {
            const sb = $('sidebar');
            const overlay = $('sidebarOverlay');
            const isVisible = sb.classList.contains('translate-x-0');
            
            if (isVisible) {
                sb.classList.add('-translate-x-full');
                sb.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
            } else {
                sb.classList.remove('-translate-x-full');
                sb.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            }
        }

        $('sidebarToggle').onclick = toggleSidebar;
        $('sidebarOverlay').onclick = toggleSidebar;

        // Routing System
        const navigate = (hash) => {
            const page = hash.replace('#', '') || 'dashboard';
            
            // Close sidebar on mobile after navigation
            if (window.innerWidth < 1024) {
                $('sidebar').classList.add('-translate-x-full');
                $('sidebarOverlay').classList.add('hidden');
            }

            // Update active state in nav
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('data-page') === page) {
                    link.classList.add('bg-black', 'text-white', 'dark:bg-white', 'dark:text-black');
                } else {
                    link.classList.remove('bg-black', 'text-white', 'dark:bg-white', 'dark:text-black');
                }
            });

            renderPage(page);
        }

        window.onhashchange = () => navigate(window.location.hash);
        
        const renderPage = async (page) => {
            contentArea.innerHTML = `
                <div class="space-y-6">
                    <div class="flex justify-between items-center mb-8">
                        <div class="h-8 w-48 skeleton rounded"></div>
                        <div class="h-10 w-32 skeleton rounded"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="h-32 skeleton rounded-2xl"></div>
                        <div class="h-32 skeleton rounded-2xl"></div>
                    </div>
                    <div class="h-96 skeleton rounded-2xl"></div>
                </div>
            `;

            // Simulate Loading
            await new Promise(r => setTimeout(r, 600));

            switch(page) {
                case 'dashboard': renderDashboard(); break;
                case 'products': renderProducts(); break;
                case 'orders': renderOrders(); break;
                case 'reports': renderReports(); break;
                case 'customers': renderCustomers(); break;
                case 'discounts': renderDiscounts(); break;
            }
        }

        // --- PAGE RENDERERS ---
        function renderCustomers() {
            contentArea.innerHTML = `
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Customers</h1>
                        <p class="text-zinc-500 text-sm">Daftar semua pengguna dengan role client.</p>
                    </div>
                    <div class="text-sm text-zinc-500">Total: ${customers.length} users</div>
                </div>

                <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-zinc-50 dark:bg-zinc-900/50 text-zinc-500 font-semibold uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Joined</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                ${customers.length ? customers.map(c => `
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-900/50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">${c.name}</td>
                                        <td class="px-6 py-4 text-zinc-600 dark:text-zinc-300">${c.email}</td>
                                        <td class="px-6 py-4 text-zinc-500">${c.joined ?? ''}</td>
                                    </tr>
                                `).join('') : `
                                    <tr><td colspan="3" class="px-6 py-6 text-center text-zinc-500">Belum ada customer.</td></tr>
                                `}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }

        function renderDashboard() {
            contentArea.innerHTML = `
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Dashboard Overview</h1>
                        <p class="text-zinc-500 text-sm">Welcome back, here's what's happening today.</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm font-medium hover:bg-zinc-50 dark:hover:bg-zinc-900 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Last 30 Days
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    ${renderKPICard('Total Revenue', formatRupiah(metrics.totalRevenue ?? 0), '+12.5%', true)}
                    ${renderKPICard('Active Orders', metrics.activeOrders ?? 0, '+3.1%', true)}
                    ${renderKPICard('New Customers', metrics.newCustomers ?? 0, '+18.2%', true)}
                    ${renderKPICard('Avg. Order Value', formatRupiah(metrics.avgOrderValue ?? 0), '-2.4%', false)}
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white dark:bg-[#141416] text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-700 rounded-2xl p-6 shadow-lg dark:shadow-2xl dark:shadow-black/25">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-semibold">Revenue Insights</h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-300">Performa 7 hari terakhir</p>
                            </div>
                            <div class="flex gap-4 text-xs font-medium text-zinc-600 dark:text-zinc-100">
                                <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-teal-300 shadow-[0_0_8px_rgba(94,234,212,0.6)]"></span> Revenue</div>
                                <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-zinc-200 shadow-[0_0_8px_rgba(229,231,235,0.5)]"></span> Orders</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                            <div class="col-span-2 bg-zinc-50 dark:bg-[#1d1f24] rounded-xl p-4 border border-zinc-200 dark:border-zinc-700/60">
                                <canvas id="revenueLine" height="200"></canvas>
                            </div>
                            <div class="bg-zinc-50 dark:bg-[#1d1f24] rounded-xl p-4 border border-zinc-200 dark:border-zinc-700/60">
                                <canvas id="revenueDoughnut" height="200"></canvas>
                            </div>
                        </div>
                        <div class="bg-zinc-50 dark:bg-[#1d1f24] rounded-xl p-4 border border-zinc-200 dark:border-zinc-700/60">
                            <canvas id="revenueBars" height="150"></canvas>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
                        <h3 class="font-semibold mb-6">Recent Activity</h3>
                        <div class="space-y-6">
                            ${(activities.length ? activities : [{title:'Tidak ada aktivitas', user:'', total:0, time:'-'}]).map((act) => `
                                <div class="flex gap-3">
                                    <div class="w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-900 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium">${act.title} <span class="text-zinc-500">${act.user ? 'by ' + act.user : ''}</span></p>
                                        <p class="text-[10px] text-zinc-400 mt-0.5">${act.time}</p>
                                    </div>
                                    <div class="ml-auto text-xs font-semibold text-zinc-700 dark:text-zinc-200">${act.total ? formatRupiah(act.total) : ''}</div>
                                </div>
                            `).join('')}
                        </div>
                        <button class="w-full mt-6 py-2 text-xs font-medium border border-zinc-200 dark:border-zinc-800 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-900 transition-all">View All Activity</button>
                    </div>
                </div>
            `;
            initDashboardCharts();
        }

        function renderKPICard(title, val, trend, isPositive) {
            return `
                <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-zinc-800 p-6 rounded-2xl hover:shadow-lg hover:shadow-black/5 transition-all group">
                    <p class="text-sm font-medium text-zinc-500 mb-2">${title}</p>
                    <div class="flex items-end justify-between">
                        <h2 class="text-2xl font-bold">${val}</h2>
                        <span class="text-xs font-bold px-2 py-1 rounded-lg ${isPositive ? 'bg-zinc-100 text-black dark:bg-zinc-800 dark:text-white' : 'bg-red-50 text-red-600 dark:bg-red-900/20'}">
                            ${trend}
                        </span>
                    </div>
                </div>
            `;
        }

        function renderProducts() {
            contentArea.innerHTML = `
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Products</h1>
                        <p class="text-zinc-500 text-sm">Manage your inventory and catalog.</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="exportData('products')" class="px-4 py-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm font-medium hover:bg-zinc-50 transition-all">Export</button>
                        <button onclick="openProductModal()" class="px-4 py-2 bg-black dark:bg-white text-white dark:text-black rounded-xl text-sm font-medium hover:opacity-90 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Product
                        </button>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-zinc-200 dark:border-zinc-800 flex flex-col md:flex-row gap-4 items-center justify-between">
                        <div class="relative w-full md:w-96">
                            <input type="text" onkeyup="filterTable('productSearch', 1)" id="productSearch" placeholder="Filter by product name..." class="w-full text-sm bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-xl py-2 px-4 focus:ring-1 focus:ring-black">
                        </div>
                        <div class="flex gap-2 w-full md:w-auto">
                            <select class="text-sm bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl px-3 py-2 outline-none">
                                <option>All Categories</option>
                                <option>Accessories</option>
                                <option>Electronics</option>
                            </select>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left" id="productTable">
                            <thead class="bg-zinc-50 dark:bg-zinc-900/50 text-zinc-500 text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800"><input type="checkbox" class="rounded border-zinc-300"></th>
                                    <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 cursor-pointer" onclick="sortTable(1)">Product</th>
                                    <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 cursor-pointer" onclick="sortTable(2)">Category</th>
                                    <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">Price</th>
                                    <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">Stock</th>
                                    <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                ${products.map(p => `
                                    <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-900/50 transition-colors group">
                                        <td class="px-6 py-4"><input type="checkbox" class="rounded border-zinc-300"></td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <img src="${p.image}" class="w-10 h-10 rounded-lg object-cover bg-zinc-100">
                                                <span class="font-medium text-sm">${p.name}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-zinc-500">${p.category}</td>
                                        <td class="px-6 py-4 text-sm font-semibold">${formatRupiah(p.price)}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase ${p.stock > 10 ? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' : p.stock > 0 ? 'bg-orange-50 text-orange-600' : 'bg-red-50 text-red-600'}">
                                                ${p.stock > 0 ? `${p.stock} in stock` : 'Out of Stock'}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button onclick="openProductModal(${p.id})" class="p-2 hover:text-indigo-600 transition-colors" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L7.5 21H3v-4.5L16.732 3.732z"/></svg>
                                                </button>
                                                <a href="/admin/products/${p.id}/discount" class="p-2 hover:text-emerald-600 transition-colors" title="Set Discount">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l-4.5 4.5m0 0H9m-4.5 0V14M15 10l4.5-4.5m0 0H15m4.5 0V10M6.5 17.5l11-11"/></svg>
                                                </a>
                                                <button onclick="deleteProduct(${p.id})" class="p-2 hover:text-red-600 transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }

        function renderOrders() {
            contentArea.innerHTML = `
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-bold">Orders</h1>
                    <button onclick="exportData('orders')" class="px-4 py-2 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm font-medium">Export CSV</button>
                </div>
                <div class="bg-white dark:bg-[#111] border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-zinc-50 dark:bg-zinc-900/50 text-zinc-500 text-xs font-bold uppercase">
                            <tr>
                                <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">Order ID</th>
                                <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">Customer</th>
                                <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">Date</th>
                                <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">Total</th>
                                <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">Status</th>
                                <th class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            ${orders.map(o => `
                                <tr class="hover:bg-zinc-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-bold">${o.id}</td>
                                    <td class="px-6 py-4 text-sm font-medium">${o.customer}</td>
                                    <td class="px-6 py-4 text-sm text-zinc-500">${o.date}</td>
                                    <td class="px-6 py-4 text-sm font-semibold">${formatRupiah(o.total)}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase bg-zinc-100 dark:bg-zinc-800">${o.status}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button onclick="viewOrder('${o.order_id ?? o.id}')" class="px-3 py-1 text-xs rounded-lg border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-900 transition">Detail</button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
        }

        function renderDiscounts() {
            const productOptions = products.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
            contentArea.innerHTML = `
                <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                    <div class="lg:w-1/3 bg-white dark:bg-[#111] border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                        <h2 class="text-lg font-semibold mb-1">Tambah Diskon Produk</h2>
                        <p class="text-sm text-zinc-500 mb-4">Pilih produk, tentukan persen diskon dan periode.</p>
                        <form method="POST" action="{{ route('admin.discounts.store') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Produk</label>
                                <select name="product_id" required class="mt-1 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm">
                                    <option value="">Pilih produk</option>
                                    ${productOptions}
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Persentase Diskon (%)</label>
                                <input type="number" step="0.01" min="0" max="100" name="percent" required class="mt-1 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm" placeholder="10">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Starts At</label>
                                    <input type="datetime-local" name="starts_at" class="mt-1 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Ends At</label>
                                    <input type="datetime-local" name="ends_at" class="mt-1 w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm">
                                </div>
                            </div>
                            <label class="inline-flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-200">
                                <input type="checkbox" name="is_active" value="1" class="rounded border-zinc-300 dark:border-zinc-600 text-black dark:text-white"> Aktifkan
                            </label>
                            <button type="submit" class="w-full px-4 py-2 rounded-xl bg-black text-white dark:bg-white dark:text-black font-semibold text-sm hover:opacity-90 transition">Simpan Diskon</button>
                        </form>
                    </div>
                    <div class="lg:flex-1 bg-white dark:bg-[#111] border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-lg font-semibold">Daftar Diskon</h2>
                                <p class="text-sm text-zinc-500">Diskon terbaru</p>
                            </div>
                            <span class="text-sm text-zinc-500">${discounts.length} records</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-zinc-50 dark:bg-zinc-900/50 text-zinc-500 uppercase text-xs font-semibold">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Code</th>
                                        <th class="px-4 py-3 text-left">Type</th>
                                        <th class="px-4 py-3 text-left">Value</th>
                                        <th class="px-4 py-3 text-left">Usage</th>
                                        <th class="px-4 py-3 text-left">Active</th>
                                        <th class="px-4 py-3 text-left">Period</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                    ${discounts.length ? discounts.map(d => `
                                        <tr>
                                            <td class="px-4 py-3 font-semibold">${d.code}</td>
                                            <td class="px-4 py-3 capitalize">${d.type}</td>
                                            <td class="px-4 py-3">${d.type === 'percent' ? d.value + '%' : formatRupiah(d.value)}</td>
                                            <td class="px-4 py-3 text-zinc-500">${d.used ?? 0} / ${d.max_uses ?? '∞'}</td>
                                            <td class="px-4 py-3">${d.is_active ? '<span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">Active</span>' : '<span class="px-2 py-1 rounded-full bg-zinc-100 text-zinc-500 text-xs font-semibold">Inactive</span>'}</td>
                                            <td class="px-4 py-3 text-xs text-zinc-500">${d.starts_at ?? '-'} <br> ${d.ends_at ?? '-'}</td>
                                        </tr>
                                    `).join('') : `<tr><td colspan="6" class="px-4 py-6 text-center text-zinc-500">Belum ada diskon</td></tr>`}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;
        }

        // --- UTILITIES ---

        function showToast(msg, type = 'success') {
            const toast = $('toast');
            $('toastMessage').innerText = msg;
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => toast.classList.add('translate-y-20', 'opacity-0'), 3000);
        }

        function openProductModal(productId = null) {
            const editing = productId !== null;
            const product = editing ? products.find(p => p.id === productId) : null;
            const modal = $('modalContainer');
            const inner = $('modalContent');
            const variants = product?.variants?.length ? product.variants : [
                { color: product?.color || '', size: product?.size || '', price: product?.price || 0, stock: product?.stock || 0 }
            ];
            const images = product?.images || [];

            const buildVariantRow = (v = {}) => `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3" data-variant-row>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-600 mb-1">Warna</label>
                        <input type="text" class="var-color w-full rounded-lg bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-2" value="${v.color || ''}" placeholder="Black">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-600 mb-1">Ukuran</label>
                        <input type="text" class="var-size w-full rounded-lg bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-2" value="${v.size || ''}" placeholder="M / L / XL">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-600 mb-1">Harga</label>
                            <input type="number" class="var-price w-full rounded-lg bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-2" value="${v.price || 0}" step="1000" placeholder="0">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-600 mb-1">Stok</label>
                            <input type="number" class="var-stock w-full rounded-lg bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-2" value="${v.stock || 0}" placeholder="0">
                        </div>
                    </div>
                    <div class="md:col-span-4 flex justify-end">
                        <button type="button" class="text-xs text-red-500 hover:text-red-600" onclick="removeVariantRow(this)">Hapus</button>
                    </div>
                </div>
            `;

            inner.innerHTML = `
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold mb-1">${editing ? 'Edit Product' : 'Add New Product'}</h3>
                            <p class="text-xs text-zinc-500">Lengkapi nama, deskripsi, varian (warna/ukuran), harga, stok, dan gambar.</p>
                        </div>
                        <button type="button" onclick="closeModal()" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form id="productForm" class="space-y-6 mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Nama Produk</label>
                                <input type="text" id="pName" value="${product?.name || ''}" required class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-2.5 outline-none focus:ring-1 focus:ring-black" placeholder="Minimalist Black Tee">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Slug (opsional)</label>
                                <input type="text" id="pSlug" value="${product?.slug || ''}" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-2.5 outline-none focus:ring-1 focus:ring-black" placeholder="minimalist-black-tee">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Jenis</label>
                                <input type="text" id="pType" value="${product?.type || ''}" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-2.5 outline-none focus:ring-1 focus:ring-black" placeholder="Fashion">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Kategori</label>
                                <input type="text" id="pCategory" value="${product?.category || ''}" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-2.5 outline-none focus:ring-1 focus:ring-black" placeholder="Accessories">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Brand</label>
                                <input type="text" id="pBrand" value="${product?.brand || ''}" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-2.5 outline-none focus:ring-1 focus:ring-black" placeholder="Nexus">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Deskripsi</label>
                            <textarea id="pDescription" rows="3" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-2.5 outline-none focus:ring-1 focus:ring-black" placeholder="Tuliskan deskripsi produk...">${product?.description || ''}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Harga (IDR)</label>
                                <input type="number" id="pPrice" value="${product?.price || 0}" step="1000" required class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-2.5 outline-none focus:ring-1 focus:ring-black">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Stok Total</label>
                                <input type="number" id="pStock" value="${product?.stock || 0}" required class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-2.5 outline-none focus:ring-1 focus:ring-black">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Berat (kg)</label>
                                <input type="number" id="pWeight" value="${product?.weight || ''}" step="0.01" class="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-2.5 outline-none focus:ring-1 focus:ring-black">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-zinc-800">Varian (Warna & Ukuran)</span>
                                <button type="button" id="addVariantRow" class="px-3 py-1.5 text-xs rounded-lg bg-black text-white dark:bg-white dark:text-black hover:opacity-90">Tambah Varian</button>
                            </div>
                            <div id="variantRows" class="space-y-3">
                                ${variants.map(v => buildVariantRow(v)).join('')}
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold uppercase text-zinc-500 mb-1">Gambar Produk</label>
                            <input type="file" id="pImages" accept="image/*" multiple class="w-full text-sm border border-dashed border-zinc-300 rounded-xl p-3 bg-zinc-50 dark:bg-zinc-900">
                            <p class="text-xs text-zinc-500">Pilih beberapa gambar; gambar pertama akan menjadi thumbnail.</p>
                            <div id="imagePreview" class="flex flex-wrap gap-2 mt-2">
                                ${images.map((img) => `<span class="text-[11px] px-2 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">${img}</span>`).join('')}
                            </div>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 border border-zinc-200 dark:border-zinc-800 rounded-xl font-medium">Cancel</button>
                            <button type="submit" class="flex-1 px-4 py-2 bg-black dark:bg-white text-white dark:text-black rounded-xl font-medium">${editing ? 'Update' : 'Save'} Product</button>
                        </div>
                    </form>
                </div>
            `;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                inner.classList.remove('scale-95', 'opacity-0');
                inner.classList.add('scale-100', 'opacity-100');
            }, 10);

            const variantWrap = document.getElementById('variantRows');
            const addVariantBtn = document.getElementById('addVariantRow');
            const imagePreview = document.getElementById('imagePreview');

            addVariantBtn.onclick = () => {
                variantWrap.insertAdjacentHTML('beforeend', buildVariantRow());
            };

            window.removeVariantRow = (btn) => {
                const rows = variantWrap.querySelectorAll('[data-variant-row]');
                if (rows.length === 1) return;
                btn.closest('[data-variant-row]')?.remove();
            };

            const refreshPreview = () => {
                const files = document.getElementById('pImages')?.files;
                if (!files || !files.length) return;
                imagePreview.innerHTML = Array.from(files).map(f => `<span class="text-[11px] px-2 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">${f.name}</span>`).join('');
            };
            document.getElementById('pImages')?.addEventListener('change', refreshPreview);

            document.getElementById('productForm').onsubmit = (e) => {
                e.preventDefault();
                const variantData = Array.from(variantWrap.querySelectorAll('[data-variant-row]')).map(row => ({
                    color: row.querySelector('.var-color')?.value || '',
                    size: row.querySelector('.var-size')?.value || '',
                    price: Number(row.querySelector('.var-price')?.value || 0),
                    stock: Number(row.querySelector('.var-stock')?.value || 0),
                }));
                const totalStock = variantData.reduce((a, b) => a + b.stock, 0) || Number($('pStock').value || 0);
                const files = document.getElementById('pImages')?.files;
                const fileNames = files ? Array.from(files).map(f => f.name) : images;
                const displayImage = fileNames.length ? 'https://placehold.co/100x100?text=IMG' : (product?.image ?? 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100&h=100&fit=crop');

                const payload = {
                    id: editing ? product.id : Date.now(),
                    name: $('pName').value,
                    slug: $('pSlug').value,
                    type: $('pType').value,
                    category: $('pCategory').value || 'Uncategorized',
                    brand: $('pBrand').value,
                    description: $('pDescription').value,
                    price: Number($('pPrice').value || 0),
                    stock: totalStock,
                    weight: $('pWeight').value,
                    variants: variantData,
                    images: fileNames,
                    image: displayImage,
                    status: 'active'
                };

                if (editing) {
                    products = products.map(p => p.id === product.id ? { ...p, ...payload } : p);
                } else {
                    products.unshift(payload);
                }

                closeModal();
                renderProducts();
                showToast(editing ? "Product updated" : "Product added successfully");
            };
        }

        function closeModal() {
            const inner = $('modalContent');
            inner.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                $('modalContainer').classList.add('hidden');
                inner.innerHTML = '';
            }, 300);
        }

        function deleteProduct(id) {
            if(confirm("Are you sure you want to delete this product?")) {
                products = products.filter(p => p.id !== id);
                renderProducts();
                showToast("Product removed", "error");
            }
        }

        function exportData(type) {
            let data = type === 'products' ? products : orders;
            const headers = Object.keys(data[0]).join(',');
            const rows = data.map(obj => Object.values(obj).join(',')).join('\n');
            const csvContent = "data:text/csv;charset=utf-8," + headers + "\n" + rows;
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `${type}_nexus_export.csv`);
            document.body.appendChild(link);
            link.click();
            showToast("Exporting CSV file...");
        }

        function viewOrder(orderId) {
            selectedOrder = orders.find(o => String(o.order_id ?? o.id) === String(orderId));
            if (!selectedOrder) {
                showToast('Order not found', 'error');
                return;
            }
            const inner = $('modalContent');
            const shipping = selectedOrder.shipping || {};
            const billing = selectedOrder.billing || {};
            inner.innerHTML = `
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold">Order ${selectedOrder.id}</h3>
                            <p class="text-sm text-zinc-500">Customer: ${selectedOrder.customer}${selectedOrder.customer_email ? ' • ' + selectedOrder.customer_email : ''}</p>
                        </div>
                        <button onclick="closeModal()" class="text-zinc-500 hover:text-zinc-800">✕</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 text-sm">
                        <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800">
                            <p class="text-zinc-500">Order Status</p>
                            <p class="font-semibold">${selectedOrder.status}</p>
                        </div>
                        <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800">
                            <p class="text-zinc-500">Payment</p>
                            <p class="font-semibold">${selectedOrder.payment_status ?? '-'}</p>
                        </div>
                        <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800">
                            <p class="text-zinc-500">Shipment</p>
                            <p class="font-semibold">${selectedOrder.shipment_status ?? '-'}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 text-sm">
                            <p class="font-semibold mb-2">Shipping Address</p>
                            <p>${shipping.name ?? selectedOrder.customer ?? '-'}</p>
                            <p>${shipping.address ?? ''} ${shipping.city ?? ''}</p>
                            <p>${shipping.phone ?? ''}</p>
                        </div>
                        <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 text-sm">
                            <p class="font-semibold mb-2">Billing Address</p>
                            <p>${billing.name ?? selectedOrder.customer ?? '-'}</p>
                            <p>${billing.address ?? ''} ${billing.city ?? ''}</p>
                            <p>${billing.phone ?? ''}</p>
                        </div>
                    </div>
                    <div class="border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden mb-4">
                        <table class="w-full text-sm">
                            <thead class="bg-zinc-100 dark:bg-zinc-900/50 text-zinc-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 text-left">Item</th>
                                    <th class="px-4 py-3 text-center">Qty</th>
                                    <th class="px-4 py-3 text-right">Harga</th>
                                    <th class="px-4 py-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                ${(selectedOrder.items && selectedOrder.items.length) ? selectedOrder.items.map(i => `
                                    <tr>
                                        <td class="px-4 py-3">${i.name} <span class="text-xs text-zinc-500">${i.sku ? '('+i.sku+')' : ''}</span></td>
                                        <td class="px-4 py-3 text-center">${i.qty}</td>
                                        <td class="px-4 py-3 text-right">${formatRupiah(i.price)}</td>
                                        <td class="px-4 py-3 text-right">${formatRupiah(i.total)}</td>
                                    </tr>
                                `).join('') : `<tr><td class="px-4 py-3 text-center text-zinc-500" colspan="4">Tidak ada item</td></tr>`}
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-end text-sm gap-8">
                        <div>
                            <p class="flex justify-between gap-6"><span class="text-zinc-500">Subtotal</span><span class="font-semibold">${formatRupiah(selectedOrder.total)}</span></p>
                        </div>
                    </div>
                </div>
            `;
            $('modalContainer').classList.remove('hidden');
            setTimeout(() => {
                inner.classList.remove('scale-95', 'opacity-0');
                inner.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function initDashboardCharts() {
            const dates = revenueSeries.length ? revenueSeries.map(r => r.date.slice(5)) : ['A','B','C','D','E','F','G'];
            const revenueVals = revenueSeries.length ? revenueSeries.map(r => r.total) : [40,65,55,90,75,80,110];
            const ordersDaily = orders.length ? dates.map(d => orders.filter(o => (o.date||'').slice(5) === d).length) : [12,18,15,22,17,19,25];
            const ctxLine = $('revenueLine').getContext('2d');
            const ctxDonut = $('revenueDoughnut').getContext('2d');
            const ctxBars = $('revenueBars').getContext('2d');

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        {
                            label: 'Revenue',
                            data: revenueVals,
                            borderColor: '#5eead4',
                            backgroundColor: 'rgba(94,234,212,0.12)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 3,
                        },
                        {
                            label: 'Orders',
                            data: ordersDaily,
                            borderColor: '#e5e7eb',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: false,
                            pointRadius: 3,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { ticks: { color: '#e5e7eb' }, grid: { color: 'rgba(255,255,255,0.08)' } },
                        y: { ticks: { color: '#e5e7eb', callback: v => formatRupiah(v).replace('Rp','Rp ') }, grid: { color: 'rgba(255,255,255,0.08)' } },
                    }
                }
            });

            const orderStatusCounts = orders.reduce((acc,o)=>{const k=(o.status||'').toLowerCase();acc[k]=(acc[k]||0)+1;return acc;},{});
            const donutLabels = Object.keys(orderStatusCounts).length ? Object.keys(orderStatusCounts) : ['Pending','Processing','Completed'];
            const donutData = Object.keys(orderStatusCounts).length ? Object.values(orderStatusCounts) : [10,14,20];
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: donutLabels.map(l=>l.charAt(0).toUpperCase()+l.slice(1)),
                    datasets: [{
                        data: donutData,
                        backgroundColor: ['#5eead4','#d4d4d8','#9ca3af','#52525b'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    cutout: '60%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => `${ctx.label}: ${ctx.parsed}` } }
                    }
                }
            });

            new Chart(ctxBars, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Revenue',
                        data: revenueVals,
                        backgroundColor: 'rgba(94,234,212,0.6)',
                        borderRadius: 12
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { ticks: { color: '#cbd5e1' }, grid: { display: false } },
                        y: { ticks: { color: '#cbd5e1', callback: v => formatRupiah(v).replace('Rp','Rp ') }, grid: { color: 'rgba(255,255,255,0.04)' } },
                    }
                }
            });
        }

        // Initialize App
        window.onload = () => {
            initTheme();
            navigate(window.location.hash);
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        (function() {
            const notyf = new Notyf({
                duration: 4000,
                position: { x: 'right', y: 'top' },
                dismissible: true
            });

            @if (session('status'))
                notyf.success(@json(session('status')));
            @endif
            @if (session('success'))
                notyf.success(@json(session('success')));
            @endif
            @if (session('error'))
                notyf.error(@json(session('error')));
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    notyf.error(@json($error));
                @endforeach
            @endif
        })();
    </script>
</body>
</html>
