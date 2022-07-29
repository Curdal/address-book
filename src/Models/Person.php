<?php

namespace Curdal\AddressBook\Models;

use Curdal\AddressBook\Database\Factories\PersonFactory;
use Curdal\AddressBook\Models\Relations\GroupPerson;
use Curdal\AddressBook\Traits\HasContactInformation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasContactInformation;
    use HasFactory;

    protected $table = 'address_book_people';

    public $fillable = ['first_name', 'last_name'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($person) {
            $person->full_name = implode(
                separator: ' ',
                array: [
                    trim($person->first_name),
                    trim($person->last_name),
                ]
            );
        });
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, (new GroupPerson)->getTable())
            ->using(GroupPerson::class);
    }

    protected static function newFactory()
    {
        return PersonFactory::new();
    }
}
