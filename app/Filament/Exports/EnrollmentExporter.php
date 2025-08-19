<?php

namespace App\Filament\Exports;

use App\Models\Enrollment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class EnrollmentExporter extends Exporter
{
    protected static ?string $model = Enrollment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('student.student_id')
                ->label('Student Number'),
            ExportColumn::make('learner_reference_no'),
            ExportColumn::make('student.last_name'),
            ExportColumn::make('student.first_name')
                ->label('Given Name'),
            ExportColumn::make('student.middle_name'),
            ExportColumn::make('program.code')
                ->label('Degree Program'),
            ExportColumn::make('year_level')
                ->formatStateUsing(fn ($state) => $state->getShortLabel())
                ->label('Year Level'),
            ExportColumn::make('gender')
                ->label('Sex at Birth'),
            ExportColumn::make('lab_units')
                ->state(function (Enrollment $enrollment) {
                    return $enrollment->lab_units;
                })
                ->label('Laboratory Units/subjects'),
            ExportColumn::make('computer_lab_units')
                ->state(function (Enrollment $enrollment) {
                    return $enrollment->computer_lab_units;
                })
                ->label('Computer Laboratory Units/subjects'),
            ExportColumn::make('academic_units')
                ->state(function (Enrollment $enrollment) {
                    return $enrollment->academic_units;
                })
                ->label('Academic Units Enrolled (credit and non-credit courses)'),
            ExportColumn::make('nstp_units')
                ->state(function (Enrollment $enrollment) {
                    return $enrollment->nstp_units;
                })
                ->label('Academic Units of NSTP Enrolled (credit and non-credit courses)'),
            ExportColumn::make('non_nstp_tuition_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->non_nstp_tuition_fees);
                })
                ->label('Tuition Fee based on enrolled academic units (credit and non-credit courses)'),
            ExportColumn::make('nstp_tuition_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->nstp_tuition_fees);
                })
                ->label('NSTP Fee based on enrolled academic units (credit and non-credit courses)'),
            ExportColumn::make('athletic_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->athletic_fees);
                })
                ->label('Athletic Fee'),
            ExportColumn::make('computer_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->computer_fees);
                })
                ->label('Computer Fees'),
            ExportColumn::make('cultural_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->cultural_fees);
                })
                ->label('Cultural Fees'),
            ExportColumn::make('development_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->development_fees);
                })
                ->label('Development Fees'),
            ExportColumn::make('entrance_admission_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->entrance_admission_fees);
                })
                ->label('Entrance/Admission Fees'),
            ExportColumn::make('guidance_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->guidance_fees);
                })
                ->label('Guidance Fees'),
            ExportColumn::make('handbook_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->handbook_fees);
                })
                ->label('Handbook Fees'),
            ExportColumn::make('library_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->library_fees);
                })
                ->label('Library Fees'),
            ExportColumn::make('medical_and_dental_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->medical_and_dental_fees);
                })
                ->label('Medical and Dental Fees'),
            ExportColumn::make('registration_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->registration_fees);
                })
                ->label('Registration Fees'),
            ExportColumn::make('school_id_fees')
                ->state(function (Enrollment $enrollment) {
                    return Number::format($enrollment->school_id_fees);
                })
                ->label('School ID Fees'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your billing export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
