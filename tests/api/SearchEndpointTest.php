<?php

use Curdal\AddressBook\Models\Support\Email;
use Curdal\AddressBook\Models\Group;
use Curdal\AddressBook\Models\Person;

use function Pest\Laravel\getJson;

it('lists groups and people from the search route', function () {
    Group::factory()->count(5)->create();
    Person::factory()->count(150)->create();

    getJson(route('address-book.list'))
        ->assertSuccessful();
});

it('can search for a person by their full name', function () {
    Group::factory()->count(50)->create();
    Person::factory()->count(1500)->create();

    Person::factory()->has(Email::factory())->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);

    getJson('/api/address-book?search=John Doe')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data');
});

it('can search for a person by one of their email addresses', function () {
    Group::factory()->count(50)->create();
    Person::factory()->count(1500)->create();

    Person::factory()
        ->has(Email::factory()->state(fn () => ['value' => 'random@example.com']))
        ->create();

    getJson('/api/address-book?search=random@example.com')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data');
});

it('can search for a person by a partial match of their name', function () {
    Group::factory()->count(5)->create();
    Person::factory()->count(150)->create();

    Person::factory()->has(Email::factory())->create([
        'first_name' => 'Cadbury',
        'last_name' => 'Gingersnap',
    ]);

    getJson('/api/address-book?search=dbur')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data');

    getJson('/api/address-book?search=gersnap')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data');
});
