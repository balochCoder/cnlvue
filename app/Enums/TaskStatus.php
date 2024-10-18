<?php

namespace App\Enums;

enum TaskStatus : string
{
    case New = 'new';
    case Completed = 'completed';
    case In_process = 'in_process';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => __('New'),
            self::Completed => __('Completed'),
            self::In_process => __('In Process'),

        };
    }

}
