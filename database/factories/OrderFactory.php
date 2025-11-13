<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $phone = sprintf(
            '+7(%03d)-%03d-%02d-%02d',
            $this->faker->numberBetween(900, 999),
            $this->faker->numberBetween(100, 999),
            $this->faker->numberBetween(10, 99),
            $this->faker->numberBetween(10, 99)
        );

        return [
            'user_id' => User::factory(),
            'contact_name' => $this->faker->name(),
            'contact_phone' => $phone,
            'contact_email' => $this->faker->safeEmail(),
            'address' => 'г. Москва, ' . $this->faker->streetAddress(),
            'preferred_date' => now()->addDays($this->faker->numberBetween(1, 5))->toDateString(),
            'preferred_time' => $this->faker->time('H:i'),
            'payment_method' => $this->faker->randomElement(['cash', 'card']),
            'status' => Order::STATUS_NEW,
            'total_price' => $this->faker->numberBetween(1000, 15000),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
