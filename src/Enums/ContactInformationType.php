<?php

namespace Curdal\AddressBook\Enums;

enum ContactInformationType: string
{
    case Address = 'address';
    case Email = 'email';
    case PhoneNumber = 'phone_number';
}
