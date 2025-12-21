<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalRevenue = Payment::where('status', 'succeeded')->sum('amount');
        $activeOrders = Order::whereNotIn('status', ['completed', 'cancelled'])->count();
        $newCustomers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $avgOrderValue = Order::avg('grand_total') ?? 0;

        $revenueRaw = Payment::whereNotNull('paid_at')
            ->where('status', 'succeeded')
            ->selectRaw('DATE(paid_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $dates = collect(range(0, 6))->map(fn ($i) => Carbon::now()->subDays(6 - $i)->toDateString());
        $revenueSeries = $dates->map(fn ($d) => [
            'date' => $d,
            'total' => (float) ($revenueRaw[$d]->total ?? 0),
        ])->values();

        $products = Product::with(['category', 'images'])
            ->withSum('variants as stock', 'stock')
            ->latest()
            ->take(12)
            ->get()
            ->map(function (Product $product) {
                $image = $product->images->first()?->path;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'category' => $product->category?->name ?? 'Uncategorized',
                    'category_id' => $product->category_id,
                    'brand_id' => $product->brand_id,
                    'price' => $product->price,
                    'stock' => $product->stock ?? 0,
                    'status' => $product->is_published ? 'active' : 'draft',
                    'weight' => $product->weight,
                    'type' => $product->metadata['type'] ?? null,
                    'summary' => $product->summary,
                    'description' => $product->description,
                    'image' => $image ? asset($image) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop',
                ];
            })
            ->values();

        $orders = Order::with(['user', 'items'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function (Order $order) {
                $statusValue = $order->status instanceof \BackedEnum ? $order->status->value : (string) $order->status;
                return [
                    'id' => $order->order_number ?? '#ORD-' . $order->id,
                    'order_id' => $order->id,
                    'customer' => $order->user?->name ?? 'Guest',
                    'customer_email' => $order->user?->email,
                    'total' => $order->grand_total,
                    'status' => ucfirst($statusValue),
                    'payment_status' => $order->payment_status instanceof \BackedEnum ? $order->payment_status->value : (string) $order->payment_status,
                    'shipment_status' => $order->shipment_status instanceof \BackedEnum ? $order->shipment_status->value : (string) $order->shipment_status,
                    'shipping' => $order->shipping_address,
                    'billing' => $order->billing_address,
                    'items' => $order->items->map(function ($item) {
                        return [
                            'name' => $item->product_name ?? $item->product?->name ?? 'Product',
                            'sku' => $item->sku,
                            'qty' => $item->quantity,
                            'price' => $item->unit_price,
                            'total' => $item->line_total,
                        ];
                    })->values(),
                    'date' => optional($order->created_at)->format('Y-m-d'),
                ];
            });

        $activities = Order::with('user')
            ->latest()
            ->take(8)
            ->get()
            ->map(function (Order $order) {
                return [
                    'title' => 'Order ' . ($order->order_number ?? ('#' . $order->id)),
                    'user' => $order->user?->name ?? 'Guest',
                    'total' => $order->grand_total,
                    'time' => optional($order->created_at)->diffForHumans(),
                ];
            });

        $customers = User::query()
            ->where('role', 'client')
            ->latest()
            ->get(['id', 'name', 'email', 'created_at'])
            ->map(fn (User $u) => [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'joined' => optional($u->created_at)->format('d M Y'),
            ]);

        $discounts = Discount::latest()
            ->take(50)
            ->get()
            ->map(function (Discount $d) {
                return [
                    'id' => $d->id,
                    'code' => $d->code,
                    'type' => $d->type instanceof \BackedEnum ? $d->type->value : $d->type,
                    'value' => $d->value,
                    'max_uses' => $d->max_uses,
                    'used' => $d->used,
                    'min_order_total' => $d->min_order_total,
                    'starts_at' => optional($d->starts_at)->format('Y-m-d H:i'),
                    'ends_at' => optional($d->ends_at)->format('Y-m-d H:i'),
                    'is_active' => (bool) $d->is_active,
                ];
            });

        return view('admin.dashboard', [
            'metrics' => [
                'totalRevenue' => $totalRevenue,
                'activeOrders' => $activeOrders,
                'newCustomers' => $newCustomers,
                'avgOrderValue' => $avgOrderValue,
            ],
            'productsData' => $products,
            'ordersData' => $orders,
            'revenueSeries' => $revenueSeries,
            'activities' => $activities,
            'categories' => Category::orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
            'customers' => $customers,
            'discounts' => $discounts,
        ]);
    }
}
