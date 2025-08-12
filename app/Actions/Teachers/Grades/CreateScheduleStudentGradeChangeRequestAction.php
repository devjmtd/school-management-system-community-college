<?php

declare(strict_types=1);

namespace App\Actions\Teachers\Grades;

use App\Data\Teachers\Grades\CreateScheduleStudentGradeChangeRequestData;
use App\Enums\RequestStatus;
use App\Enums\Role;
use App\Models\Grade;
use App\Models\GradeChangeRequest;
use App\Models\User;
use Filament\Notifications\Notification;

class CreateScheduleStudentGradeChangeRequestAction
{
    public static function execute(CreateScheduleStudentGradeChangeRequestData $data): void
    {
        \DB::transaction(function () use ($data) {
            $grade = Grade::where('student_id', $data->studentId)
                ->where('subject_id', $data->subjectId)
                ->firstOrFail();

            GradeChangeRequest::create([
                'grade_id' => $grade->id,
                'reason' => $data->remarks,
                'status' => RequestStatus::Pending,
                'average' => $data->average,
                'finals' => $data->finalsGrade,
                'pre_finals' => $data->preFinalsGrade,
                'midterm' => $data->midtermsGrade,
                'prelims' => $data->prelimsGrade,
                'requested_by' => auth()->user()->id,
            ]);

            $recipients = User::where('role', Role::Registrar)
                ->orWhere('role', Role::Admin)
                ->get();

            Notification::make()
                ->success()
                ->title('New Grade Change Request')
                ->body(auth()->user()->name.' has requested a grade change for '.$grade->student->full_name.' in '.$grade->subject->name)
                ->sendToDatabase($recipients);

//            foreach ($recipients as $recipient) {
//                $recipient->notify(
//                    Notification::make()
//                        ->title('New Grade Change Request')
//                        ->body(auth()->user()->name.' has requested a grade change for '.$grade->student->full_name.' in '.$grade->subject->name)
//                        ->toDatabase()
//                );
//            }

        });
    }
}