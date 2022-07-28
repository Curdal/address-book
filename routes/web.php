<?php

use Curdal\AddressBook\Http\Controllers\{
    GroupsController,
    PeopleController,
    SearchController
};
use Illuminate\Support\Facades\Route;

Route::prefix('api/address-book')
->middleware(['web'])
->group(function () {
    Route::get('/', SearchController::class)->name('address-book.list');

    // People
    Route::get('/people', [PeopleController::class, 'index'])->name('address-book.people.list');
    Route::post('/people', [PeopleController::class, 'create'])->name('address-book.people.create');
    Route::get('/people/{person}', [PeopleController::class, 'show'])->name('address-book.people.show');
    Route::put('/people/{person}', [PeopleController::class, 'update'])->name('address-book.people.update');
    Route::delete('/people/{person}', [PeopleController::class, 'destroy'])->name('address-book.people.delete');

    // Groups
    Route::post('/groups', [GroupsController::class, 'create'])->name('address-book.groups.create');
    Route::put('/groups/{group}', [GroupsController::class, 'update'])->name('address-book.groups.update');
    Route::delete('/groups/{group}', [GroupsController::class, 'destroy'])->name('address-book.groups.delete');
});
