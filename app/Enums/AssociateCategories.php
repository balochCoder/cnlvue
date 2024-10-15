<?php

namespace App\Enums;

enum AssociateCategories : string
{
    case Silver = 'silver';
    case Gold = 'gold';
    case Platnium = 'platnium';




    public function getLabel(): string
    {
        return match ($this) {
            self::Silver => 'Silver',
            self::Gold => 'Gold',
            self::Platnium => 'Platnium',
        };
    }

}
