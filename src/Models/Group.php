<?php

namespace Curdal\AddressBook\Models;

use Curdal\AddressBook\Database\Factories\GroupFactory;
use Curdal\AddressBook\Models\Relations\GroupPerson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;

    protected $table = 'address_book_groups';

    public $fillable = ['name', 'description'];

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, (new GroupPerson)->getTable())
            ->using(GroupPerson::class);
    }

    protected static function newFactory()
    {
        return GroupFactory::new();
    }
}
