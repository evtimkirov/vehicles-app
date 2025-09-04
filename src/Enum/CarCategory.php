<?php

namespace App\Enum;

enum CarCategory: string
{
    case SEDAN = 'sedan';
    case HATCHBACK = 'hatchback';
    case SUV = 'suv';
    case TOURER = 'tourer';
}
