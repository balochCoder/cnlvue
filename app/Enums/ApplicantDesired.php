<?php

namespace App\Enums;

enum ApplicantDesired: string
{
    case Excellent = 'excellent';
    case Good = 'good';
    case Average = 'average';
    case Below_Average = 'below average';

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
