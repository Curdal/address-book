<?php

namespace Curdal\AddressBook\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'default' => $this->is_default,
        ];
    }
}
