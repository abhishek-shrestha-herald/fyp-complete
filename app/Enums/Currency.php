<?php

namespace App\Enums;

use App\Contracts\HasDefault;
use Filament\Support\Contracts\HasLabel;

enum Currency: string implements HasLabel, HasDefault
{
    case NPR = 'NPR';
    case USD = 'USD';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NPR => 'NRs',
            self::USD => 'USD',
        };
    }

    public static function getDefault(): Currency
    {
        return self::NPR;
    }
}
