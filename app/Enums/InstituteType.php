<?php

namespace App\Enums;

enum InstituteType : string
{
    case Direct = 'direct';
    case Indirect = 'indirect';

    public function getLabel(): string
    {
        return match ($this) {
            self::Direct => __('Direct'),
            self::Indirect => __('Indirect'),
        };
    }

}
