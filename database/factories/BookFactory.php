<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Generate random names
        $length = rand(1,3);
        $names = [];
        for ($i=1; $i <= $length; $i++) {
            array_push($names,$this->faker->name);
        }
        $names = implode(", ", $names);

        return [
            'title' => Str::ucfirst($this->faker->words($this->faker->numberBetween(1,4), true)),
            'authors' => $names,
            'description' => $this->faker->sentence(),
            'released_at' => $this->faker->date('Y-m-d'),
            'cover_image' => null,
            'pages' => $this->faker->numberBetween(20,600),
            'language_code' => $this->faker->languageCode,
            'isbn' => $this->faker->numerify('#############'),
            'in_stock' => $this->faker->numberBetween(1,10),
        ];
    }
}
