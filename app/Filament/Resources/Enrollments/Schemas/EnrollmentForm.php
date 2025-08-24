<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use App\Enums\YearLevel;
use App\Filament\Tables\ScheduleTable;
use App\Models\SchoolYear;
use App\Models\Student;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
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
                Tabs::make('')
                    ->tabs([
                        Tab::make('Enrollment Information')
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
                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name . ' - ' . $record->major)
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
                            ->columns(),
                        Tab::make('Fees')
                            ->schema([
                                TextInput::make('fees.library_fees')
                                    ->numeric(),
                                TextInput::make('fees.computer_fees')
                                    ->numeric(),
                                TextInput::make('fees.lab_fees')
                                    ->numeric(),
                                TextInput::make('fees.athletic_fees')
                                    ->numeric(),
                                TextInput::make('fees.cultural_fees')
                                    ->numeric(),
                                TextInput::make('fees.guidance_fees')
                                    ->numeric(),
                                TextInput::make('fees.handbook_fees')
                                    ->numeric(),
                                TextInput::make('fees.registration_fees')
                                    ->numeric(),
                                TextInput::make('fees.medical_and_dental_fees')
                                    ->numeric(),
                                TextInput::make('fees.school_id_fees')
                                    ->numeric(),
                                TextInput::make('fees.admission_fees')
                                    ->numeric(),
                                TextInput::make('fees.entrance_fees')
                                    ->numeric(),
                                TextInput::make('fees.development_fees')
                                    ->numeric(),
                                TextInput::make('fees.tuition_fee_per_unit')
                                    ->numeric(),
                                TextInput::make('fees.nstp_fee_per_unit')
                                    ->label('NSTP Fee per Unit')
                                    ->numeric(),
                                TextInput::make('fees.alco_mem_fees')
                                    ->label('ALCO Membership Fees')
                                    ->numeric(),
                                TextInput::make('fees.pta_fees')
                                    ->label('PTA')
                                    ->numeric(),
                                TextInput::make('fees.other_fees')
                                    ->numeric(),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
