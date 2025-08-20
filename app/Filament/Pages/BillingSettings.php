<?php

namespace App\Filament\Pages;

use App\Enums\Role;
use App\Settings\BillingSetting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class BillingSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = BillingSetting::class;

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Fees')
                    ->schema([
                        TextInput::make('library_fees')
                            ->numeric(),
                        TextInput::make('computer_fees')
                            ->numeric(),
                        TextInput::make('lab_fees')
                            ->numeric(),
                        TextInput::make('athletic_fees')
                            ->numeric(),
                        TextInput::make('cultural_fees')
                            ->numeric(),
                        TextInput::make('guidance_fees')
                            ->numeric(),
                        TextInput::make('handbook_fees')
                            ->numeric(),
                        TextInput::make('registration_fees')
                            ->numeric(),
                        TextInput::make('medical_and_dental_fees')
                            ->numeric(),
                        TextInput::make('school_id_fees')
                            ->numeric(),
                        TextInput::make('admission_fees')
                            ->numeric(),
                        TextInput::make('entrance_fees')
                            ->numeric(),
                        TextInput::make('development_fees')
                            ->numeric(),
                        TextInput::make('tuition_fee_per_unit')
                            ->numeric(),
                        TextInput::make('nstp_fee_per_unit')
                            ->label('NSTP Fee per Unit')
                            ->numeric(),
                        TextInput::make('alco_mem_fees')
                            ->label('ALCO Membership Fees')
                            ->numeric(),
                        TextInput::make('pta_fees')
                            ->label('PTA')
                            ->numeric(),
                        TextInput::make('other_fees')
                            ->numeric(),
                    ])->columnSpanFull(),
            ]);
    }
}
