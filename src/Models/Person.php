<?php

namespace Curdal\AddressBook\Models;

use Curdal\AddressBook\Models\Relations\GroupPerson;
use Curdal\AddressBook\Traits\HasContactInformation;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
                    trim($person->last_name)
                ]
            );
        });
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class)
            ->using(GroupPerson::class);
    }
}
