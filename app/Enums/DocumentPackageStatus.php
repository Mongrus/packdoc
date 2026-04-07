<?php

namespace App\Enums;

enum DocumentPackageStatus: string
{
    case Draft = 'draft';
    case Completed = 'completed';
}
