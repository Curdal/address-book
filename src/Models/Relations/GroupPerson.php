<?php

namespace Curdal\AddressBook\Models\Relations;

use Curdal\AddressBook\Models\Person;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupPerson extends Pivot
{
    protected $table = 'address_book_group_person';

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
