<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'author' => $this->faker->name(),
            'type' => $this->faker->randomElement(['post', 'page', 'attachment', 'revision', 'nav_menu_item']),
            'status' => $this->faker->randomElement(['publish', 'draft', 'pending', 'private']),
            'start' => $this->faker->randomElement(['day', 'month', 'year']),
            'begin' => $this->faker->randomElement(['day', 'month', 'year']),
            'end' => $this->faker->randomElement(['day', 'month', 'year']),
        ];
    }
}
