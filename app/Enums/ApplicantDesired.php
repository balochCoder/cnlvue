<?php

namespace App\Enums;

enum ApplicantDesired: string
{
    case Excellent = '4';
    case Good = '3';
    case Average = '2';
    case Below_Average = '1';

    public function getLabel(): string
    {
        return match ($this) {
            self::Excellent => __('Excellent (****)'),
            self::Good => __('Good (***)'),
            self::Average => __('Average (**)'),
            self::Below_Average => __('Below Average (*)'),
        };
    }
}
