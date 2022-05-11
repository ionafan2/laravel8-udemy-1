<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(8),
            'content' => $this->faker->paragraph(2, true)
        ];
    }


    public function testNewTile()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'New blog post',
                'content' => 'Some content',
            ];
        });
    }
}
