<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            DeleteAction::make(),
            Action::make('Remove')
                ->color('danger')
                ->icon('heroicon-s-trash')
                ->requiresConfirmation()
                ->modalDescription('This won\'t delete the teacher, she will be just removed from department.')
                ->action(function (User $user) {
                    $user->update([
                        'role' => null,
                        'department_id' => null
                    ]);

                    return redirect((TeacherResource::getUrl()));
                })
        ];
    }
}
