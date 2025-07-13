<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use App\Enums\YearLevel;
use App\Filament\Tables\ScheduleTable;
use App\Models\SchoolYear;
use App\Models\Student;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Enrollment Information')
                    ->schema([
                        Select::make('school_year_id')
                            ->default(fn() => SchoolYear::current()->first()->id)
                            ->relationship('schoolYear', 'name'),
                        Select::make('student_id')
                            ->relationship('student')
                            ->getOptionLabelFromRecordUsing(fn(Student $record) => ($record->student_id ? "({$record->student_id}) - " : ''). "{$record->first_name} {$record->last_name}")
                            ->searchable(['first_name', 'last_name', 'student_id'])
                            ->required()
                            ->preload(),
                        Select::make('year_level')
                            ->required()
                            ->options(YearLevel::class),
                        Select::make('program_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('program', 'name')
                            ->live(true)
                            ->afterStateUpdated(function (Set $set) {
                                $set('curriculum_id', null);
                            }),
                        Select::make('curriculum_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('curriculum', 'name', modifyQueryUsing: function (Builder $query, Get $get) {
                                return $query->where('program_id', $get('program_id'));
                            }),
                        Select::make('section_id')
                            ->searchable()
                            ->preload()
                            ->relationship('section', 'name', modifyQueryUsing: function (Builder $query, Get $get) {
                                return $query->where('program_id', $get('program_id'));
                            }),
                    ])
            ]);
    }
}
