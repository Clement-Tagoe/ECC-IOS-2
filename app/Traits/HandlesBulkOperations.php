<?php

namespace App\Traits;

use Filament\Actions\Action;
use Filament\Notifications\Notification;

trait HandlesBulkOperations
{
    public function deleteSelectedAction(): Action
    {
        return Action::make('deleteSelected')
            ->label(__('Delete selected'))
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading(__('Confirm deletion'))
            ->modalDescription(fn (): string => __('You are about to delete :count items. This action cannot be undone.', ['count' => count($this->selectedItems)]))
            ->action(function (): void {

                // $count = $this->fileManagerService->deleteBulk($this->currentDisk, $this->selectedItems);
                // $this->selectedItems = [];

                // Notification::make()
                //     ->title(__(':count items deleted', ['count' => $count]))
                //     ->success()
                //     ->send();
            });
    }

    public function moveSelectedAction(): Action
    {
        return Action::make('moveSelected')
            ->label(__('Move selected'))
            ->icon('heroicon-o-arrow-right')
            ->color('gray')
            ->schema([
                // FolderTreePicker::make('destination')
                //     ->label(__('filament-file-manager::file-manager.labels.destination_folder'))
                //     ->disk($this->currentDisk)
                //     ->default(''),
            ])
            ->action(function (array $data): void {

                // $destination = $data['destination'] ?? '';
                // $count = $this->fileManagerService->moveBulk($this->currentDisk, $this->selectedItems, $destination);
                // $this->selectedItems = [];

                // Notification::make()
                //     ->title(__('filament-file-manager::file-manager.messages.items_moved', ['count' => $count]))
                //     ->success()
                //     ->send();
            });
    }
}