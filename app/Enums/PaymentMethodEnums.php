<?php

namespace App\Enums;

enum PaymentMethodEnums: string
{
    case COD = 'cod';
    case BKASH = 'bkash';
    case NAGAD = 'nagad';
    case SSLCOMMERZ = 'sslcommerz';
    case STRIPE = 'stripe';
}
