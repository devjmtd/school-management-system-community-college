<?php

declare(strict_types=1);


namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasLabel
{
    case Admin = 'admin';
    case ProgramHead = 'program_head';
    case Teacher = 'teacher';
    case Registrar = 'registrar';
    case Student = 'student';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::ProgramHead => 'Program Head',
            self::Teacher => 'Teacher',
            self::Registrar => 'Registrar',
            self::Student => 'Student',
        };
    }
}
