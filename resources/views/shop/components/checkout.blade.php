    <section x-show="checkoutOpen" class="py-16 bg-white reveal" data-parallax data-parallax-speed="0.08" data-animate>
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-2xl font-serif font-bold mb-8">Checkout</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-medium mb-4">Shipping Information</h3>
                    <form @submit.prevent="placeOrder">
                        <div class="space-y-4">
                            <div>
                                <label for="full-name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" id="full-name" x-model="checkoutInfo.fullName" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" x-model="checkoutInfo.email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="tel" id="phone" x-model="checkoutInfo.phone" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500">
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" id="address" x-model="checkoutInfo.address" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" id="city" x-model="checkoutInfo.city" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500">
                                </div>
                                <div>
                                    <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                    <input type="text" id="postal-code" x-model="checkoutInfo.postalCode" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500">
                                </div>
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select id="country" x-model="checkoutInfo.country" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-500 focus:border-gray-500">
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>United Kingdom</option>
                                    <option>Australia</option>
                                    <option>Germany</option>
                                </select>
                            </div>
                        </div>
                        <h3 class="text-lg font-medium mt-8 mb-4">Shipping Method</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="standard" name="shipping-method" type="radio" x-model="checkoutInfo.shippingMethod" value="standard" class="focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="standard" class="font-medium text-gray-700">Standard Shipping</label>
                                    <p class="text-gray-500">3-5 business days • $5.99</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="express" name="shipping-method" type="radio" x-model="checkoutInfo.shippingMethod" value="express" class="focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="express" class="font-medium text-gray-700">Express Shipping</label>
                                    <p class="text-gray-500">1-2 business days • $12.99</p>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-lg font-medium mt-8 mb-4">Payment Method</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="credit-card" name="payment-method" type="radio" x-model="checkoutInfo.paymentMethod" value="credit-card" class="focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="credit-card" class="font-medium text-gray-700">Credit Card</label>
                                    <p class="text-gray-500">Pay with Visa, Mastercard, etc.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="paypal" name="payment-method" type="radio" x-model="checkoutInfo.paymentMethod" value="paypal" class="focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="paypal" class="font-medium text-gray-700">PayPal</label>
                                    <p class="text-gray-500">Pay with your PayPal account</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="bank-transfer" name="payment-method" type="radio" x-model="checkoutInfo.paymentMethod" value="bank-transfer" class="focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="bank-transfer" class="font-medium text-gray-700">Bank Transfer</label>
                                    <p class="text-gray-500">Direct bank transfer</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    <h3 class="text-lg font-medium mb-4">Order Summary</h3>
                    <div class="bg-gray-50 rounded-lg p-6 reveal" data-animate data-animate-delay="0.9s">
                        <div class="flow-root">
                            <ul class="-my-4 divide-y divide-gray-200">
                                <template x-for="item in cart" :key="item.id + item.size + item.color">
                                    <li class="py-4 flex">
                                        <div class="flex-shrink-0 bg-gray-200 rounded-md w-16 h-16"></div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h4 x-text="item.name"></h4>
                                                <p x-text="formatRupiah(item.price * item.quantity)"></p>
                                            </div>
                                            <p class="text-sm text-gray-500" x-text="item.size + ' / ' + item.color + ' • Qty: ' + item.quantity"></p>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        <div class="mt-6 space-y-4">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Subtotal</p>
                                <p x-text="formatRupiah(cartTotal)"></p>
                            </div>
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Shipping</p>
                                <p x-text="checkoutInfo.shippingMethod === 'express' ? '$12.99' : '$5.99'"></p>
                            </div>
                            <div class="flex justify-between text-base font-medium text-gray-900 pt-4 border-t border-gray-200">
                                <p>Total</p>
                                <p x-text="formatRupiah(cartTotal + (checkoutInfo.shippingMethod === 'express' ? 129900 : 59900))"></p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button @click="placeOrder()" class="w-full bg-black text-white py-3 px-6 rounded-lg hover:bg-gray-800 transition">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
