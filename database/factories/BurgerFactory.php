<?php

namespace Database\Factories;

use App\Models\Burger;
use Illuminate\Database\Eloquent\Factories\Factory;

class BurgerFactory extends Factory
{
    protected $model = Burger::class;

    public function definition()
    {
        return [
            'nom'         => $this->faker->words(2, true), // ex: "Double Cheese"
            'prix'        => $this->faker->randomFloat(2, 5, 20),
            'image' => 'burgers/' . $this->faker->randomElement(['burger1.jpg', 'burger2.jpg', 'burger3.jpg']),
            'description' => $this->faker->sentence(10),
            'stock'       => $this->faker->numberBetween(0, 100),
        ];
    }
}
