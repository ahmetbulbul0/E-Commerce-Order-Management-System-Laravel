<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        Category::factory(5)->create();
        Product::factory(20)->create();

        $customers = User::factory(5)->create();

        $customers->each(function (User $customer) {
            $orders = Order::factory(2)->create([
                'user_id' => $customer->id,
            ]);

            $orders->each(function (Order $order) {
                Payment::factory()->create([
                    'order_id' => $order->id,
                    'amount' => $order->total_amount,
                ]);
            });
        });
    }
}
