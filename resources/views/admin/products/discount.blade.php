<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>differentclubs | Set Product Discount</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4">
        <div class="mb-6">
            <a href="{{ route('admin.products.edit', $product) }}" class="text-sm text-slate-500 hover:text-slate-800">&larr; Back to product</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Set Discount for {{ $product->name }}</h1>
            <p class="text-sm text-slate-500">Atur diskon spesifik produk. Harga akhir = price - (price * percent/100).</p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow border border-slate-200 p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                <div class="p-4 rounded-xl border border-slate-100 bg-slate-50">
                    <p class="text-slate-500">Base Price</p>
                    <p class="text-lg font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 rounded-xl border border-slate-100 bg-slate-50">
                    <p class="text-slate-500">Current Discount</p>
                    <p class="text-lg font-semibold">{{ $discount['percent'] ?? 0 }}%</p>
                </div>
                <div class="p-4 rounded-xl border border-slate-100 bg-slate-50">
                    <p class="text-slate-500">Active Period</p>
                    <p class="text-sm font-medium">
                        {{ $discount['starts_at'] ?? '-' }} s/d {{ $discount['ends_at'] ?? '-' }}
                    </p>
                </div>
            </div>

            <form action="{{ route('admin.products.discount.update', $product) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700">Discount Percent (%)</label>
                    <input type="number" name="percent" step="0.01" min="0" max="100" value="{{ old('percent', $discount['percent'] ?? 0) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
                    @error('percent')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Starts At</label>
                        <input type="datetime-local" name="starts_at" value="{{ old('starts_at', $discount['starts_at'] ?? '') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
                        @error('starts_at')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Ends At</label>
                        <input type="datetime-local" name="ends_at" value="{{ old('ends_at', $discount['ends_at'] ?? '') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
                        @error('ends_at')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-black text-white hover:bg-slate-900">Save Discount</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
