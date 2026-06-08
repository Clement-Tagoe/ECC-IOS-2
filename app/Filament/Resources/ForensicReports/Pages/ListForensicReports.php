<?php

namespace App\Filament\Resources\ForensicReports\Pages;

use App\Filament\Resources\ForensicReports\ForensicReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListForensicReports extends ListRecords
{
    protected static string $resource = ForensicReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
