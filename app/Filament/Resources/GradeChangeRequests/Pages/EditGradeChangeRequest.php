<?php

namespace App\Filament\Resources\GradeChangeRequests\Pages;

use App\Filament\Resources\GradeChangeRequests\GradeChangeRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGradeChangeRequest extends EditRecord
{
    protected static string $resource = GradeChangeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            ViewAction::make(),
//            DeleteAction::make(),
        ];
    }
}
