    <!-- Quick View Modal -->
    <div x-show="quickViewOpen" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape="quickViewOpen = false">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="quickViewOpen" x-transition.opacity class="fixed inset-0 transition-opacity modal-overlay" @click="quickViewOpen = false">
                <div class="absolute inset-0 bg-black opacity-50"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="quickViewOpen" x-transition class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline" x-text="quickViewProduct.name"></h3>
                                <button @click="quickViewOpen = false" class="text-gray-500 hover:text-gray-700">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl h-64 w-full"></div>
                                    <div class="flex mt-3 space-x-2">
                                        <div class="bg-gray-300 rounded-lg h-16 w-16 cursor-pointer"></div>
                                        <div class="bg-gray-400 rounded-lg h-16 w-16 cursor-pointer"></div>
                                        <div class="bg-gray-500 rounded-lg h-16 w-16 cursor-pointer"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-xl" x-text="formatRupiah(quickViewProduct.discountPercent ? quickViewProduct.price * (1 - quickViewProduct.discountPercent/100) : quickViewProduct.price)"></span>
                                            <span x-show="quickViewProduct.discountPercent" class="text-sm text-gray-500 line-through ml-2" x-text="formatRupiah(quickViewProduct.price)"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                            <span class="text-sm ml-1" x-text="quickViewProduct.rating"></span>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-gray-600" x-text="quickViewProduct.description || 'Premium quality fabric with minimalist design. Perfect for everyday wear.'"></p>
                                    <div class="mt-6">
                                        <h4 class="text-sm font-medium text-gray-900">Color</h4>
                                        <div class="mt-2 flex space-x-2">
                                            <template x-for="color in quickViewProduct.colors" :key="color">
                                                <button @click="selectedColor = color" class="w-8 h-8 rounded-full border-2 flex items-center justify-center" :class="{'border-black': selectedColor === color, 'border-transparent': selectedColor !== color}">
                                                    <span class="block w-6 h-6 rounded-full" :class="{'bg-black': color === 'Black', 'bg-white border border-gray-300': color === 'White', 'bg-gray-500': color === 'Gray'}"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <h4 class="text-sm font-medium text-gray-900">Size</h4>
                                        <div class="mt-2 flex space-x-2">
                                            <template x-for="size in quickViewProduct.sizes" :key="size">
                                                <button @click="selectedSize = size" class="px-4 py-2 border rounded-md text-sm" :class="{'bg-black text-white border-black': selectedSize === size, 'border-gray-300': selectedSize !== size}">
                                                    <span x-text="size"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <h4 class="text-sm font-medium text-gray-900">Quantity</h4>
                                        <div class="mt-2 flex items-center">
                                            <button @click="quantity > 1 ? quantity-- : null" class="border border-gray-300 rounded-l-md px-3 py-1">-</button>
                                            <span class="border-t border-b border-gray-300 px-4 py-1" x-text="quantity"></span>
                                            <button @click="quantity++" class="border border-gray-300 rounded-r-md px-3 py-1">+</button>
                                        </div>
                                    </div>
                                    <div class="mt-8 flex space-x-3">
                                        <button @click="addToCart(quickViewProduct, selectedSize, selectedColor, quantity); quickViewOpen = false" class="flex-1 bg-black text-white py-3 px-6 rounded-lg hover:bg-gray-800 transition">Add to Cart</button>
                                        <button class="border border-black py-3 px-6 rounded-lg hover:bg-gray-100 transition">Wishlist</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Drawer -->
    <div x-show="cartOpen" class="fixed inset-0 z-50 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="cartOpen" x-transition.opacity class="absolute inset-0 bg-black bg-opacity-50 transition-opacity" @click="cartOpen = false"></div>
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div x-show="cartOpen" x-transition class="w-screen max-w-md cart-drawer transform transition ease-in-out duration-300 sm:duration-500 translate-x-full" :class="{'translate-x-0': cartOpen}">
                    <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                        <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900">Shopping cart</h2>
                                <button @click="cartOpen = false" class="text-gray-500 hover:text-gray-700">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul class="-my-6 divide-y divide-gray-200">
                                        <template x-for="(item, index) in cart" :key="item.id + item.size + item.color">
                                            <li class="py-6 flex">
                                                <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded-md overflow-hidden"></div>
                                                <div class="ml-4 flex-1 flex flex-col">
                                                    <div>
                                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                                            <h3 x-text="item.name"></h3>
                                                            <p class="ml-4" x-text="formatRupiah(item.price * item.quantity)"></p>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500" x-text="item.size + ' / ' + item.color"></p>
                                                    </div>
                                                    <div class="flex-1 flex items-end justify-between text-sm">
                                                        <div class="flex items-center">
                                                            <button @click="updateQuantity(index, item.quantity - 1)" class="border border-gray-300 rounded-md px-2 py-1">-</button>
                                                            <span class="mx-2" x-text="item.quantity"></span>
                                                            <button @click="updateQuantity(index, item.quantity + 1)" class="border border-gray-300 rounded-md px-2 py-1">+</button>
                                                        </div>
                                                        <button @click="removeFromCart(index)" class="font-medium text-gray-500 hover:text-gray-800">Remove</button>
                                                    </div>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Subtotal</p>
                                <p x-text="formatRupiah(cartTotal)"></p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                            <div class="mt-6">
                                <button @click="checkoutOpen = true; cartOpen = false" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-black hover:bg-gray-800 w-full">Checkout</button>
                            </div>
                            <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                                <p>or <button @click="cartOpen = false" class="text-gray-600 font-medium hover:text-gray-800">Continue Shopping<span aria-hidden="true"> &rarr;</span></button></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
