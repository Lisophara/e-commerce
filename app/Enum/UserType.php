<?php

namespace App\Enum;

enum UserType : string
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case MERCHANT = 'merchant';
    case DELIVERY = 'delivery';
}
