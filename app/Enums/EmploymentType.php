<?php

namespace App\Enums;

enum EmploymentType: string
{
    case Freelancer = 'freelancer';
    case Employee = 'employee';
    case SelfEmployed = 'self-employed';
    case Company = 'company';
}
