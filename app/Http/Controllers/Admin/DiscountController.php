<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\DiscountType;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        $code = 'PROD-' . $product->id . '-' . strtoupper(str()->random(4));

        Discount::create([
            'code' => $code,
            'type' => DiscountType::PERCENTAGE,
            'value' => (float) $data['percent'],
            'max_uses' => null,
            'used' => 0,
            'min_order_total' => 0,
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'is_active' => true,
            'metadata' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'applies' => 'product',
            ],
        ]);

        return back()->with('success', 'Diskon berhasil dibuat.');
    }
}
