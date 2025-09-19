<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario admin
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
        ]);

        // Crear productos
        Product::factory(10)->create();

        // Crear algunos clientes asociados al admin
        $customers = Customer::factory(5)
            ->forUser($admin)
            ->create();

        // Crear órdenes para los clientes
        foreach ($customers as $customer) {
            Order::factory(fake()->numberBetween(1, 3))->create([
                'customer_id' => $customer->id
            ]);
        }
    }
}
