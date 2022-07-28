<?php

namespace Curdal\AddressBook\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'addresses' => ContactInformationResource::collection(
                $this->whenLoaded('addresses', $this->addresses)
            ),
            'emails' => ContactInformationResource::collection(
                $this->whenLoaded('emails', $this->emails)
            ),
            'phone_numbers' => ContactInformationResource::collection(
                $this->whenLoaded('phoneNumbers', $this->phoneNumbers)
            ),
        ];
    }
}
