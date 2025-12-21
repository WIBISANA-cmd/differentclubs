<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | differentclubs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Playfair Display', 'serif'] },
                    colors: { gray: { 50:'#fafafa',100:'#f5f5f5',200:'#e5e5e5',300:'#d4d4d4',400:'#a3a3a3',500:'#737373',600:'#525252',700:'#404040',800:'#262626',900:'#171717' } }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-gray-900 font-sans">
    <script>
        window.__USER__ = @json($user ?? null);
    </script>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
        <div class="border-b border-gray-200 bg-white/80 backdrop-blur">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('shop.home') }}" class="text-2xl font-serif font-bold">differentclubs</a>
                    <span class="text-sm text-gray-500">Checkout</span>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('shop.home') }}" class="text-sm text-gray-600 hover:text-gray-900">Kembali ke toko</a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500">Detail penerima</p>
                                <h1 class="text-xl font-semibold">Informasi pengiriman</h1>
                            </div>
                            <span id="userBadge" class="hidden items-center text-xs px-3 py-1 rounded-full bg-gray-900 text-white">Tersimpan</span>
                        </div>
                        <form class="space-y-4" id="checkoutForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama lengkap</label>
                                    <input type="text" name="full_name" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-gray-900 focus:border-gray-900" placeholder="Nama penerima" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-gray-900 focus:border-gray-900" placeholder="email@domain.com" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                    <input type="tel" name="phone" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-gray-900 focus:border-gray-900" placeholder="08xxxxxxxxxx" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kode Pos</label>
                                    <input type="text" name="postal_code" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-gray-900 focus:border-gray-900" placeholder="Kode pos" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat lengkap</label>
                                <textarea name="address" rows="3" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-gray-900 focus:border-gray-900" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi" required></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-5 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition">Simpan dan lanjut</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold">Ringkasan pesanan</h2>
                            <a href="{{ route('shop.home') }}#shop" class="text-sm text-gray-500 hover:text-gray-800">Ubah produk</a>
                        </div>
                        <div id="cartItems" class="divide-y divide-gray-100 space-y-4"></div>
                        <div class="pt-4 mt-4 border-t border-gray-100 space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal</span>
                                <span id="subtotal">Rp0</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Ongkir (estimasi)</span>
                                <span>Rp20.000</span>
                            </div>
                            <div class="flex justify-between text-base font-semibold text-gray-900 pt-2">
                                <span>Total</span>
                                <span id="grandTotal">Rp0</span>
                            </div>
                            <button id="payButton" class="mt-4 w-full bg-black text-white rounded-lg py-3 hover:bg-gray-800 transition">Lanjutkan Pembayaran</button>
                        </div>
                    </div>

                    <div class="bg-gray-900 text-white rounded-2xl p-5">
                        <h3 class="text-lg font-semibold mb-2">Keamanan transaksi</h3>
                        <p class="text-sm text-gray-200">Data penerima dan pesanan Anda terenkripsi dan hanya digunakan untuk memproses pengiriman.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const user = window.__USER__;
        const form = document.getElementById('checkoutForm');
        const cartItemsEl = document.getElementById('cartItems');
        const subtotalEl = document.getElementById('subtotal');
        const grandTotalEl = document.getElementById('grandTotal');
        const userBadge = document.getElementById('userBadge');

        const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

        function loadCart() {
            const stored = localStorage.getItem('noirCart');
            const items = stored ? JSON.parse(stored) : [];
            cartItemsEl.innerHTML = '';

            if (!items.length) {
                cartItemsEl.innerHTML = '<p class="text-sm text-gray-500">Keranjang kosong. Tambahkan produk terlebih dahulu.</p>';
                subtotalEl.textContent = formatter.format(0);
                grandTotalEl.textContent = formatter.format(0);
                return;
            }

            let subtotal = 0;
            items.forEach(item => {
                const lineTotal = item.price * item.quantity;
                subtotal += lineTotal;
                const div = document.createElement('div');
                div.className = 'flex justify-between gap-3 pt-2';
                div.innerHTML = `
                    <div>
                        <p class="text-sm font-medium text-gray-900">${item.name}</p>
                        <p class="text-xs text-gray-500">${item.size || ''} ${item.color ? '• ' + item.color : ''} • Qty ${item.quantity}</p>
                    </div>
                    <div class="text-sm font-semibold text-gray-900">${formatter.format(lineTotal)}</div>
                `;
                cartItemsEl.appendChild(div);
            });

            subtotalEl.textContent = formatter.format(subtotal);
            grandTotalEl.textContent = formatter.format(subtotal + 20000);
        }

        function prefillUser() {
            if (!user) return;
            form.full_name.value = user.name || '';
            form.email.value = user.email || '';
            form.address.value = user.full_address || '';
            userBadge?.classList.remove('hidden');
        }

        form?.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Data penerima disimpan. Integrasi pembayaran belum diaktifkan.');
        });

        document.getElementById('payButton')?.addEventListener('click', () => {
            form?.requestSubmit();
        });

        loadCart();
        prefillUser();
    </script>
</body>
</html>
