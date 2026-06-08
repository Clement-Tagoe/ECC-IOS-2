<?php

namespace App\Filament\Resources\Suspects\Pages;

use App\Filament\Resources\Suspects\SuspectResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSuspect extends ViewRecord
{
    protected static string $resource = SuspectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
