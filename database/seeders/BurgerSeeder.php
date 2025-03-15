<?php

namespace Database\Seeders;

use App\Models\Burger;
use Illuminate\Database\Seeder;

class BurgerSeeder extends Seeder
{
    public function run()
    {
        Burger::factory()->count(20)->create();
    }
}
