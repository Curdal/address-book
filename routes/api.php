<?php

use Curdal\AddressBook\Http\Controllers\GroupsController;
use Curdal\AddressBook\Http\Controllers\ManagementController;
use Curdal\AddressBook\Http\Controllers\PeopleController;
use Curdal\AddressBook\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/address-book')
->middleware(['api'])
->group(function () {
    Route::get('/', SearchController::class)->name('address-book.list');

    // People
    Route::get('/people', [PeopleController::class, 'index'])
        ->name('address-book.people.list');
    Route::post('/people', [PeopleController::class, 'create'])
        ->name('address-book.people.create');
    Route::get('/people/{person}', [PeopleController::class, 'show'])
        ->name('address-book.people.show');
    Route::put('/people/{person}', [PeopleController::class, 'update'])
        ->name('address-book.people.update');
    Route::delete('/people/{person}', [PeopleController::class, 'destroy'])
        ->name('address-book.people.delete');

    // Groups
    Route::get('/groups', [GroupsController::class, 'index'])
        ->name('address-book.groups.list');
    Route::post('/groups', [GroupsController::class, 'create'])
        ->name('address-book.groups.create');
    Route::get('/groups/{group}', [GroupsController::class, 'show'])
        ->name('address-book.groups.show');
    Route::put('/groups/{group}', [GroupsController::class, 'update'])
        ->name('address-book.groups.update');
    Route::delete('/groups/{group}', [GroupsController::class, 'destroy'])
        ->name('address-book.groups.delete');

    // Management
    Route::post('/people/{person}/groups', [ManagementController::class, 'addGroups'])
        ->name('address-book.people.groups.add');
    Route::delete('/people/{person}/groups', [ManagementController::class, 'removeGroups'])
        ->name('address-book.people.groups.remove');

    Route::post('/groups/{group}/people', [ManagementController::class, 'addPeople'])
        ->name('address-book.groups.people.add');
    Route::delete('/groups/{group}/people', [ManagementController::class, 'removePeople'])
        ->name('address-book.groups.people.remove');
});
