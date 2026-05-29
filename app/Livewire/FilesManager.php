<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\User;
use App\Enums\FileManager\SortDirection;
use App\Enums\FileManager\ViewMode;
use App\Traits\HandlesFolderOperations;
use App\Traits\HandlesUpload;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class FilesManager extends Component implements HasActions, HasForms
{
    use InteractsWithActions, InteractsWithForms, WithFileUploads, WithPagination, HandlesUpload, HandlesFolderOperations;

    public ?File $currentFolder;
    public $folder = '';
    public string $currentPath = '';

     #[Url]
    public string $viewMode = 'grid';

    #[Url]
    public string $sortField = 'name';

    #[Url]
    public string $sortDirection = 'asc';

    public function setViewMode(string $mode): void
    {
        $this->viewMode = $mode;
    }

    public function setSortField(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = SortDirection::from($this->sortDirection)->toggle()->value;
        } else {
            $this->sortField = $field;
            $this->sortDirection = SortDirection::Asc->value;
        }

        $this->resetPagination();
    }

    public function getViewModeEnum(): ViewMode
    {
        return ViewMode::from($this->viewMode);
    }

    public function getRoot()
    {
        return File::query()->whereIsRoot()->where('created_by', Auth::user()->id)->firstOrFail();
    }

    public function navigateTo(string $path): void
    {
        $this->currentPath = $path;
    }

    public function render()
    {
        if ($this->folder) {
            $this->currentFolder = File::query()->where('created_by', Auth::user()->id)->where('path', $this->folder)->firstOrFail();
        }
    
        if (!$this->folder) 
            {
                $this->currentFolder = $this->getRoot();
            }
        
        $folder = $this->currentFolder;
        
        $ancestors = $folder->ancestorsAndSelf($folder->id);

        $files = File::query()
                        ->where('parent_id', $folder->id)
                        ->where('created_by', Auth::user()->id)
                        ->orderBy('is_folder', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);

        return view('livewire.files-manager', compact('files', 'ancestors'));
    }

}
