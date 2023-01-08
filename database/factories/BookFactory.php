<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'tags' => $this->faker->word,
            'description' => $this->faker->paragraph(5),
            'author' => fake()->name(),
            'image' => 'https://trolebus.si/storage/images/' . $this->faker->randomElement(['book1.png', 'book2.png', 'book3.png'])
        ];
    }
}
