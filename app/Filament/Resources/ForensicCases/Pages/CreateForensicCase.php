<?php

namespace App\Filament\Resources\ForensicCases\Pages;

use App\Filament\Resources\ForensicCases\ForensicCaseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForensicCase extends CreateRecord
{
    protected static string $resource = ForensicCaseResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
