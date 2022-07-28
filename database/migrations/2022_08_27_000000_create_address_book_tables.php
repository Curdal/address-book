<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressBookTables extends Migration
{
    public function up(): void
    {
        Schema::create('address_book_people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('full_name', 255);
            $table->timestamps();
        });

        Schema::create('address_book_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('address_book_group_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('address_book_groups')->onDelete('cascade');
            $table->foreignId('person_id')->constrained('address_book_people')->onDelete('cascade');
        });

        Schema::create('address_book_contact_information', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100); // ['address', 'email', 'phone_number']
            $table->string('value', 255);
            $table->boolean('is_default')->default(false);
            $table->foreignId('person_id')->constrained('address_book_people')->onDelete('cascade');
            $table->index(['type', 'person_id'], 'pi_idx');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('address_book_people');
        Schema::dropIfExists('address_book_groups');
        Schema::dropIfExists('address_book_group_person');
        Schema::dropIfExists('address_book_contact_information');

        Schema::enableForeignKeyConstraints();
    }
}
