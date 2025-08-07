<?php

namespace App\Filament\TeacherPortal\Resources\Schedules\Pages;

use App\Filament\TeacherPortal\Resources\Schedules\ScheduleResource;
use Carbon\WeekDay;
use Filament\Actions\CreateAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;

class ListSchedules extends ListRecords
{

    protected static string $resource = ScheduleResource::class;

}

