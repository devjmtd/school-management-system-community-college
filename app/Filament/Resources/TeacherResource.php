<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\TeacherResource\Pages;
use App\Models\Department;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TeacherResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'teachers';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $label = 'Teacher';

    protected static ?string $navigationGroup = 'Department Management';

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

    public static function form(Form $form): Form
    {
        $departmentIds = self::getDepartmentIds();

        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('password')
                            ->visibleOn('create')
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
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('department.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->modifyQueryUsing(fn(Builder $query): Builder => $query->where('role', Role::Teacher))
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
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
