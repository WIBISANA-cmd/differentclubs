<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black/60 min-h-screen flex items-center justify-center px-4 py-10">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative z-10 w-full max-w-6xl">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Edit Product</h1>
                <p class="text-sm text-gray-200/80">Perbarui detail produk, varian, dan gambar.</p>
            </div>
            <button id="closeEditModal" type="button" class="text-sm px-3 py-1.5 rounded-lg bg-white text-black font-medium hover:bg-gray-100">
                Close
            </button>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-sm text-red-700 rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-sm text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-8 bg-white p-6 rounded-2xl shadow-2xl border border-gray-200">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-800">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="Minimalist Black Tee">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-semibold text-gray-800">Slug (opsional)</label>
                            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="minimalist-black-tee">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-800">Jenis Produk</label>
                            <input type="text" name="type" value="{{ old('type', $product->metadata['type'] ?? '') }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="Fashion / Aksesoris">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-semibold text-gray-800">Kategori</label>
                            <select name="category_id" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black">
                                <option value="">Pilih kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-800">Brand</label>
                            <select name="brand_id" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black">
                                <option value="">Pilih brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-semibold text-gray-800">Harga Produk (IDR)</label>
                            <input type="number" name="base_price" value={{ old('base_price', $product->price) }} class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="599000">
                            <p class="text-xs text-gray-500 mt-1">Dipakai sebagai harga utama (dan default varian pertama).</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-800">Berat (kg)</label>
                            <input type="number" step="0.01" name="weight" value="{{ old('weight', $product->weight) }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="0.5">
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-800">Ringkasan</label>
                        <textarea name="summary" rows="3" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="Short summary...">{{ old('summary', $product->summary) }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-800">Deskripsi</label>
                        <textarea name="description" rows="7" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="Full description...">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="text-sm font-semibold text-gray-800 mb-1">Stok total (otomatis)</div>
                        <p class="text-xs text-gray-500">Jumlah stok dihitung dari total stok seluruh varian.</p>
                        <div class="mt-2 text-lg font-bold" id="totalStock">{{ $product->variants->sum('stock') }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Variasi</h2>
                    <button type="button" id="addVariant" class="px-3 py-2 text-sm bg-black text-white rounded-lg hover:bg-gray-800">Tambah Varian</button>
                </div>
                <div id="variantsWrap" class="space-y-4">
                    @foreach($product->variants as $i => $variant)
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-3 p-4 rounded-xl border border-gray-200 bg-gray-50" data-variant-row>
                            <input type="hidden" name="variants[id][]" value="{{ $variant->id }}">
                            <div>
                                <label class="text-xs font-semibold text-gray-700">Nama Varian</label>
                                <input type="text" name="variants[name][]" value="{{ old('variants.name.'.$i, $variant->name) }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="Black / M">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-700">SKU</label>
                                <input type="text" name="variants[sku][]" value="{{ old('variants.sku.'.$i, $variant->sku) }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="SKU-001">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-700">Harga (IDR)</label>
                                <input type="number" name="variants[price][]" value="{{ old('variants.price.'.$i, $variant->price) }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="599000">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-700">Modal (IDR)</label>
                                <input type="number" name="variants[cost][]" value="{{ old('variants.cost.'.$i, $variant->cost) }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="300000">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-700">Stok</label>
                                <input type="number" name="variants[stock][]" value="{{ old('variants.stock.'.$i, $variant->stock) }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="10">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-xs font-semibold text-gray-700">Warna</label>
                                    <input type="text" name="variants[color][]" value="{{ old('variants.color.'.$i, $variant->option_values['color'] ?? '') }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="Black">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-700">Ukuran</label>
                                    <input type="text" name="variants[size][]" value="{{ old('variants.size.'.$i, $variant->option_values['size'] ?? '') }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-black focus:border-black" placeholder="M">
                                </div>
                            </div>
                            <div class="md:col-span-6 flex justify-end">
                                <button type="button" class="text-sm text-red-600 hover:underline" onclick="removeVariant(this)">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="space-y-3">
                <h2 class="text-lg font-semibold">Gambar Produk</h2>
                <input type="file" name="images[]" accept="image/*" multiple class="w-full rounded-lg border border-dashed border-gray-300 p-4">
                <p class="text-xs text-gray-500">Upload beberapa gambar (maks 2MB per file). Gambar lama tetap ada.</p>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="window.history.back()" class="px-4 py-2 rounded-lg border border-gray-300 text-sm">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-lg bg-black text-white text-sm hover:bg-gray-800">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        const wrap = document.getElementById('variantsWrap');
        const addBtn = document.getElementById('addVariant');
        const closeEdit = document.getElementById('closeEditModal');
        const totalStockEl = document.getElementById('totalStock');

        addBtn?.addEventListener('click', () => {
            const template = wrap.querySelector('[data-variant-row]');
            if (!template) return;
            const clone = template.cloneNode(true);
            clone.querySelectorAll('input').forEach((input) => {
                input.value = '';
                if (input.name.includes('variants[id]')) input.remove();
            });
            wrap.appendChild(clone);
            updateTotalStock();
        });

        window.removeVariant = (btn) => {
            const rows = wrap.querySelectorAll('[data-variant-row]');
            if (rows.length === 1) return;
            btn.closest('[data-variant-row]')?.remove();
            updateTotalStock();
        }

        closeEdit?.addEventListener('click', () => {
            window.history.back();
        });

        const updateTotalStock = () => {
            let total = 0;
            wrap.querySelectorAll('input[name="variants[stock][]"]').forEach((el) => {
                total += Number(el.value || 0);
            });
            if (totalStockEl) totalStockEl.innerText = total;
        };

        wrap.addEventListener('input', (e) => {
            if (e.target.name === 'variants[stock][]') {
                updateTotalStock();
            }
        });

        updateTotalStock();
    </script>
</body>
</html>
