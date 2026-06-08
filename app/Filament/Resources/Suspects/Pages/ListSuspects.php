<?php

namespace App\Filament\Resources\Suspects\Pages;

use App\Filament\Resources\Suspects\SuspectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSuspects extends ListRecords
{
    protected static string $resource = SuspectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
