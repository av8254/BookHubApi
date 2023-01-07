<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'rating' => $this->faker->randomElement([1,2,3,4,5]),
            'comment' => $this->faker->sentence(3),
            'user_id' => $this->faker->numberBetween(1,10),
            'book_id' => $this->faker->numberBetween(1,50)
        ];
    }
}
