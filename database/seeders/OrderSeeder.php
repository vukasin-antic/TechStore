<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Demo orders spread across the last 30 days so the dashboard
     * (stats and the sales chart) has realistic data to show.
     */
    public function run(): void
    {
        $customers = User::where('role', 'user')->get();
        $products = Product::where('stock', '>', 0)->get();
        $statuses = OrderStatus::pluck('id', 'name');

        $shippingAddresses = [
            ['address' => 'Knez Mihailova 12', 'city' => 'Beograd'],
            ['address' => 'Bulevar oslobodjenja 45', 'city' => 'Novi Sad'],
            ['address' => 'Obrenoviceva 8', 'city' => 'Nis'],
            ['address' => 'Kralja Petra I 23', 'city' => 'Kragujevac'],
            ['address' => 'Cara Dusana 5', 'city' => 'Subotica'],
            ['address' => 'Nemanjina 17', 'city' => 'Beograd'],
        ];

        $cancelReasons = [
            'Changed my mind about the purchase.',
            'Found a better price elsewhere.',
            'Ordered the wrong model by mistake.',
        ];

        // 0-3 orders per day for the last 30 days
        for ($daysAgo = 29; $daysAgo >= 0; $daysAgo--) {
            $roll = rand(1, 100);
            $ordersToday = $roll <= 20 ? 0 : ($roll <= 55 ? 1 : ($roll <= 85 ? 2 : 3));

            for ($i = 0; $i < $ordersToday; $i++) {
                $date = now()->subDays($daysAgo)->setTime(rand(8, 21), rand(0, 59), rand(0, 59));
                $statusId = $this->statusFor($daysAgo, $statuses);
                $shipping = $shippingAddresses[array_rand($shippingAddresses)];

                // pick 1-3 products with quantities, total must match the items
                $items = [];
                $total = 0;
                foreach ($products->random(rand(1, 3)) as $product) {
                    $quantity = rand(1, 100) <= 75 ? 1 : 2;
                    $items[] = ['product' => $product, 'quantity' => $quantity];
                    $total += $product->price * $quantity;
                }

                // ~15% of orders used a promo code
                $promoCode = null;
                $discountPercent = null;
                if (rand(1, 100) <= 15) {
                    [$promoCode, $discountPercent] = [['spring10', 10], ['ict20', 20]][rand(0, 1)];
                    $total -= $total * $discountPercent / 100;
                }

                $order = Order::create([
                    'user_id' => $customers->random()->id,
                    'order_number' => 'TS' . $date->year . '-TEMP-' . Str::random(10),
                    'total_price' => round($total, 2),
                    'discount' => $promoCode !== null,
                    'status_id' => $statusId,
                    'cancel_reason' => $statusId === $statuses['cancelled'] ? $cancelReasons[array_rand($cancelReasons)] : null,
                    'address' => $shipping['address'],
                    'city' => $shipping['city'],
                    'country' => 'Serbia',
                    'phone_number' => '+3816' . rand(10000000, 99999999),
                    'promo_code' => $promoCode,
                    'discount_percent' => $discountPercent,
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'quantity' => $item['quantity'],
                        'price' => $item['product']->price,
                    ]);
                }

                $order->order_number = 'TS' . $date->year . str_pad($order->id, 6, '0', STR_PAD_LEFT);
                $order->created_at = $date;
                $order->updated_at = $date;
                $order->timestamps = false;
                $order->save();
            }
        }
    }

    /**
     * Older orders are mostly delivered; recent ones are still in progress.
     * A small share is cancelled regardless of age.
     */
    private function statusFor(int $daysAgo, $statuses): int
    {
        $roll = rand(1, 100);

        if ($roll <= 7) {
            return $statuses['cancelled'];
        }
        if ($daysAgo >= 7) {
            return $roll <= 90 ? $statuses['delivered'] : $statuses['shipped'];
        }
        if ($daysAgo >= 3) {
            return $roll <= 50 ? $statuses['delivered'] : ($roll <= 80 ? $statuses['shipped'] : $statuses['processing']);
        }

        return $roll <= 40 ? $statuses['pending'] : ($roll <= 75 ? $statuses['processing'] : $statuses['shipped']);
    }
}
