<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model' => $this->faker->firstName,
            'year' => $this->faker->year,
            'brand_id' => Brand::all()->random()
        ];
    }
}
