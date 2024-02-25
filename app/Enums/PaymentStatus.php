<?php
namespace App\Enums;

use App\Contracts\HasDefault;
use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel, HasDefault
{
    case PENDING = 'pending';
    case VALIDATING = 'validating';

    case PARTIALLY_COMPLETED = 'partially-completed';
    case COMPLETED = 'completed';

    case FAILED = 'failed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::VALIDATING => 'Validating',
            self::PARTIALLY_COMPLETED => 'Partially Completed',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
        };
    }

    public static function getDefault(): PaymentStatus
    {
        return self::PENDING;
    }
}
