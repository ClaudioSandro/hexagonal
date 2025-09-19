<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'declined']),
            'total' => 0, // Se calculará después
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $products = Product::inRandomOrder()->limit(fake()->numberBetween(1, 4))->get();
            $total = 0;

            foreach ($products as $product) {
                $quantity = fake()->numberBetween(1, 3);
                $price = $product->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price
                ]);

                $total += $price * $quantity;
            }

            $order->update(['total' => $total]);
        });
    }
}
