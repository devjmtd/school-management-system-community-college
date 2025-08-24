<?php

namespace App\Filament\Resources\Enrollments\Pages;

use App\Filament\Resources\Enrollments\EnrollmentResource;
use App\Models\Schedule;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\EditRecord;

class EditEnrollment extends EditRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('printMatriculation')
                ->label('Print Matriculation')
                ->icon('heroicon-s-printer')
                ->color('primary')
                ->action(function (){
                    $fileName = \Str::slug($this->record->student->getAttribute('full_name')). '-matriculation.pdf';

                    $template = view('pdfs.matriculation', [
                        'enrollment' => $this->record,
                        'data' => []
                    ])->render();

                    Browsershot::html($template)
                        ->format('A4')
                        ->save($fileName);

                    return response()->download($fileName)->deleteFileAfterSend(true);
                }),
//            Action::make('add-schedule')
//                ->label('Add Schedule')
//                ->icon('heroicon-s-plus')
//                ->color('primary')
//                ->modalWidth('lg')
//                ->modalHeading('Add Schedule')
//                ->schema([
//                    Select::make('schedules')
//                        ->options([
//                            'Schedule 1' => 'Schedule 1',
//                            'Schedule 2' => 'Schedule 2',
//                        ])
//                ])
//                ->action(function (array $data){
//                    dd($data);
//                })

        ];
    }
}
