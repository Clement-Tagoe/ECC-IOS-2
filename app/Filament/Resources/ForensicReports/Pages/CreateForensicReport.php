<?php

namespace App\Filament\Resources\ForensicReports\Pages;

use App\Filament\Resources\ForensicReports\ForensicReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForensicReport extends CreateRecord
{
    protected static string $resource = ForensicReportResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
