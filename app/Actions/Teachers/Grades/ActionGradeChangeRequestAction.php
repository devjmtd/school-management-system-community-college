<?php

declare(strict_types=1);

namespace App\Actions\Teachers\Grades;

use App\Enums\RequestStatus;
use App\Enums\Role;
use App\Models\GradeChangeRequest;
use App\Models\User;
use Filament\Notifications\Notification;

class ActionGradeChangeRequestAction
{
    public static function execute(int $requestId, RequestStatus $status): void
    {
        $request = GradeChangeRequest::findOrFail($requestId);

        $request->update([
            'status' => $status,
            'actioned_at' => now(),
            'actioned_by' => auth()->user()->id,
        ]);

        if ($status === RequestStatus::Approved) {
            $request->grade->update([
                'finals' => $request->finals,
                'pre_finals' => $request->pre_finals,
                'midterm' => $request->midterm,
                'prelims' => $request->prelims,
                'average' => $request->average,
            ]);
        }

        Notification::make()
            ->title('Grade Change Request Actioned')
            ->body('Your grade change request for '.$request->grade->student->full_name.' in '.$request->grade->subject->name.' has been '.$status->getLabel())
            ->sendToDatabase($request->requestedBy);
    }
}