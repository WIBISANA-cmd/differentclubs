<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Tops', 'slug' => 'tops', 'description' => 'Shirts, tees, and tops'],
            ['name' => 'Bottoms', 'slug' => 'bottoms', 'description' => 'Pants and skirts'],
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'description' => 'Jackets and hoodies'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Caps, bags, and extras'],
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
            ['name' => 'Uniqlo', 'slug' => 'uniqlo'],
            ['name' => 'Erigo', 'slug' => 'erigo'],
            ['name' => 'Levis', 'slug' => 'levis'],
            ['name' => 'H&M', 'slug' => 'hm'],
            ['name' => 'Cottonink', 'slug' => 'cottonink'],
            ['name' => 'Adidas', 'slug' => 'adidas'],
            ['name' => 'Nike', 'slug' => 'nike'],
        ])->mapWithKeys(function ($brand) {
            $brandModel = Brand::firstOrCreate(
                ['slug' => $brand['slug']],
                [
                    'name' => $brand['name'],
                    'description' => 'Brand fashion staples in Indonesia.',
                    'is_active' => true,
                ]
            );

            return [$brand['slug'] => $brandModel->id];
        });

        $products = [
            [
                'name' => 'Erigo Chino Pants Regular Fit',
                'slug' => 'erigo-chino-pants-regular-fit',
                'sku' => 'ERIGO-CHINO-REG',
                'category' => 'bottoms',
                'brand' => 'erigo',
                'price' => 299000,
                'cost' => 160000,
                'weight' => 0.6,
                'summary' => 'Chino regular fit serbaguna untuk daily wear.',
                'variants' => [
                    ['name' => 'Khaki / 30', 'sku' => 'ERIGO-CHINO-REG-30', 'price' => 299000, 'cost' => 160000, 'stock' => 45, 'is_default' => true, 'option_values' => ['color' => 'Khaki', 'size' => '30']],
                    ['name' => 'Khaki / 32', 'sku' => 'ERIGO-CHINO-REG-32', 'price' => 299000, 'cost' => 160000, 'stock' => 30, 'option_values' => ['color' => 'Khaki', 'size' => '32']],
                ],
                'images' => [
                    ['path' => 'products/erigo-chino-pants.jpg', 'is_primary' => true, 'position' => 1],
                ],
            ],
            [
                'name' => "Levi's 511 Slim Jeans",
                'slug' => 'levis-511-slim-jeans',
                'sku' => 'LEVIS-511-SLIM',
                'category' => 'bottoms',
                'brand' => 'levis',
                'price' => 1199000,
                'cost' => 650000,
                'weight' => 0.8,
                'summary' => 'Slim fit denim klasik dengan potongan modern.',
                'variants' => [
                    ['name' => 'Indigo / 30', 'sku' => 'LEVIS-511-30', 'price' => 1199000, 'cost' => 650000, 'stock' => 20, 'is_default' => true, 'option_values' => ['color' => 'Indigo', 'size' => '30']],
                    ['name' => 'Indigo / 32', 'sku' => 'LEVIS-511-32', 'price' => 1199000, 'cost' => 650000, 'stock' => 15, 'option_values' => ['color' => 'Indigo', 'size' => '32']],
                ],
                'images' => [
                    ['path' => 'products/levis-511-jeans.jpg', 'is_primary' => true, 'position' => 1],
                ],
            ],
            [
                'name' => 'Uniqlo U Crew Neck T-Shirt',
                'slug' => 'uniqlo-u-crew-neck-tee',
                'sku' => 'UNIQLO-U-TEE',
                'category' => 'tops',
                'brand' => 'uniqlo',
                'price' => 149000,
                'cost' => 70000,
                'weight' => 0.25,
                'summary' => 'Kaos cotton tebal dengan cutting relaxed.',
                'variants' => [
                    ['name' => 'White / M', 'sku' => 'UNIQLO-U-TEE-WHT-M', 'price' => 149000, 'cost' => 70000, 'stock' => 60, 'is_default' => true, 'option_values' => ['color' => 'White', 'size' => 'M']],
                    ['name' => 'Black / L', 'sku' => 'UNIQLO-U-TEE-BLK-L', 'price' => 149000, 'cost' => 70000, 'stock' => 50, 'option_values' => ['color' => 'Black', 'size' => 'L']],
                ],
                'images' => [
                    ['path' => 'products/uniqlo-u-tee.jpg', 'is_primary' => true, 'position' => 1],
                ],
            ],
            [
                'name' => 'Cottonink Basic Tee',
                'slug' => 'cottonink-basic-tee',
                'sku' => 'COTTONINK-BASIC-TEE',
                'category' => 'tops',
                'brand' => 'cottonink',
                'price' => 129000,
                'cost' => 60000,
                'weight' => 0.22,
                'summary' => 'Kaos basic lokal yang nyaman untuk layering.',
                'variants' => [
                    ['name' => 'White / M', 'sku' => 'COTTONINK-BASIC-WHT-M', 'price' => 129000, 'cost' => 60000, 'stock' => 40, 'is_default' => true, 'option_values' => ['color' => 'White', 'size' => 'M']],
                    ['name' => 'Black / L', 'sku' => 'COTTONINK-BASIC-BLK-L', 'price' => 129000, 'cost' => 60000, 'stock' => 35, 'option_values' => ['color' => 'Black', 'size' => 'L']],
                ],
                'images' => [
                    ['path' => 'products/cottonink-basic-tee.jpg', 'is_primary' => true, 'position' => 1],
                ],
            ],
            [
                'name' => 'H&M Oversized Hoodie',
                'slug' => 'hm-oversized-hoodie',
                'sku' => 'HM-OVERSIZED-HOODIE',
                'category' => 'outerwear',
                'brand' => 'hm',
                'price' => 349900,
                'cost' => 180000,
                'weight' => 0.9,
                'summary' => 'Hoodie oversized dengan bahan fleece lembut.',
                'variants' => [
                    ['name' => 'Gray / M', 'sku' => 'HM-OVERSIZED-GRY-M', 'price' => 349900, 'cost' => 180000, 'stock' => 25, 'is_default' => true, 'option_values' => ['color' => 'Gray', 'size' => 'M']],
                    ['name' => 'Black / L', 'sku' => 'HM-OVERSIZED-BLK-L', 'price' => 349900, 'cost' => 180000, 'stock' => 20, 'option_values' => ['color' => 'Black', 'size' => 'L']],
                ],
                'images' => [
                    ['path' => 'products/hm-oversized-hoodie.jpg', 'is_primary' => true, 'position' => 1],
                ],
            ],
            [
                'name' => 'Uniqlo Sweat Zip Hoodie',
                'slug' => 'uniqlo-sweat-zip-hoodie',
                'sku' => 'UNIQLO-ZIP-HOODIE',
                'category' => 'outerwear',
                'brand' => 'uniqlo',
                'price' => 399000,
                'cost' => 210000,
                'weight' => 0.95,
                'summary' => 'Zip hoodie dengan bahan sweat yang hangat.',
                'variants' => [
                    ['name' => 'Navy / M', 'sku' => 'UNIQLO-ZIP-NVY-M', 'price' => 399000, 'cost' => 210000, 'stock' => 30, 'is_default' => true, 'option_values' => ['color' => 'Navy', 'size' => 'M']],
                    ['name' => 'Black / L', 'sku' => 'UNIQLO-ZIP-BLK-L', 'price' => 399000, 'cost' => 210000, 'stock' => 25, 'option_values' => ['color' => 'Black', 'size' => 'L']],
                ],
                'images' => [
                    ['path' => 'products/uniqlo-zip-hoodie.jpg', 'is_primary' => true, 'position' => 1],
                ],
            ],
            [
                'name' => 'Adidas Trefoil Cap',
                'slug' => 'adidas-trefoil-cap',
                'sku' => 'ADIDAS-TREFOIL-CAP',
                'category' => 'accessories',
                'brand' => 'adidas',
                'price' => 299000,
                'cost' => 150000,
                'weight' => 0.2,
                'summary' => 'Topi kasual dengan logo trefoil klasik.',
                'variants' => [
                    ['name' => 'Black / One Size', 'sku' => 'ADIDAS-CAP-BLK-OS', 'price' => 299000, 'cost' => 150000, 'stock' => 50, 'is_default' => true, 'option_values' => ['color' => 'Black', 'size' => 'One Size']],
                    ['name' => 'White / One Size', 'sku' => 'ADIDAS-CAP-WHT-OS', 'price' => 299000, 'cost' => 150000, 'stock' => 35, 'option_values' => ['color' => 'White', 'size' => 'One Size']],
                ],
                'images' => [
                    ['path' => 'products/adidas-trefoil-cap.jpg', 'is_primary' => true, 'position' => 1],
                ],
            ],
            [
                'name' => 'Nike Heritage Crossbody Bag',
                'slug' => 'nike-heritage-crossbody-bag',
                'sku' => 'NIKE-HERITAGE-CB',
                'category' => 'accessories',
                'brand' => 'nike',
                'price' => 399000,
                'cost' => 210000,
                'weight' => 0.3,
                'summary' => 'Tas crossbody ringkas untuk essentials harian.',
                'variants' => [
                    ['name' => 'Black / One Size', 'sku' => 'NIKE-HERITAGE-BLK-OS', 'price' => 399000, 'cost' => 210000, 'stock' => 40, 'is_default' => true, 'option_values' => ['color' => 'Black', 'size' => 'One Size']],
                ],
                'images' => [
                    ['path' => 'products/nike-heritage-crossbody.jpg', 'is_primary' => true, 'position' => 1],
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
                    'metadata' => ['tagline' => 'Harga pasar Indonesia'],
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
