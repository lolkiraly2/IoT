<?php

namespace App\Filament\Resources\WorksheetResource\Pages;

use App\Filament\Resources\WorksheetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorksheet extends EditRecord
{
    protected static string $resource = WorksheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
