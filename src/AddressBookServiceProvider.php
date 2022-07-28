<?php

namespace Curdal\AddressBook;

use Illuminate\Support\ServiceProvider;

class AddressBookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
