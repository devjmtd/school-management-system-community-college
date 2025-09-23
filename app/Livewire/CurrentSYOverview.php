<?php

namespace App\Livewire;

use App\Models\SchoolYear;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CurrentSYOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $currentSchoolYear = SchoolYear::current()->first();

        if (!$currentSchoolYear) {
            return [];
        }

        return [
            Stat::make('Current School Year', $currentSchoolYear->name),
        ];
    }
}
