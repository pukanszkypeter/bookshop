<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $possible_styles = ['primary','secondary','success','danger','warning','info','dark','light'];

        return [
            'name' => $this->faker->word,
            'style' => $this->faker->randomElement($possible_styles),
        ];
    }
}
