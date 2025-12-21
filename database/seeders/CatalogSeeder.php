<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Tops', 'slug' => 'tops', 'description' => 'Shirts, tees, and tops'],
            ['name' => 'Bottoms', 'slug' => 'bottoms', 'description' => 'Pants and skirts'],
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'description' => 'Jackets and coats'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Belts, watches, scarves'],
        ])->mapWithKeys(function ($cat) {
            $category = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'is_active' => true,
                    'position' => 0,
                ]
            );
            return [$cat['slug'] => $category->id];
        });

        $brands = collect([
            ['name' => 'Noir Studio', 'slug' => 'noir-studio'],
            ['name' => 'Daylight', 'slug' => 'daylight'],
            ['name' => 'Ascend', 'slug' => 'ascend'],
        ])->mapWithKeys(function ($brand) {
            $brandModel = Brand::firstOrCreate(
                ['slug' => $brand['slug']],
                [
                    'name' => $brand['name'],
                    'description' => 'Curated minimalist pieces.',
                    'is_active' => true,
                ]
            );
            return [$brand['slug'] => $brandModel->id];
        });

        $products = [
            [
                'name' => 'Classic White Shirt',
                'slug' => 'classic-white-shirt',
                'sku' => 'CLS-WHT-001',
                'category' => 'tops',
                'brand' => 'noir-studio',
                'price' => 599000,
                'cost' => 300000,
                'weight' => 0.35,
                'summary' => 'Crisp white cotton shirt for everyday wear.',
                'variants' => [
                    ['name' => 'White / M', 'sku' => 'CLS-WHT-001-M', 'price' => 599000, 'cost' => 300000, 'stock' => 40, 'is_default' => true, 'option_values' => ['color' => 'White', 'size' => 'M']],
                    ['name' => 'White / L', 'sku' => 'CLS-WHT-001-L', 'price' => 599000, 'cost' => 300000, 'stock' => 25, 'option_values' => ['color' => 'White', 'size' => 'L']],
                ],
                'images' => [
                    ['path' => 'products/classic-white-shirt-1.jpg', 'is_primary' => true, 'position' => 1],
                    ['path' => 'products/classic-white-shirt-2.jpg', 'position' => 2],
                ],
            ],
            [
                'name' => 'Black Slim Jeans',
                'slug' => 'black-slim-jeans',
                'sku' => 'BLK-JNS-001',
                'category' => 'bottoms',
                'brand' => 'daylight',
                'price' => 899000,
                'cost' => 500000,
                'weight' => 0.65,
                'summary' => 'Stretch denim with a clean tapered fit.',
                'variants' => [
                    ['name' => 'Black / 30', 'sku' => 'BLK-JNS-001-30', 'price' => 899000, 'cost' => 500000, 'stock' => 30, 'is_default' => true, 'option_values' => ['color' => 'Black', 'size' => '30']],
                    ['name' => 'Black / 32', 'sku' => 'BLK-JNS-001-32', 'price' => 899000, 'cost' => 500000, 'stock' => 20, 'option_values' => ['color' => 'Black', 'size' => '32']],
                ],
                'images' => [
                    ['path' => 'products/black-slim-jeans-1.jpg', 'is_primary' => true, 'position' => 1],
                ],
            ],
            [
                'name' => 'Wool Blend Coat',
                'slug' => 'wool-blend-coat',
                'sku' => 'WBC-001',
                'category' => 'outerwear',
                'brand' => 'ascend',
                'price' => 1999000,
                'cost' => 1100000,
                'weight' => 1.2,
                'summary' => 'Structured wool blend coat for cold days.',
                'variants' => [
                    ['name' => 'Black / M', 'sku' => 'WBC-001-M', 'price' => 1999000, 'cost' => 1100000, 'stock' => 10, 'is_default' => true, 'option_values' => ['color' => 'Black', 'size' => 'M']],
                    ['name' => 'Gray / L', 'sku' => 'WBC-001-L', 'price' => 1999000, 'cost' => 1100000, 'stock' => 8, 'option_values' => ['color' => 'Gray', 'size' => 'L']],
                ],
                'images' => [
                    ['path' => 'products/wool-blend-coat-1.jpg', 'is_primary' => true, 'position' => 1],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::firstOrCreate(
                ['slug' => $productData['slug']],
                [
                    'category_id' => $categories[$productData['category']] ?? null,
                    'brand_id' => $brands[$productData['brand']] ?? null,
                    'name' => $productData['name'],
                    'sku' => $productData['sku'],
                    'summary' => $productData['summary'] ?? null,
                    'description' => $productData['summary'] ?? null,
                    'price' => $productData['price'],
                    'cost' => $productData['cost'],
                    'weight' => $productData['weight'] ?? null,
                    'is_published' => true,
                    'published_at' => now(),
                    'metadata' => ['tagline' => 'Monochrome essential'],
                ]
            );

            $variantModels = collect();
            foreach ($productData['variants'] as $variant) {
                $variantModels->push(
                    ProductVariant::firstOrCreate(
                        ['sku' => $variant['sku']],
                        [
                            'product_id' => $product->id,
                            'name' => $variant['name'],
                            'price' => $variant['price'],
                            'cost' => $variant['cost'],
                            'stock' => $variant['stock'],
                            'is_default' => $variant['is_default'] ?? false,
                            'option_values' => $variant['option_values'] ?? [],
                            'weight' => $product->weight,
                        ]
                    )
                );
            }

            foreach ($productData['images'] as $image) {
                ProductImage::firstOrCreate(
                    ['product_id' => $product->id, 'path' => $image['path']],
                    [
                        'product_variant_id' => optional($variantModels->firstWhere('is_default', true))->id,
                        'is_primary' => $image['is_primary'] ?? false,
                        'position' => $image['position'] ?? 0,
                        'metadata' => ['alt' => $product->name],
                    ]
                );
            }
        }
    }
}
