<?php

namespace App\Enums\Enums;

enum AddressTypeEnums: string
{
    case BILLING = 'billing';
    case SHIPPING = 'shipping';
}
