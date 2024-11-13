<?php

namespace App\Enums;

enum LeadStatus : string
{
    case New = 'new';
    case Cold = 'cold';
    case Completed = 'completed';
    case Failed = 'failed';
    case Future_Lead = 'future_lead';
    case Hot = 'hot';
    case Medium = 'medium';
    case Not_Responding = 'not_responding';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Cold => __('Cold'),
            self::Completed => __('Completed'),
            self::Failed => __('Failed'),
            self::Future_Lead => __('Future Lead'),
            self::Hot => __('Hot'),
            self::Medium => __('Medium'),
            self::Not_Responding => __('Not Responding'),
        };
    }

}
