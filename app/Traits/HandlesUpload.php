<?php

namespace App\Traits;

use App\Models\File;
use Closure;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

trait HandlesUpload {

    use WithFileUploads;

    /** @var array<int, TemporaryUploadedFile> */
    public array $pendingUploads = [];

    public ?int $parent_id = null; 
    public ?File $parent = null;
    public ?File $currentFolder;

    protected function parentRules(?int $user_id = null):array
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

    protected function saveFile(UploadedFile $file, $user, $parent): void
    {
       $path = $file->store('/files/' . $user->id, 'local');

       // Get size from the stored file ✅
        $fileSize = Storage::disk('local')->size($path);

        $model = new File();
        $model->storage_path = $path;
        $model->is_folder = false;
        $model->name = $file->getClientOriginalName();
        $model->mime = $file->getMimeType();
        $model->size = $fileSize;
        $model->created_by = $user->id;
        $model->updated_by = $user->id;

        $parent->appendNode($model);
        
    }
    
    public function uploadFilesAction(): Action
    {
        return Action::make('uploadFiles')
            ->label(__('Upload'))
            ->icon('heroicon-o-arrow-up-tray')
            ->color('primary')
            ->schema([
                Forms\Components\FileUpload::make('files')
                    ->label(__('File'))
                    ->multiple()
                    ->maxSize(5120)
                    ->maxFiles(20)
                    ->storeFiles(false) 
                    ->required()
                    ->rules([
                        fn (): Closure => function (string $attribute, $value, $fail) {
                        /** @var $value \Illuminate\Http\UploadedFile */
                        $file = File::query()->where('name', $value->getClientOriginalName())
                            ->where('created_by', Auth::user()->id)
                            ->where('parent_id', $this->parent_id)
                            ->whereNull('deleted_at')
                            ->exists();

                        if ($file) {
                            $fail('File "' . $value->getClientOriginalName() . '" already exists.');
                        }
                      }
                    ]),
            ])
            ->action(function (array $data):void {
                
                $this->parent_id = $this->currentFolder->id;
                if($this->parentRules(Auth::user()->id))
                    {
                        foreach ($data['files'] as $file) {
                            /** @var \Illuminate\Http\UploadedFile $file */
                            $this->saveFile($file, Auth::user(), $this->currentFolder);
                        }
                    }
            });
    }
}