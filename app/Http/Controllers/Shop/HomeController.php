<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['variants', 'images'])
            ->where('is_published', true)
            ->latest('published_at')
            ->take(16)
            ->get()
            ->map(function (Product $product) {
                $defaultVariant = $product->variants->firstWhere('is_default', true) ?? $product->variants->first();
                $colors = $product->variants->pluck('option_values.color')->filter()->unique()->values()->all();
                $sizes = $product->variants->pluck('option_values.size')->filter()->unique()->values()->all();
                $stock = $product->variants->sum('stock');
                $isNew = $product->published_at ? $product->published_at->gt(Carbon::now()->subDays(30)) : false;

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => optional($product->category)->slug ?? 'uncategorized',
                    'price' => $defaultVariant?->price ?? $product->price,
                    'rating' => 4.8,
                    'isNew' => $isNew,
                    'isBestSeller' => $stock > 30,
                    'discountPercent' => 0,
                    'colors' => $colors ?: ['Black', 'Gray'],
                    'sizes' => $sizes ?: ['M', 'L', 'XL'],
                    'stock' => $stock,
                ];
            })
            ->values();

        $user = auth()->user();

        return view('shop.home', [
            'products' => $products,
            'user' => $user ? [
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->profile_photo_path ? Storage::url($user->profile_photo_path) : null,
            ] : null,
        ]);
    }
}
