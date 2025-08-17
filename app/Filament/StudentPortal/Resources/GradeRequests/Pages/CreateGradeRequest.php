<?php

namespace App\Filament\StudentPortal\Resources\GradeRequests\Pages;

use App\Enums\PrintRequestStatus;
use App\Enums\Role;
use App\Filament\StudentPortal\Resources\GradeRequests\GradeRequestResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGradeRequest extends CreateRecord
{
    protected static string $resource = GradeRequestResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        data_set($data, 'status', PrintRequestStatus::Requested->value);
        data_set($data, 'student_id', auth()->user()->student->id);

        $recipients = User::where('role', Role::Registrar)
            ->orWhere('role', Role::Admin)
            ->get();

        Notification::make()
            ->success()
            ->title('New Grade Request')
            ->body(auth()->user()->name.' has requested a grade')
            ->sendToDatabase($recipients);

        return parent::handleRecordCreation($data);
    }
}
