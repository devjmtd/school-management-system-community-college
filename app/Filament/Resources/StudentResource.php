<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $slug = 'students';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Student Information')
                    ->tabs([
                        Tabs\Tab::make('Personal Information')
                            ->schema([
                                TextInput::make('first_name')
                                    ->required(),
                                TextInput::make('last_name')
                                    ->required(),
                                DatePicker::make('date_of_birth')
                                    ->required(),
                                TextInput::make('place_of_birth')
                                    ->maxLength(500),
                                TextInput::make('address')
                                    ->maxLength(500),
                                TextInput::make('provincial_address')
                                    ->maxLength(500),
                                TextInput::make('citizenship')
                                    ->maxLength(255),
                                FileUpload::make('image')
                                    ->image()
                                    ->multiple(false),
                        ]),
                        Tabs\Tab::make('Family Information')
                            ->schema([
                                TextInput::make('father_name')
                                    ->maxLength(255),
                                TextInput::make('father_occupation')
                                    ->maxLength(255),
                                TextInput::make('mother_name')
                                    ->maxLength(255),
                                TextInput::make('mother_occupation')
                                    ->maxLength(255),
                        ]),
                        Tabs\Tab::make('Education')
                            ->schema([
                                TextInput::make('elementary_school'),
                                TextInput::make('elementary_year')
                                    ->integer(),
                                TextInput::make('highschool_school'),
                                TextInput::make('highschool_year')
                                    ->integer(),
                            ]),
                        Tabs\Tab::make('Contact Information')
                            ->schema([
                                TextInput::make('phone_number'),
                                TextInput::make('email'),
                            ]),
                        Tabs\Tab::make('Admission Checklist')
                            ->schema([
                                Repeater::make('admission_checklist')
                                    ->schema([
                                        Checkbox::make('completed')
                                            ->label(fn(Get $get): ?string => $get('requirement')),
                                    ])
                                    ->defaultItems(0)
                                    ->addable(false)
                                    ->reorderable(false)
                                    ->deletable(false),
                            ]),
                        Tabs\Tab::make('Other Information')
                            ->schema([
                                RichEditor::make('notes'),
                                Placeholder::make('created_at')
                                    ->content(fn (?Student $record): string => $record ? $record->created_at->diffForHumans() : ''),
                                Placeholder::make('updated_at')
                                    ->content(fn (?Student $record): string => $record ? $record->updated_at->diffForHumans() : ''),
                            ]),
                    ])->columnSpan(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
