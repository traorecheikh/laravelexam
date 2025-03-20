<?php

namespace Database\Factories;

use App\Models\Burger;
use Illuminate\Database\Eloquent\Factories\Factory;

class BurgerFactory extends Factory
{
    protected $model = Burger::class;

    public function definition()
    {
        $categories = [
            'Cheese Burger',
            'Panini Burger',
            'Brochette Burger',
            'Fast Food Burger',
            'Spicy Burger',
            'Gourmet Burger'
        ];

        $descriptions = [
            'Un délicieux burger avec trois couches de fromage fondu, parfait pour les amateurs de fromage.',
            'Un burger à la panini grillé avec des ingrédients frais, idéal pour un repas rapide.',
            'Un burger savoureux avec des légumes grillés en brochette et une viande juteuse, parfait pour les amoureux du barbecue.',
            'Un burger inspiré de la restauration rapide, avec une galette juteuse, du bacon croustillant et une sauce spéciale.',
            'Un burger épicé avec des jalapeños, du fromage crémeux et une sauce piquante pour un goût relevé.',
            'Un burger gourmet avec un bœuf de qualité, des légumes frais et une sauce signature.',
        ];

        $description = $this->faker->randomElement($descriptions);
        $categorie = $categories[array_search($description, $descriptions)];

        return [
            'nom' => $this->faker->randomElement([
                'Triple Cheese Burger',
                'Burger Panini',
                'Burger Brochette',
                'MC Do Express',
                'Burger Chwzy',
                'Burger Special'
            ]),
            'prix' => $this->faker->numberBetween(4000, 9000),
            'image' => 'images/' . $this->faker->randomElement([
                    'burger1.jpg',
                    'burger2.jpg',
                    'burger3.jpg',
                    'burger4.jpg',
                    'burger5.jpg',
                    'burger6.jpg'
                ]),
            'description' => $description,
            'categorie' => $categorie,
            'stock' => $this->faker->numberBetween(0, 50),
        ];
    }
}
