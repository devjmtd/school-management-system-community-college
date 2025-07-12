<?php

namespace App\Filament\Resources\Sections\Tables;

use App\Enums\YearLevel;
use App\Models\CurriculumSubject;
use App\Models\Program;
use App\Models\SchoolYear;
use App\QueryBuilders\ScheduleQuery;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('program.name')
                    ->searchable(),
                TextColumn::make('year_level'),
                TextColumn::make('schoolYear.name'),
            ])
            ->filters([
                Filter::make('program')
                    ->schema([
                        Select::make('school_year_id')
                            ->label('School Year')
                            ->default(SchoolYear::current()->first()->id)
                            ->searchable()
                            ->options(SchoolYear::all()->pluck('name', 'id')),
                        Select::make('program_id')
                            ->label('Program')
                            ->searchable()
                            ->options(function () {
                                return Program::all()->mapWithKeys(function ($program) {
                                    $value = $program->name;
                                    if ($program->major) {
                                        $value .= ' - ' . $program->major;
                                    }
                                    return [$program->id => $value];
                                })->toArray();
                            })
                            ->getOptionLabelFromRecordUsing(fn (Program $record) => "{$record->code} - {$record->name}".(isset($record->major) ? ' major in '.$record->major->name : ''))
                        ,
                        Select::make('year_level')
                            ->label('Year Level')
                            ->options(YearLevel::class)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['program_id'],
                                function (Builder $query) use ($data) {
                                    return $query->where('program_id', $data['program_id']);
                                }
                            )
                            ->when(
                                $data['year_level'],
                                function (Builder $query) use ($data) {
                                    $query->where('year_level', $data['year_level']);
                                }
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if (data_get($data, 'school_year_id')) {
                            $indicators[] = "School Year: ".SchoolYear::findOrFail($data['school_year_id'])->name;
                        }

                        if (data_get($data, 'program_id')) {
                            $program = Program::findOrFail($data['program_id']);
                            $indicators[] = "Program: ".$program->code.(isset($program->major) ? ' - '.$program->major : '');
                        }

                        if (data_get($data, 'year_level')) {
                            $indicators[] = YearLevel::tryFrom(data_get($data, 'year_level'))->getLabel();
                        }

                        return $indicators;
                    })
            ])
            ->deferFilters(false)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
