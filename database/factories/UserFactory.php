<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fullName = $this->faker->name();
        $phone = sprintf(
            '+7(%03d)-%03d-%02d-%02d',
            $this->faker->numberBetween(900, 999),
            $this->faker->numberBetween(100, 999),
            $this->faker->numberBetween(10, 99),
            $this->faker->numberBetween(10, 99)
        );

        return [
            'login' => $this->faker->unique()->userName(),
            'name' => $fullName,
            'full_name' => $fullName,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $phone,
            'role' => 'client',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
