<?php

namespace Curdal\AddressBook\Models\Support;

use Curdal\AddressBook\Database\Factories\PhoneNumberFactory;
use Curdal\AddressBook\Enums\ContactInformationType;
use Curdal\AddressBook\Models\ContactInformation;
use Illuminate\Database\Eloquent\Builder;

class PhoneNumber extends ContactInformation
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('ofType', function (Builder $builder) {
            $builder->where('type', ContactInformationType::PhoneNumber);
        });

        static::creating(function ($information) {
            $information->type = ContactInformationType::PhoneNumber;
        });
    }

    protected static function newFactory()
    {
        return PhoneNumberFactory::new();
    }
}
