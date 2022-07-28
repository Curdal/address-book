<?php

use function Pest\Laravel\postJson;

it('can retrieve a list of groups via GET', function () {
    //
})->skip();

it('can create a group via POST', function () {
    $dataSet = [
        'name' => 'Friends',
        'description' => 'My dearest friends'
    ];

    postJson(route('address-book.groups.create'), $dataSet)
        ->assertSuccessful()
        ->assertSee($dataSet);

    $this->assertDatabaseHas('address_book_groups', $dataSet);
});

it('can update a group via PUT', function () {
    //
})->skip();

it('can remove a group via DELETE', function () {
    //
})->skip();
