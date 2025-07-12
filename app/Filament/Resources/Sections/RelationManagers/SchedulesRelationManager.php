<?php

namespace App\Filament\Resources\Sections\RelationManagers;

use App\Filament\Resources\ScheduleResource;
use App\Models\Schedule;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    protected static ?string $relatedResource = ScheduleResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->filters([])
            ->headerActions([
                AssociateAction::make()
                    ->label('Link Existing Schedule')
                    ->recordSelectSearchColumns(['subject.name', 'teacher.name', 'room.name'])
                    ->recordSelectOptionsQuery(function (Builder $query) {
                        return $query
                            ->where('school_year_id', $this->getOwnerRecord()->getAttribute('school_year_id'))
                            ->whereNotIn('id', $this->getOwnerRecord()->schedules()->pluck('id'));
                    })
                    ->recordTitle(function (Schedule $record) {
                        return ($record->subject->name) .
                            ($record->teacher ? ' | ' . $record->teacher->name : '') .
                            ($record->room ? ' | ' . $record->room->name : '') .
                            ($record->day_of_week ? ' | ' . $record->day_of_week->name : '') .
                            ($record->start_time ? ' | ' . $record->start_time : '') .
                            ($record->end_time ? ' - ' . $record->end_time : '');
                    })
                    ->preloadRecordSelect(),
                CreateAction::make(),
            ]);
    }
}
