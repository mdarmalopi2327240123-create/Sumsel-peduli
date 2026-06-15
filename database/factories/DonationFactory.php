<?php

namespace Database\Factories;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->numberBetween(50000, 5000000),
            'donor_name' => $this->faker->name(),
            'donor_email' => $this->faker->email(),
            'donor_phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'payment_method' => $this->faker->randomElement(['Transfer Bank', 'E-Wallet', 'Kartu Kredit', 'Cicilan']),
            'transaction_id' => $this->faker->uuid(),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
