<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\DepartmentResource\RelationManagers\TeachersRelationManager;
use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Department;
use App\Models\Program;
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

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $slug = 'programs';

    protected static ?string $navigationIcon = 'heroicon-o-cube';

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
                        TextInput::make('code')
                            ->required(),
                        Select::make('department_id')
                            ->relationship('department', 'name', modifyQueryUsing: function (Builder $query) use ($departmentIds) {
                                return $query->whereIn('id', $departmentIds);
                            })
                            ->preload()
                            ->required(function() use ($departmentIds) {
                                return count($departmentIds) === 1;
                            })
                            ->relationship('department', 'name')
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
                TextColumn::make('code'),
                TextColumn::make('department.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['department']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'department.name'];
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
