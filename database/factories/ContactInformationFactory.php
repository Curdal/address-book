<?php

namespace Curdal\AddressBook\Database\Factories;

use Curdal\AddressBook\Models\ContactInformation;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactInformationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactInformation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = fake()->randomElement(['email', 'address', 'phone_number']);

        $method = match ($type) {
            'email' => 'safeEmail',
            'address' => 'address',
            'phone_number' => 'phoneNumber',
            default => throw new Exception('Undefined contact information type', 500)
        };

        return [
            'type' => $type,
            'value' => fake()->{$method}(),
            'is_default' => fake()->boolean(50)
        ];
    }
}
