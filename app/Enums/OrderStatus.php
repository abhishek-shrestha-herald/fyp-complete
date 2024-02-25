<?php

namespace App\Enums;

use App\Contracts\HasDefault;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasLabel, HasDefault
{
    case INITIATED = 'initiated';
    case PROCESSING = 'processing';
    case PROCESSED = 'processed';
    case DELIVERING = 'delivering';
    case DELIVERED = 'delivered';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INITIATED => 'Initiated',
            self::PROCESSING => 'Processing',
            self::PROCESSED => 'Processed',
            self::DELIVERING => 'Delivering',
            self::DELIVERED => 'Delivered',
        };
    }

    public static function getDefault(): OrderStatus
    {
        return self::INITIATED;
    }
}
