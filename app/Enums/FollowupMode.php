<?php

namespace App\Enums;

enum FollowupMode : string
{
    case BBM = 'bbm';
    case Zoom = 'zoom';
    case Email = 'email';
    case Google_Meet = 'google_meet';
    case Meeting = 'meeting';
    case Phone = 'phone';
    case Skype = 'skype';
    case WhatsApp = 'whatsapp';

    public function getLabel(): string
    {
        return match ($this) {
            self::BBM => __('BBM'),
            self::Zoom => __('Zoom'),
            self::Email => __('Email'),
            self::Google_Meet => __('Google Meet'),
            self::Meeting => __('Meeting'),
            self::Phone => __('Phone'),
            self::Skype => __('Skype'),
            self::WhatsApp => __('WhatsApp'),
        };
    }

}
