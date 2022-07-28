<?php

namespace Curdal\AddressBook\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInformation extends Model
{
    use HasFactory;

    protected $table = 'address_book_contact_information';

    public $fillable = ['value'];

    public $timestamps = false;

    public function scopeDefault(Builder $builder): Builder
    {
        return $builder->where('is_default', true);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
