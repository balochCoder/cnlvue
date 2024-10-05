<?php

namespace App\Enums;

enum DownloadCSV: string
{
    case Allowed = 'Y';
    case AllowedWithoutContact = 'W';
    case NotAllowed = 'N';

    public function getLabel(): string
    {
        return match ($this) {
            self::Allowed => __('Allowed'),
            self::AllowedWithoutContact => __('Allowed without Contact'),
            self::NotAllowed => __('Not Allowed'),
        };
    }
}
