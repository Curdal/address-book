<?php

use Curdal\AddressBook\Models\Group;
use Curdal\AddressBook\Models\Person;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('can retrieve a list of groups', function () {
    $number = fake()->randomDigitNotZero();
    Group::factory()->count($number)->create();

    $this->assertDatabaseCount('address_book_groups', $number);

    getJson(route('address-book.groups.list'))
        ->assertSuccessful()
        ->assertJsonCount($number, 'data');
});

it('can create a group', function () {
    $dataSet = [
        'name' => 'Friends',
        'description' => 'My dearest friends'
    ];

    postJson(route('address-book.groups.create'), $dataSet)
        ->assertSuccessful()
        ->assertSee($dataSet);

    $this->assertDatabaseHas('address_book_groups', $dataSet);
});

it('can find a group by ID', function () {
    $group = Group::factory()->create();

    getJson(route('address-book.groups.show', ['group' => $group->id]))
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
            ],
        ])
        ->assertJsonCount(0, 'data.people');
});

it('can find a group by ID with all people', function () {
    $group = Group::factory()
        ->has(Person::factory()->count(15))
        ->create();

    getJson(route('address-book.groups.show', ['group' => $group->id]))
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'people'
            ],
        ])
        ->assertJsonCount(15, 'data.people');
});

it('can update a group', function () {
    $group = Group::factory()->create();

    $dataSet = [
        'name' => 'The Musketeers',
        'description' => 'Gang Gang'
    ];

    putJson(route('address-book.groups.update', ['group' => $group->id]), $dataSet)
        ->assertSuccessful()
        ->assertSee($dataSet);

    $this->assertDatabaseHas('address_book_groups', $dataSet);
});

it('can remove a group', function () {
    $group = Group::factory()->create();

    $this->assertDatabaseHas('address_book_groups', ['id' => $group->id]);

    deleteJson(route('address-book.groups.delete', ['group' => $group->id]))
        ->assertSuccessful()
        ->assertStatus(204);
});

it('can remove a group and unlink people from the it', function () {
    $group = Group::factory()
        ->has(Person::factory()->count(5))
        ->create();

    $this->assertDatabaseHas('address_book_groups', ['id' => $group->id]);
    $this->assertDatabaseCount('address_book_group_person', 50);
    $this->assertDatabaseCount('address_book_people', 50);

    deleteJson(route('address-book.groups.delete', ['group' => $group->id]))
        ->assertSuccessful()
        ->assertStatus(204);

    // $this->assertDatabaseCount('address_book_group_person', 0); // In-memory database does not inforce relations
    $this->assertDatabaseCount('address_book_people', 50);
})->skip(message: "In-memory databases does not inforce relations");
