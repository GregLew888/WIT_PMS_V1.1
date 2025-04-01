<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'user_id' => 1,
            'isbn' => $this->faker->isbn10(),
            'title' => $this->faker->title(),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->name(),
            'year_of_publication' => $this->faker->numberBetween(1900, 2023),
            'category' => $this->faker->name(),
        ];
    }
}
