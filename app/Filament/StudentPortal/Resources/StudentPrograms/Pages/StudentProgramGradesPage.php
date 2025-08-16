<?php

namespace App\Filament\StudentPortal\Resources\StudentPrograms\Pages;

use App\Filament\StudentPortal\Resources\StudentPrograms\StudentProgramResource;
use App\Models\Grade;
use App\Models\StudentProgram;
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

class StudentProgramGradesPage extends Page  implements  HasTable, HasSchemas
{
    use InteractsWithRecord;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = StudentProgramResource::class;

    protected string $view = 'filament.student-portal.resources.student-programs.pages.student-program-grades-page';

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
        return $this->record->curriculum->name;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Grade::query())
            ->modifyQueryUsing(fn(Builder $query): Builder => $query
                ->where('program_id', $this->record->program_id)
                ->where('student_id', $this->record->student_id)
            )
            ->paginated(false)
            ->columns([
                    TextColumn::make('subject.name')
                        ->limit(35)
                        ->label('Subject'),
                    TextColumn::make('subject.code')
                        ->label('Code'),
                    TextColumn::make('prelims')
                        ->placeholder('-'),
                    TextColumn::make('midterm')
                        ->placeholder('-'),
                    TextColumn::make('pre_finals')
                        ->placeholder('-'),
                    TextColumn::make('finals')
                        ->placeholder('-'),
                    TextColumn::make('average')
                        ->placeholder('-'),
            ])
            ->defaultGroup('year_level')
            ->paginated(false);
    }
}
