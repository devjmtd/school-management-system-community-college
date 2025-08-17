<?php

namespace App\Filament\StudentPortal\Resources\TORRequests\Pages;

use App\Enums\PrintRequestStatus;
use App\Enums\Role;
use App\Filament\StudentPortal\Resources\TORRequests\TORRequestResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTORRequest extends CreateRecord
{
    protected static string $resource = TORRequestResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        data_set($data, 'status', PrintRequestStatus::Requested->value);
        data_set($data, 'student_id', auth()->user()->student->id);

        $recipients = User::where('role', Role::Registrar)
            ->orWhere('role', Role::Admin)
            ->get();

        Notification::make()
            ->success()
            ->title('New TOR Request')
            ->body(auth()->user()->name.' has requested a TOR')
            ->sendToDatabase($recipients);

        return parent::handleRecordCreation($data);
    }
}
