    <section id="shop" class="py-16 bg-gray-50" data-parallax data-parallax-speed="0.1">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h2 class="text-2xl font-serif font-bold">Featured Products</h2>
                <div class="mt-4 md:mt-0 flex space-x-2">
                    <select x-model="sortBy" x-on:change="sortProducts()" class="border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-gray-500">
                        <option value="latest">Latest</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                    </select>
                    <select x-model="filterCategory" x-on:change="filterProducts()" class="border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-gray-500">
                        <option value="all">All Categories</option>
                        <option value="tops">Tops</option>
                        <option value="bottoms">Bottoms</option>
                        <option value="outerwear">Outerwear</option>
                        <option value="accessories">Accessories</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <template x-for="product in filteredProducts" :key="product.id">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-100 product-card">
                        <div class="relative">
                            <div class="bg-gradient-to-br from-gray-200 to-gray-300 h-64 w-full"></div>
                            <div class="absolute top-3 left-3 flex space-x-2">
                                <span x-show="product.isNew" class="bg-white text-xs px-2 py-1 rounded-full">New</span>
                                <span x-show="product.isBestSeller" class="bg-black text-white text-xs px-2 py-1 rounded-full">Best Seller</span>
                                <span x-show="product.discountPercent" class="bg-gray-800 text-white text-xs px-2 py-1 rounded-full" x-text="'-' + product.discountPercent + '%'"></span>
                            </div>
                            <div class="quick-actions absolute bottom-3 left-0 right-0 flex justify-center space-x-2">
                                <button x-on:click="openQuickView(product)" class="bg-white p-2 rounded-full shadow hover:bg-gray-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button x-on:click="addToCart(product, 'M', 'Black')" class="bg-black text-white p-2 rounded-full shadow hover:bg-gray-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium" x-text="product.name"></h3>
                            <div class="flex justify-between items-center mt-2">
                                <div>
                                    <span class="font-bold" x-text="formatRupiah(product.discountPercent ? product.price * (1 - product.discountPercent/100) : product.price)"></span>
                                    <span x-show="product.discountPercent" class="text-sm text-gray-500 line-through ml-2" x-text="formatRupiah(product.price)"></span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                    <span class="text-sm ml-1" x-text="product.rating"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
