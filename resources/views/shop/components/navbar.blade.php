    <div class="bg-black text-white text-sm py-2 px-4 text-center">
        differentclubs • Gratis pengiriman dunia untuk order di atas Rp 1.500.000 • Gunakan kode: DC10
    </div>

    <header class="sticky top-0 z-50 reveal transition duration-300" data-parallax data-parallax-speed="0.15" data-animate
        :class="isNavStuck ? 'bg-white/85 backdrop-blur-xl border-b border-white/60 shadow-lg shadow-black/10' : 'bg-transparent'">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between rounded-full bg-white/70 border border-white/50 backdrop-blur-xl shadow-lg shadow-black/5 px-4 md:px-6 py-3 transition duration-300"
                :class="isNavStuck ? 'shadow-xl shadow-black/10 bg-white/90' : ''">
                <a href="#" class="text-2xl font-serif font-bold">differentclubs</a>

                <nav class="hidden md:flex space-x-8">
                    <a href="#shop" class="hover:text-gray-600 transition">Shop</a>
                    <a href="#new" class="hover:text-gray-600 transition">New</a>
                    <a href="#collections" class="hover:text-gray-600 transition">Collections</a>
                    <a href="#about" class="hover:text-gray-600 transition">About</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <button x-on:click="searchOpen = !searchOpen" class="p-2 hover:text-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                    <button x-on:click="cartOpen = true" class="p-2 hover:text-gray-600 transition relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span x-show="cartCount > 0" class="absolute -top-1 -right-1 bg-black text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" x-text="cartCount"></span>
                    </button>
                    <div class="relative">
                        <button x-on:click="userMenuOpen = !userMenuOpen" class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-full bg-white/20 text-gray-900 border border-white/40 backdrop-blur hover:bg-white/40 transition">
                            <span class="text-sm font-medium" x-text="user.isAuthenticated ? user.name : 'Login'"></span>
                            <template x-if="user.avatar">
                                <img :src="user.avatar" alt="avatar" class="w-8 h-8 rounded-full object-cover ring-2 ring-white">
                            </template>
                            <template x-if="!user.avatar">
                                <div class="w-8 h-8 rounded-full bg-white text-black flex items-center justify-center font-semibold ring-2 ring-white">
                                    <span x-text="user.initials"></span>
                                </div>
                            </template>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="userMenuOpen" x-transition x-on:click.outside="userMenuOpen = false" class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 shadow-2xl rounded-xl overflow-hidden z-50">
                            <template x-if="!user.isAuthenticated">
                                <div>
                                    <div class="px-4 py-3 bg-black text-white">
                                        <p class="text-sm font-semibold">Welcome</p>
                                        <p class="text-xs text-gray-200">Masuk untuk melanjutkan</p>
                                    </div>
                                    <div class="py-2">
                                        <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 16l4-4m0 0l-4-4m4 4H9m6 4v1m0-9V7m5 5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Login
                                        </a>
                                        <a href="{{ route('register') }}" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Sign Up
                                        </a>
                                    </div>
                                </div>
                            </template>
                            <template x-if="user.isAuthenticated">
                                <div>
                                    <div class="px-4 py-3 bg-black text-white">
                                        <p class="text-sm font-semibold" x-text="user.name"></p>
                                        <p class="text-xs text-gray-200" x-text="user.email"></p>
                                    </div>
                                    <div class="py-2">
                                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Profile
                                        </a>
                                        <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 0a3 3 0 015.196 2.021A2.5 2.5 0 0119.5 10c0 1.063-.67 1.968-1.61 2.307M12 6a3 3 0 00-5.196 2.021A2.5 2.5 0 004.5 10c0 1.063.67 1.968 1.61 2.307M12 18v-2m0-4v-2"/></svg>
                                            Orders
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2 text-sm hover:bg-gray-100 transition text-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V7m5 5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <button class="md:hidden p-2 hover:text-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="searchOpen" x-transition class="md:hidden px-4 py-2">
            <div class="relative">
                <input type="text" placeholder="Search..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-500">
                <button class="absolute right-3 top-2.5 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </div>
    </header>
