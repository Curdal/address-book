<?php

namespace Curdal\AddressBook\Traits;

use Curdal\AddressBook\Models\ContactInformation;
use Curdal\AddressBook\Models\Support\Address;
use Curdal\AddressBook\Models\Support\Email;
use Curdal\AddressBook\Models\Support\PhoneNumber;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasContactInformation
{
    public function contactInformation(): HasMany
    {
        return $this->hasMany(ContactInformation::class);
    }

    public function defaultAddress(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->addresses->default(),
        );
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function defaultEmail(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->emails->default(),
        );
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    public function defaultPhoneNumber(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $this->phoneNumbers->default(),
        );
    }

    public function phoneNumbers(): HasMany
    {
        return $this->hasMany(PhoneNumber::class);
    }
}
