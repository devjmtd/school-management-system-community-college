<?php

declare(strict_types=1);


namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum RequestStatus: string implements HasLabel, HasColor
{
    case Pending = 'pending';

    case Approved = 'approved';

    case Rejected = 'rejected';

    case Cancelled = 'cancelled';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Cancelled => 'Cancelled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Approved => 'success',
            self::Rejected => 'danger',
            self::Cancelled => 'danger',
        };
    }
}
