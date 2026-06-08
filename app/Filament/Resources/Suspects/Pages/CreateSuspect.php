<?php

namespace App\Filament\Resources\Suspects\Pages;

use App\Filament\Resources\Suspects\SuspectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSuspect extends CreateRecord
{
    protected static string $resource = SuspectResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
