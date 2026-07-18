<?php

namespace App\Enums;

enum AddressTypeEnums: string
{
    case BILLING = 'billing';
    case SHIPPING = 'shipping';
}
