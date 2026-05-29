<?php

namespace App\Traits;

use App\Models\File;
use Filament\Actions\Action;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

trait HandlesFolderOperations {

    public ?File $currentFolder;
    public ?int $parent_id = null; 

    protected function nameRules(?int $user_id = null, ?int $parent_id = null):array
    {
        return [
            'required',
            Rule::unique(File::class, 'name')
                ->where('created_by', $user_id)
                ->where('parent_id', $parent_id)
                ->whereNull('deleted_at')
        ];
    }

    protected function parentFolderRules(?int $user_id = null):array
    {
        return [
            Rule::exists(File::class, 'id')
                ->where(function (Builder $query) use ($user_id) {
                    return $query
                        ->where('is_folder', '=', '1')
                        ->where('created_by', '=' , $user_id);
                })
        ];
    }

    public function createFolderAction(): Action
    {
        return Action::make('createFolder')
            ->label(__('New Folder'))
            ->icon('heroicon-o-folder-plus')
            ->color('gray')
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Folder name'))
                    ->required()
                    ->maxLength(255)
                    ->regex('/^[^\/\\\\]+$/')
                    ->rules($this->nameRules(
                        user_id: Auth::user()->id,
                        parent_id: $this->currentFolder?->id
                    ))
                    ->validationMessages([
                        'regex' => __('The name cannot contain / or \\.'),
                        'unique' => __('A folder with this name already exists.'),
                    ]),
            ])
            ->action(function (array $data): void {
               
                $this->parent_id = $this->currentFolder->id;
                if($this->parentFolderRules(Auth::user()->id))
                    {
                        $folder = new File();
                        $folder->is_folder = 1;
                        $folder->name = $data['name'];
                        $folder->created_by = Auth::user()->id;
                        $folder->updated_by = Auth::user()->id;

                        $this->currentFolder->appendNode($folder);
                    }
            });
    }
}