<?php

namespace Curdal\AddressBook\Models\Support;

use Curdal\AddressBook\Enums\ContactInformationType;
use Curdal\AddressBook\Models\ContactInformation;
use Illuminate\Database\Eloquent\Builder;

class Address extends ContactInformation
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('ofType', function (Builder $builder) {
            $builder->where('type', ContactInformationType::Address);
        });

        static::creating(function ($information) {
            $information->type = ContactInformationType::Address;
        });
    }
}