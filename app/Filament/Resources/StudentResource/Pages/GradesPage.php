<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Grade;
use App\Models\StudentProgram;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class GradesPage extends Page implements  HasTable, HasSchemas
{
    use InteractsWithRecord;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = StudentResource::class;

    protected string $view = 'filament.resources.student-resource.pages.grades-page';

    public function mount(int|string $record): void
    {
        $this->record = StudentProgram::findOrFail($record);
    }

    public function getHeading(): string|Htmlable
    {
        if ($this->record->program->major) {
            return $this->record->program->name . ' - ' . $this->record->program->major;
        }

        return $this->record->program->name;
    }

    public function getSubheading(): string|Htmlable
    {
        return $this->record->student->first_name . ' ' . $this->record->student->last_name;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Grade::query())
            ->modifyQueryUsing(fn(Builder $query): Builder => $query->where('program_id', $this->record->program_id))
            ->paginated(false)
            ->columns([
                Split::make([
                    TextColumn::make('subject.name')
                        ->limit(35)
                        ->label('Subject'),
                    TextColumn::make('subject.code')
                        ->label('Code'),
                ]),
                Panel::make([
                    Split::make([
                        TextInputColumn::make('prelims')
                            ->type('number')
                            ->step(0.25)
                            ->placeholder('Prelims')
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Prelims'),
                        TextInputColumn::make('midterm')
                            ->type('number')
                            ->step(0.25)
                            ->placeholder('Midterms')
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Midterms'),
                        TextInputColumn::make('pre_finals')
                            ->type('number')
                            ->step(0.25)
                            ->placeholder('Pre-Finals')
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Pre-Finals'),
                        TextInputColumn::make('finals')
                            ->type('number')
                            ->step(0.25)
                            ->placeholder('Finals')
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Finals'),
                        TextInputColumn::make('average')
                            ->type('number')
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Average'),
                    ])
                ])->collapsible(true)
            ])
            ->defaultGroup('year_level')
            ->paginated(false);
    }
}
