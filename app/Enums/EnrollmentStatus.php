<?php

declare(strict_types=1);


namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum EnrollmentStatus: string implements HasLabel
{
    case Pending = 'pending';
    case Enrolled = 'enrolled';
    case Withdrawn = 'withdrawn';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Enrolled => 'Enrolled',
            self::Withdrawn => 'Withdrawn',
        };
    }
}
