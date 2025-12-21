<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function create(): View
    {
        $this->authorizeAdmin();

        return view('admin.products.create', [
            'categories' => Category::orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'weight' => ['nullable', 'numeric'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'variants.name.*' => ['required', 'string', 'max:255'],
            'variants.sku.*' => ['nullable', 'string', 'max:255'],
            'variants.price.*' => ['required', 'numeric', 'min:0'],
            'variants.cost.*' => ['nullable', 'numeric', 'min:0'],
            'variants.stock.*' => ['required', 'integer', 'min:0'],
            'variants.color.*' => ['nullable', 'string', 'max:50'],
            'variants.size.*' => ['nullable', 'string', 'max:50'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['name']);

        $product = Product::create([
            'category_id' => $validated['category_id'] ?? null,
            'brand_id' => $validated['brand_id'] ?? null,
            'name' => $validated['name'],
            'slug' => $slug,
            'summary' => $validated['summary'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['base_price'] ?? ($validated['variants']['price'][0] ?? 0),
            'cost' => $validated['variants']['cost'][0] ?? 0,
            'is_published' => true,
            'published_at' => now(),
            'weight' => $validated['weight'] ?? null,
            'metadata' => [
                'type' => $validated['type'] ?? null,
            ],
        ]);

        $variantCount = count($validated['variants']['name']);
        for ($i = 0; $i < $variantCount; $i++) {
            ProductVariant::create([
                'product_id' => $product->id,
                'name' => $validated['variants']['name'][$i],
                'sku' => $validated['variants']['sku'][$i] ?: strtoupper(Str::random(8)),
                'price' => $validated['variants']['price'][$i],
                'cost' => $validated['variants']['cost'][$i] ?? 0,
                'stock' => $validated['variants']['stock'][$i],
                'is_default' => $i === 0,
                'option_values' => [
                    'color' => $validated['variants']['color'][$i] ?? null,
                    'size' => $validated['variants']['size'][$i] ?? null,
                ],
                'weight' => $validated['weight'] ?? null,
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'product_variant_id' => $product->variants()->first()?->id,
                    'path' => Storage::url($path),
                    'is_primary' => $index === 0,
                    'position' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('status', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $this->authorizeAdmin();

        return view('admin.products.edit', [
            'product' => $product->load(['variants', 'images']),
            'categories' => Category::orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'weight' => ['nullable', 'numeric'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'variants.id.*' => ['nullable', 'exists:product_variants,id'],
            'variants.name.*' => ['required', 'string', 'max:255'],
            'variants.sku.*' => ['nullable', 'string', 'max:255'],
            'variants.price.*' => ['required', 'numeric', 'min:0'],
            'variants.cost.*' => ['nullable', 'numeric', 'min:0'],
            'variants.stock.*' => ['required', 'integer', 'min:0'],
            'variants.color.*' => ['nullable', 'string', 'max:50'],
            'variants.size.*' => ['nullable', 'string', 'max:50'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ]);

        $product->update([
            'category_id' => $validated['category_id'] ?? null,
            'brand_id' => $validated['brand_id'] ?? null,
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? Str::slug($validated['name']),
            'summary' => $validated['summary'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['base_price'] ?? ($validated['variants']['price'][0] ?? $product->price),
            'cost' => $validated['variants']['cost'][0] ?? $product->cost,
            'weight' => $validated['weight'] ?? null,
            'metadata' => [
                'type' => $validated['type'] ?? ($product->metadata['type'] ?? null),
            ],
        ]);

        $existingIds = collect($validated['variants']['id'] ?? [])->filter()->all();
        $product->variants()->whereNotIn('id', $existingIds)->delete();

        $variantCount = count($validated['variants']['name']);
        for ($i = 0; $i < $variantCount; $i++) {
            $variantId = $validated['variants']['id'][$i] ?? null;
            $data = [
                'product_id' => $product->id,
                'name' => $validated['variants']['name'][$i],
                'sku' => $validated['variants']['sku'][$i] ?: strtoupper(Str::random(8)),
                'price' => $validated['variants']['price'][$i],
                'cost' => $validated['variants']['cost'][$i] ?? 0,
                'stock' => $validated['variants']['stock'][$i],
                'is_default' => $i === 0,
                'option_values' => [
                    'color' => $validated['variants']['color'][$i] ?? null,
                    'size' => $validated['variants']['size'][$i] ?? null,
                ],
                'weight' => $validated['weight'] ?? null,
            ];
            if ($variantId) {
                ProductVariant::where('id', $variantId)->update($data);
            } else {
                ProductVariant::create($data);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'product_variant_id' => $product->variants()->first()?->id,
                    'path' => Storage::url($path),
                    'is_primary' => $index === 0,
                    'position' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('status', 'Product updated successfully.');
    }

    protected function authorizeAdmin(): void
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }
}
