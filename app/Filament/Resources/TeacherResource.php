<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use App\Filament\Resources\TeacherResource\Pages\ListTeachers;
use App\Filament\Resources\TeacherResource\Pages\CreateTeacher;
use App\Filament\Resources\TeacherResource\Pages\EditTeacher;
use App\Enums\Role;
use App\Filament\Resources\TeacherResource\Pages;
use App\Models\Department;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TeacherResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'teachers';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $label = 'Teacher';

    protected static string | \UnitEnum | null $navigationGroup = 'Department Management';

    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin || auth()->user()->role === Role::ProgramHead;
    }

    public static function getDepartmentIds(): array
    {
        if (auth()->user()->role == Role::Admin) {
            return Department::get()->pluck('id')->toArray();
        } elseif (auth()->user()->role == Role::ProgramHead) {
            return [auth()->user()->department_id];
        } else {
            return [];
        }
    }

    public static function form(Schema $schema): Schema
    {
        $departmentIds = self::getDepartmentIds();

        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('password')
                            ->visibleOn('create')
                            ->password()
                            ->required(),
                        Select::make('department_id')
                            ->relationship('department', 'name', modifyQueryUsing: function (Builder $query) use ($departmentIds) {
                                return $query->whereIn('id', $departmentIds);
                            })
                            ->preload()
                            ->required()
                            ->searchable(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->searchable()
                        ->sortable(),
                    TextColumn::make('email')
                        ->limit(30)
                        ->color('gray')
                        ->icon(Heroicon::Envelope)
                        ->searchable()
                        ->sortable(),
                    TextColumn::make('department.name')
                        ->limit(30)
                        ->icon(Heroicon::Briefcase)
                        ->searchable()
                        ->sortable(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query): Builder => $query
                ->where('role', Role::Teacher)
                ->when(auth()->user()->role == Role::Admin, fn(Builder $query) => $query->with('department'))
                ->when(auth()->user()->role == Role::ProgramHead, fn(Builder $query) => $query->where('department_id', auth()->user()->department_id))
            )
            ->recordActions([
                EditAction::make(),
            ])->contentGrid([
                'sm'  => 1,
                'md'  => 2,
                'xl'  => 3,
                '2xl' => 4,
            ])
            ->paginated([
                16,
                32,
                64,
                'all',
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeachers::route('/'),
            'create' => CreateTeacher::route('/create'),
            'edit' => EditTeacher::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['department']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'department.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->department) {
            $details['Department'] = $record->department->name;
        }

        return $details;
    }
}
