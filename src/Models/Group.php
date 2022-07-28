<?php

namespace Curdal\AddressBook\Models;

use Curdal\AddressBook\Models\Relations\GroupPerson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $table = 'address_book_groups';

    public $fillable = ['name', 'description'];

    public function person(): HasMany
    {
        return $this->hasMany(Person::class)
            ->using(GroupPerson::class);
    }
}
