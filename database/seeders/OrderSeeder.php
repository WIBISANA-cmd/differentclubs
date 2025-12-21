<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\ShipmentStatus;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'customer@example.com')->first();
        $product = Product::first();
        $variant = $product ? ProductVariant::where('product_id', $product->id)->first() : null;
        $discount = Discount::first();

        if (! $user || ! $product || ! $variant) {
            return;
        }

        $order = Order::firstOrCreate(
            ['order_number' => 'ORD-' . strtoupper(Str::random(8))],
            [
                'user_id' => $user->id,
                'discount_id' => $discount?->id,
                'status' => OrderStatus::PAID,
                'payment_status' => PaymentStatus::SUCCEEDED,
                'shipment_status' => ShipmentStatus::PENDING,
                'currency' => 'IDR',
                'subtotal' => $variant->price,
                'discount_total' => $discount ? $variant->price * 0.1 : 0,
                'tax_total' => 0,
                'shipping_total' => 0,
                'grand_total' => $variant->price - ($discount ? $variant->price * 0.1 : 0),
                'shipping_method' => 'Standard',
                'payment_method' => 'Manual',
                'shipping_address' => [
                    'contact_name' => $user->name,
                    'address_line1' => '123 Demo Street',
                    'city' => 'Jakarta',
                    'postal_code' => '12345',
                    'country_code' => 'ID',
                ],
                'billing_address' => [
                    'contact_name' => $user->name,
                    'address_line1' => '123 Demo Street',
                    'city' => 'Jakarta',
                    'postal_code' => '12345',
                    'country_code' => 'ID',
                ],
                'placed_at' => now()->subDay(),
                'paid_at' => now()->subDay(),
                'metadata' => ['note' => 'Seed order'],
            ]
        );

        OrderItem::firstOrCreate(
            [
                'order_id' => $order->id,
                'product_variant_id' => $variant->id,
            ],
            [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'sku' => $variant->sku,
                'quantity' => 1,
                'unit_price' => $variant->price,
                'discount_total' => 0,
                'line_total' => $variant->price,
                'metadata' => ['option_values' => $variant->option_values],
            ]
        );

        Payment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'amount' => $order->grand_total,
                'method' => 'Manual',
                'status' => PaymentStatus::SUCCEEDED,
                'transaction_id' => 'PAY-' . strtoupper(Str::random(6)),
                'paid_at' => now()->subDay(),
                'payload' => ['channel' => 'seed'],
            ]
        );

        Shipment::firstOrCreate(
            ['order_id' => $order->id],
            [
                'tracking_number' => 'TRK-' . strtoupper(Str::random(8)),
                'carrier' => 'Seed Express',
                'status' => ShipmentStatus::PENDING,
                'cost' => 0,
                'payload' => ['note' => 'Seed shipment'],
            ]
        );
    }
}
