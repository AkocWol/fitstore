<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class; // dit koppelt de factory aan het model

    public function definition(): array
    {
        $name = $this->faker->words(rand(2,3), true);

        return [
            'name'        => Str::title($name),
            'slug'        => Str::slug($name.'-'.Str::random(4)),
            'category'    => $this->faker->randomElement(['Supplements','Hydration','Recovery','Snacks']),
            'description' => $this->faker->sentence(12),
            'price'       => $this->faker->randomFloat(2, 3, 60),
        ];
    }
}

