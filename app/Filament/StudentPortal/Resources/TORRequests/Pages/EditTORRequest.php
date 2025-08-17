<?php

namespace App\Filament\StudentPortal\Resources\TORRequests\Pages;

use App\Filament\StudentPortal\Resources\TORRequests\TORRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTORRequest extends EditRecord
{
    protected static string $resource = TORRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
