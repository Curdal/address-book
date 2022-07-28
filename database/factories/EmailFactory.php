<?php

namespace Curdal\AddressBook\Database\Factories;

use Curdal\AddressBook\Models\Support\Email;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Email::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'value' => fake()->safeEmail(),
        ];
    }
}
