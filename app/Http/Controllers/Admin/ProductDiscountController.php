<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductDiscountController extends Controller
{
    public function edit(Product $product): View
    {
        $discount = $product->metadata['discount'] ?? null;

        return view('admin.products.discount', compact('product', 'discount'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        $metadata = $product->metadata ?? [];
        $metadata['discount'] = [
            'percent' => (float) $data['percent'],
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
        ];

        $product->metadata = $metadata;
        $product->save();

        return redirect()
            ->route('admin.products.discount.edit', $product)
            ->with('status', 'Diskon produk berhasil disimpan.');
    }
}
