<?php

use Curdal\AddressBook\Models\{Group, Person};

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;

it('can add group(s) to a person', function () {
    $person = Person::factory()
        ->has(Group::factory()->count(10))
        ->create();

    $this->assertDatabaseCount('address_book_group_person', 10);

    $groups = Group::factory()->count(5)->create();

    postJson(route('address-book.people.groups.add', ['person' => $person->id]), [
        'groups' => $groups->pluck('id'),
    ])->assertSuccessful();

    $this->assertDatabaseCount('address_book_group_person', 15);
});

it('can remove group(s) from a person', function () {
    $person = Person::factory()
        ->has(Group::factory()->count(10))
        ->create();

    $this->assertDatabaseCount('address_book_group_person', 10);

    deleteJson(route('address-book.people.groups.remove', ['person' => $person->id]), [
        'groups' => [1, 3, 5, 7, 9],
    ])->assertSuccessful();

    $this->assertDatabaseCount('address_book_group_person', 5);
});

it('can add people to a group', function () {
    $group = Group::factory()
        ->has(Person::factory()->count(10))
        ->create();

    $this->assertDatabaseCount('address_book_group_person', 10);

    $people = Person::factory()->count(5)->create();

    postJson(route('address-book.groups.people.add', ['group' => $group->id]), [
        'people' => $people->pluck('id'),
    ])->assertSuccessful();

    $this->assertDatabaseCount('address_book_group_person', 15);
});

it('can remove people from a group', function () {
    $group = Group::factory()
        ->has(Person::factory()->count(10))
        ->create();

    $this->assertDatabaseCount('address_book_group_person', 10);

    deleteJson(route('address-book.groups.people.remove', ['group' => $group->id]), [
        'people' => [1, 3, 5, 7, 9],
    ])->assertSuccessful();

    $this->assertDatabaseCount('address_book_group_person', 5);
});
