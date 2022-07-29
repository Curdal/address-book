<?php

namespace Curdal\AddressBook\Database\Factories;

// use Faker\Factory as FakerFactory;
use Curdal\AddressBook\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $faker = FakerFactory::create('en_US');

        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        // $emails    = [];

        // for ($i = random_int(1, 4); $i > count($emails); $i--) {
        //     $emailPrefix = $faker->randomElement([
        //         "{$lastName}.{$firstName}",
        //         "{$firstName}.{$lastName}",
        //         $firstName . random_int(10, 100),
        //         "{$lastName}.{$firstName}" . random_int(10, 100),
        //     ]);
        //     $emailSuffix = $faker->randomElement(['.com', '.org', '.net', '.co.za']);

        //     $emails[] = [
        //         'type'  => $faker->randomElement(['Home', 'Work', 'Mobile', 'Other']),
        //         'value' => "{$emailPrefix}@example{$emailSuffix}",
        //     ];
        // }

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            // 'emails' => $emails,
        ];
    }
}
