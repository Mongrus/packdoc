<?php

namespace App\Enums;

enum SubscriptionStatus: string
{
    case Free = 'free';
    case Paid = 'paid';
    case Trial = 'trial';
}
