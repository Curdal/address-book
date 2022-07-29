<?php

namespace Curdal\AddressBook;

use Illuminate\Support\ServiceProvider;

class AddressBookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'address-book-migrations');
    }
}
