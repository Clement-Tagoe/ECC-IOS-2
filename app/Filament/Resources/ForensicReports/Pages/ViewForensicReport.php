<?php

namespace App\Filament\Resources\ForensicReports\Pages;

use App\Enums\ForensicReportStatus;
use App\Filament\Resources\ForensicReports\ForensicReportResource;
use App\Models\ForensicReport;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class ViewForensicReport extends ViewRecord
{
    protected static string $resource = ForensicReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('change_status')
                ->icon(Heroicon::ArrowPathRoundedSquare)
                ->color('primary')
                ->modalWidth(Width::Medium)
                ->modalSubmitActionLabel('Save')
                ->stickyModalFooter()
                ->fillForm(fn (ForensicReport $record): array => [
                    'status' => $record->status,
                ])
                ->schema([
                    ToggleButtons::make('status')
                        ->options(ForensicReportStatus::class)
                        ->inline()
                        ->required(),
                ])
                ->action(function (ForensicReport $record, array $data): void {
                    $record->update($data);
                    $this->refreshFormData(['status']);
                }),
            EditAction::make(),
        ];
    }
}
