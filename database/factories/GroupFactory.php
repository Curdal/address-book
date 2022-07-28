<?php

namespace Curdal\AddressBook\Database\Factories;

use Curdal\AddressBook\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->catchPhrase(),
            'description' => fake()->text(200),
        ];
    }
}
