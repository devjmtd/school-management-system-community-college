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
                            ->placeholder('Prelims'),
                        TextInputColumn::make('midterms')
                            ->type('number')
                            ->placeholder('Midterms'),
                        TextInputColumn::make('pre_finals')
                            ->type('number')
                            ->placeholder('Pre-Finals'),
                        TextInputColumn::make('finals')
                            ->type('number')
                            ->placeholder('Finals'),
                    ])
                ])->collapsible(true)
            ])
            ->defaultGroup('year_level')
            ->paginated(false);
    }
}
