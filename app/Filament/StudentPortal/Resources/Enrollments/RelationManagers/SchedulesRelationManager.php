<?php

namespace App\Filament\StudentPortal\Resources\Enrollments\RelationManagers;

use Carbon\Carbon;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollmentSchedules';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('schedule.subject.name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('subject.name'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('schedule.subject.name')
            ->columns([
                Stack::make([
                    TextColumn::make('schedule.subject.name')
                        ->weight(FontWeight::Bold)
                        ->icon(Heroicon::BookOpen)
                        ->searchable()
                        ->sortable(),
                    Stack::make([
                        TextColumn::make('schedule.teacher.name')
                            ->limit(30)
                            ->icon(Heroicon::User)
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->schedule->teacher_id)),
                    Stack::make([
                        TextColumn::make('schedule.section.name')
                            ->limit(30)
                            ->icon(Heroicon::Users)
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->schedule->section_id)),
                    Stack::make([
                        TextColumn::make('schedule.room.name')
                            ->limit(30)
                            ->icon(Heroicon::BuildingLibrary)
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->schedule->room_id)),
                    Stack::make([
                        TextColumn::make('schedule.day_of_week')
                            ->icon(Heroicon::CalendarDays)
                            ->formatStateUsing(fn($record): string =>$record->schedule->day_of_week->name)
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->schedule->day_of_week)),
                    Stack::make([
                        TextColumn::make('schedule.start_time')
                            ->icon(Heroicon::Clock)
                            ->formatStateUsing(fn($record): string => Carbon::parse($record->schedule->start_time)->format('h:i A') ."-". Carbon::parse($record->schedule->end_time)->format('h:i A'))
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->schedule->start_time)),
                ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('schedule.subject.name')
                                    ->label('Subject'),
                                TextEntry::make('schedule.section.name')
                                    ->label('Section'),
                                TextEntry::make('schedule.teacher.name')
                                    ->label('Teacher'),
                                TextEntry::make('schedule.room.name')
                                    ->label('Room'),
                                TextEntry::make('schedule.day_of_week')
                                    ->formatStateUsing(fn($state) => $state?->name)
                                    ->label('Day of Week'),
                                TextEntry::make('schedule.start_time')
                                    ->formatStateUsing(fn($state) => Carbon::parse($state)->format('h:i A'))
                                    ->label('Start Time'),
                                TextEntry::make('schedule.end_time')
                                    ->formatStateUsing(fn($state) => Carbon::parse($state)->format('h:i A'))
                                    ->label('End Time'),
                                Fieldset::make('Grades')
                                    ->schema([
                                        TextEntry::make('prelims_grade')
                                            ->label('Prelims'),
                                        TextEntry::make('midterms_grade')
                                            ->label('Midterms'),
                                        TextEntry::make('pre_finals_grade')
                                            ->label('Pre-Finals'),
                                        TextEntry::make('finals_grade')
                                            ->label('Finals'),
                                    ])->columnSpan(2),
                            ]),
                    ]),
            ])
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('schedule'))
            ->contentGrid([
                'sm'  => 1,
                'md'  => 2,
                'xl'  => 3,
                '2xl' => 4,
            ])
            ->paginated(false);
    }
}
