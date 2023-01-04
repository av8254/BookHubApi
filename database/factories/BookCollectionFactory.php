<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookCollection>
 */
class BookCollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'book_id' => $this->faker->unique()->numberBetween(1,50),
            'collection_id' => $this->faker->unique()->numberBetween(1,20)
        ];
    }
}
