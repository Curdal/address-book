<?php

use Curdal\AddressBook\Models\Person;
use Curdal\AddressBook\Models\Support\Address;
use Curdal\AddressBook\Models\Support\Email;
use Curdal\AddressBook\Models\Support\PhoneNumber;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('can retrieve a list of people', function () {
    $number = fake()->randomDigitNotZero();
    Person::factory()->count($number)->create();

    $this->assertDatabaseCount('address_book_people', $number);

    getJson(route('address-book.people.list'))
        ->assertSuccessful()
        ->assertJsonCount($number, 'data');
});

it('can create a person and their contact information in a single request', function () {
    postJson(route('address-book.people.create'), [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'emails' => [
            'john.doe@example.com',
            'jd101@example.net',
        ],
        'phone_numbers' => [
            '5551234567',
        ],
        'addresses' => [
            '123 Main Road, Suburb, City, 1234',
            '101 Find Me Lane, Suburb, City, 9876',
        ],
    ])->assertSuccessful()->assertSee([
        'first_name' => 'John',
        'last_name' => 'Doe'
    ]);

    $this->assertDatabaseHas('address_book_people', ['first_name' => 'John', 'last_name' => 'Doe']);
    $this->assertDatabaseHas('address_book_contact_information', ['type' => 'email', 'value' => 'john.doe@example.com']);
    $this->assertDatabaseHas('address_book_contact_information', ['type' => 'email', 'value' => 'jd101@example.net']);
    $this->assertDatabaseHas('address_book_contact_information', ['type' => 'phone_number', 'value' => '5551234567']);
    $this->assertDatabaseHas('address_book_contact_information', ['type' => 'address', 'value' => '123 Main Road, Suburb, City, 1234']);
    $this->assertDatabaseHas('address_book_contact_information', ['type' => 'address', 'value' => '101 Find Me Lane, Suburb, City, 9876']);
});

it('can find a person by ID', function () {
    $person = Person::factory()->create();

    $this->assertDatabaseCount('address_book_people', 1);
    $this->assertDatabaseCount('address_book_contact_information', 0);

    getJson(route('address-book.people.show', ['person' => $person->id]))
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                'id',
                'first_name',
                'last_name',
            ],
        ])
        ->assertJsonCount(0, 'data.addresses')
        ->assertJsonCount(0, 'data.emails')
        ->assertJsonCount(0, 'data.phone_numbers');
});

it('can find a person by ID with contact information', function () {
    $person = Person::factory()
        ->has(Address::factory())
        ->has(Email::factory()->count(2))
        ->has(PhoneNumber::factory()->count(3))
        ->create();

    $this->assertDatabaseCount('address_book_people', 1);
    $this->assertDatabaseCount('address_book_contact_information', 6);

    getJson(route('address-book.people.show', ['person' => $person->id]))
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                'id',
                'first_name',
                'last_name',
                'addresses',
                'emails',
                'phone_numbers',
            ],
        ]);
});

it('can update a person', function () {
    //
})->skip();

it('can remove a person', function () {
    $person = Person::factory()->create();

    deleteJson(route('address-book.people.delete', ['person' => $person->id]))
        ->assertSuccessful()
        ->assertStatus(204);

    $this->assertDatabaseCount('address_book_people', 0);
});

it('can remove a person and their contact information', function () {
    $person = Person::factory()
        ->has(Address::factory())
        ->has(Email::factory())
        ->has(PhoneNumber::factory())
        ->create();

    deleteJson(route('address-book.people.delete', ['person' => $person->id]))
        ->assertSuccessful()
        ->assertStatus(204);

    $this->assertDatabaseCount('address_book_contact_information', 0);
    $this->assertDatabaseCount('address_book_people', 0);
});
