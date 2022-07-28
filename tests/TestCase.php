<?php

namespace Curdal\AddressBook\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;
use Curdal\AddressBook\AddressBookServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Curdal\\AddressBook\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            AddressBookServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('app.key', 'base64:0OHaeCKFtv/gEJklxsWTIayyjXBSv0WYwF8sT0APxjk=');
        config()->set('database.default', 'testing');

        // $migration = include __DIR__ . '/../database/migrations/create_address_book_tables.php';
        // $migration->up();
    }
}
