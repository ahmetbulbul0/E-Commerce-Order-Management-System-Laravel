<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admins: 2
        User::factory()->create([
            'name' => 'Admin One',
            'email' => 'admin1@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Admin Two',
            'email' => 'admin2@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Categories: 5, Products: 20
        Category::factory(5)->create();
        Product::factory(20)->create();

        // Customers: 10
        $customers = User::factory(10)->create();

        // Carts: 10
        $products = Product::inRandomOrder()->take(10)->get();
        foreach ($products as $index => $product) {
            Cart::create([
                'user_id' => $customers[$index % $customers->count()]->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 3),
            ]);
        }

        // Orders: 15 (with payments)
        for ($i = 0; $i < 15; $i++) {
            /** @var User $customer */
            $customer = $customers->random();
            $order = Order::factory()->create([
                'user_id' => $customer->id,
            ]);

            Payment::factory()->create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
            ]);
        }
    }
}
