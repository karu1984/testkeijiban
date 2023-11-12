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
            'tilte'=>$this->faker->realText(10),
            'body'=>$this->faker->realText(50),
            'image'=>null,
            'user_id'=>int(99),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>null,
        ];
    }
}
