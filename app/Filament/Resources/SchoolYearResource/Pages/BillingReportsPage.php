<?php

namespace App\Filament\Resources\SchoolYearResource\Pages;

use App\Enums\YearLevel;
use App\Filament\Exports\EnrollmentExporter;
use App\Filament\Resources\SchoolYearResource;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use App\Settings\BillingSetting;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BillingReportsPage extends Page  implements  HasTable, HasSchemas
{
    use InteractsWithRecord;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = SchoolYearResource::class;

    protected string $view = 'filament.resources.school-year-resource.pages.billing-reports-page';

    public function mount(SchoolYear $record): void
    {
        $this->record = $record;
    }

    public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return $this->record->name . ' Billing Reports';
    }

    public function table(Table $table): Table
    {
        $billingSettings = app(BillingSetting::class);

        return $table
            ->query(Enrollment::query())
            ->modifyQueryUsing(fn(Builder $query): Builder => $query->where('school_year_id', $this->record->id))
            ->columns([
                TextColumn::make('student.student_id')
                    ->label('Student Number'),
                TextColumn::make('learner_reference_no'),
                TextColumn::make('student.last_name'),
                TextColumn::make('student.first_name')
                    ->label('Given Name'),
                TextColumn::make('student.middle_name'),
                TextColumn::make('program.code')
                    ->label('Degree Program'),
                TextColumn::make('year_level')
                    ->formatStateUsing(fn ($state) => $state->getShortLabel())
                    ->label('Year Level'),
                TextColumn::make('gender')
                    ->label('Sex at Birth'),
                TextColumn::make('lab_units')
                    ->label('Laboratory Units/subjects'),
                TextColumn::make('computer_lab_units')
                    ->label('Computer Laboratory Units/subjects'),
                TextColumn::make('academic_units')
                    ->label('Academic Units Enrolled (credit and non-credit courses)'),
                TextColumn::make('nstp_units')
                    ->label('Academic Units of NSTP Enrolled (credit and non-credit courses)'),
                TextColumn::make('non_nstp_tuition_fees')
                    ->money('PHP')
                    ->label('Tuition Fee based on enrolled academic units (credit and non-credit courses)'),
                TextColumn::make('nstp_tuition_fees')
                    ->money('PHP')
                    ->label('NSTP Fee based on enrolled academic units (credit and non-credit courses)'),
                TextColumn::make('athletic_fees')
                    ->money('PHP')
                    ->label('Athletic Fee'),
                TextColumn::make('computer_fees')
                    ->money('PHP')
                    ->label('Computer Fees'),
                TextColumn::make('cultural_fees')
                    ->money('PHP')
                    ->label('Cultural Fees'),
                TextColumn::make('development_fees')
                    ->money('PHP')
                    ->label('Development Fees'),
                TextColumn::make('entrance_admission_fees')
                    ->money('PHP')
                    ->label('Entrance/Admission Fees'),
                TextColumn::make('guidance_fees')
                    ->money('PHP')
                    ->label('Guidance Fees'),
                TextColumn::make('handbook_fees')
                    ->money('PHP')
                    ->label('Handbook Fees'),
                TextColumn::make('library_fees')
                    ->money('PHP')
                    ->label('Library Fees'),
                TextColumn::make('medical_and_dental_fees')
                    ->money('PHP')
                    ->label('Medical and Dental Fees'),
                TextColumn::make('registration_fees')
                    ->money('PHP')
                    ->label('Registration Fees'),
                TextColumn::make('school_id_fees')
                    ->money('PHP')
                    ->label('School ID Fees'),
            ])
            ->filters([
                SelectFilter::make('program_id')
                    ->label('Degree Program')
                    ->relationship('program', 'name'),
                SelectFilter::make('year_level')
                    ->options(YearLevel::class),
            ])
            ->deferFilters(false)
            ->headerActions([
                ExportAction::make()
                    ->label('Export Billing Report')
                    ->exporter(EnrollmentExporter::class)
            ]);
    }
}
