<?php

namespace App\Filament\Resources\ForensicCases\Pages;

use App\Filament\Resources\ForensicCases\ForensicCaseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListForensicCases extends ListRecords
{
    protected static string $resource = ForensicCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
