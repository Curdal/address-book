<?php

namespace Curdal\AddressBook\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'required|string|min:2|max:50',
            'emails' => 'array',
            'emails.*' => 'email',
            'phone_numbers' => 'array',
            'phone_numbers.*' => 'numeric|digits_between:10,15',
            'addresses' => 'array',
            'addresses.*' => 'string',
        ];
    }
}
