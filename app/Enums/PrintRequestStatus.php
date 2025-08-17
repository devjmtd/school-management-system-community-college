<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PrintRequestStatus: string implements HasLabel, HasColor
{
    case Requested = 'requested';
    case Cancelled = 'cancelled';
    case Rejected = 'rejected';
    case Processing = 'processing';
    case Ready = 'ready';
    case Completed = 'completed';
    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Requested => 'Requested',
            self::Cancelled => 'Cancelled',
            self::Rejected => 'Rejected',
            self::Processing => 'Processing',
            self::Ready => 'Ready',
            self::Completed => 'Completed',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Requested => 'warning',
            self::Cancelled => 'danger',
            self::Rejected => 'danger',
            self::Processing => 'warning',
            self::Ready => 'success',
            self::Completed => 'success',
        };
    }
}