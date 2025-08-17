<?php

namespace App\Filament\Resources\ProgramResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use App\Actions\Curriculums\CreateNewSubjectAction;
use App\Actions\Curriculums\RegisterExistingSubjectAction;
use App\Data\Curriculums\CreateNewSubjectData;
use App\Data\Curriculums\RegisterExistingSubjectData;
use App\Enums\Semester;
use App\Enums\YearLevel;
use App\Filament\Resources\ProgramResource;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use App\Models\Subject;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class EditCurriculum extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ProgramResource::class;

    protected string $view = 'filament.resources.program-resource.pages.edit-curriculum';

    public Curriculum $curriculum;

    public function mount(Curriculum $curriculum): void
    {
        $this->curriculum = $curriculum;
    }

    public function getHeading(): string|Htmlable
    {
        return 'Edit Curriculum: ' . $this->curriculum->name;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->curriculum->program->name;
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn() => $this->curriculum->curriculumSubjects())
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('subject.name'),
                TextColumn::make('code'),
                TextColumn::make('subject.units'),
                TextColumn::make('semester')
                    ->sortable(),
            ])
            ->defaultGroup('year_level')
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->paginated(false)
            ->headerActions([
                Action::make('createNewSubject')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('code')
                            ->required(),
                        TextInput::make('units')
                            ->integer()
                            ->required(),
                        Textarea::make('description'),
                        Select::make('semester')
                            ->options(Semester::class)
                            ->required(),
                        Select::make('year_level')
                            ->options(YearLevel::class)
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        CreateNewSubjectAction::execute(new CreateNewSubjectData(
                            name: data_get($data, 'name'),
                            code: data_get($data, 'code'),
                            units: data_get($data, 'units'),
                            description: data_get($data, 'description'),
                            semester: data_get($data, 'semester'),
                            yearLevel: data_get($data, 'year_level'),
                            curriculumId: $this->curriculum->id,
                        ));
                    }),
                Action::make('addExistingSubject')
                    ->schema([
                        Select::make('subject')
                            ->searchable()
                            ->preload()
                            ->relationship('subject', 'name')
                            ->live(onBlur: true)
                            ->required(),
                        TextInput::make('code')
                            ->required(),
                        Select::make('semester')
                            ->options(Semester::class)
                            ->required(),
                        Select::make('year_level')
                            ->options(YearLevel::class)
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        RegisterExistingSubjectAction::execute(new RegisterExistingSubjectData(
                            subjectId: data_get($data, 'subject'),
                            subjectCode: data_get($data, 'code'),
                            curriculumId: $this->curriculum->id,
                            yearLevel: data_get($data, 'year_level'),
                            semester: data_get($data, 'semester'),
                        ));
                    }),
            ])
            ->recordActions([
                Action::make('remove')
                    ->color('danger')
                    ->icon('heroicon-s-trash')
                    ->requiresConfirmation()
                    ->modalDescription('This won\'t delete the subject, it will be just removed from curriculum.')
                    ->action(function (CurriculumSubject $record) {
                        $record->delete();
                    })
            ]);
    }
}
