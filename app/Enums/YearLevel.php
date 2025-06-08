<?php

declare(strict_types=1);


namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum YearLevel: int implements HasLabel
{
    case First = 1;
    case Second = 2;
    case Third = 3;
    case Fourth = 4;
    case Fifth = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::First => 'First Year',
            self::Second => 'Second Year',
            self::Third => 'Third Year',
            self::Fourth => 'Fourth Year',
            self::Fifth => 'Fifth Year',
        };
    }
}
