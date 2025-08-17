<?php

namespace App\Filament\Resources\GradeRequests\Pages;

use App\Filament\Resources\GradeRequests\GradeRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGradeRequest extends EditRecord
{
    protected static string $resource = GradeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
