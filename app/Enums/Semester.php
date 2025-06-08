<?php

declare(strict_types=1);


namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Semester: int implements HasLabel
{
    case First = 1;
    case Second = 2;
    case Third = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::First => 'First Semester',
            self::Second => 'Second Semester',
            self::Third => 'Third Semester',
        };
    }
}
