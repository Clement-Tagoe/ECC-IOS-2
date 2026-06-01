<div>
    {{-- Main content --}}
    <div class="flex min-w-0 flex-1 flex-col gap-4">
        {{-- Toolbar --}}
        @include('components.toolbar')
        
        
        {{-- Breadcrumbs --}}
        @include('components.breadcrumbs')

        {{-- Content --}}
        <div class="flex flex-col rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10" data-fm-content @click="previewFile = null">
            @if ($files && !$files->isEmpty())
                @if ($viewMode === 'grid')
                    <div class="flex-1 overflow-y-auto">
                        <div class="grid grid-cols-2 gap-4 p-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                            @foreach ($files as $file)
                                @if ($file->is_folder)
                                    @include('components.file-card', ['item' => $folder, 'isFolder' => true])
                                @else
                                    @include('components.file-card', ['item' => $file, 'isFolder' => false,])
                                @endif
                            @endforeach
                        </div>

                        @if ($hasMoreFiles)
                            <div
                                x-intersect="$wire.loadMore()"
                                wire:key="sentinel-{{ $filePage }}"
                                class="flex items-center justify-center p-4"
                            >
                                <x-filament::loading-indicator class="size-5 text-gray-400 dark:text-gray-500" />
                                <span class="ml-2 text-xs text-gray-400 dark:text-gray-500">{{ __('Loading more...') }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex-1 overflow-y-auto">
                    <div class="divide-y divide-gray-200 dark:divide-white/10">
                        {{-- List header --}}
                        <div class="flex items-center gap-4 px-4 py-2 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                            <div class="w-8 shrink-0">
                                <input
                                    type="checkbox"
                                    @change="$event.target.checked ? $wire.selectAll() : $wire.clearSelection()"
                                    :checked="$wire.selectedItems.length > 0 && $wire.selectedItems.length === {{ $files->where('is_folder', true)->count() + $files->where('is_folder', false)->count() }}"
                                    class="size-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-white/20 dark:bg-white/5"
                                />
                            </div>
                            <button wire:click="setSortField('name')" class="flex flex-1 items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200">
                                {{ __('Name') }}
                                @if ($sortField === 'name')
                                    <x-filament::icon :icon="$sortDirection === 'asc' ? 'heroicon-m-chevron-up' : 'heroicon-m-chevron-down'" class="size-3" />
                                @endif
                            </button>
                            <button wire:click="setSortField('size')" class="flex w-24 items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200">
                                {{ __('Size') }}
                                @if ($sortField === 'size')
                                    <x-filament::icon :icon="$sortDirection === 'asc' ? 'heroicon-m-chevron-up' : 'heroicon-m-chevron-down'" class="size-3" />
                                @endif
                            </button>
                            <button wire:click="setSortField('type')" class="hidden w-24 items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200 md:flex">
                                {{ __('Type') }}
                                @if ($sortField === 'type')
                                    <x-filament::icon :icon="$sortDirection === 'asc' ? 'heroicon-m-chevron-up' : 'heroicon-m-chevron-down'" class="size-3" />
                                @endif
                            </button>
                            <button wire:click="setSortField('date')" class="hidden w-36 items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200 lg:flex">
                                {{ __('Date') }}
                                @if ($sortField === 'date')
                                    <x-filament::icon :icon="$sortDirection === 'asc' ? 'heroicon-m-chevron-up' : 'heroicon-m-chevron-down'" class="size-3" />
                                @endif
                            </button>
                            <div class="w-24"></div>
                        </div>

                        @foreach ($files as $file)
                            @if ($files->is_folder)
                                @include('components.file-row', ['item' => $folder, 'isFolder' => true])
                            @else
                                @include('components.file-row', ['item' => $file, 'isFolder' => false])
                            @endif
                        @endforeach

                        @if ($hasMoreFiles)
                            <div
                                x-intersect="$wire.loadMore()"
                                wire:key="sentinel-{{ $filePage }}"
                                class="flex items-center justify-center p-4"
                            >
                                <x-filament::loading-indicator class="size-5 text-gray-400 dark:text-gray-500" />
                                <span class="ml-2 text-xs text-gray-400 dark:text-gray-500">{{ __('Loading more...') }}</span>
                            </div>
                        @endif
                    </div>
                    </div>
                @endif

                {{-- Status bar --}}
                <div class="border-t border-gray-200 px-4 py-2 text-xs text-gray-400 dark:border-white/10 dark:text-gray-500">
                    @php
                        $folderCount =  $files->where('is_folder', true)->count();
                        $fileCount =  $files->where('is_folder', false)->count()
                    @endphp
                    @if (count($selectedItems) > 0)
                        <span class="font-medium text-primary-600 dark:text-primary-400">{{ __(':count selected', ['count' => count($selectedItems)]) }}</span> &mdash;
                    @endif
                    @if ($hasMoreFiles)
                        {{ __(':shown of :total files', ['shown' => $fileCount, 'total' => $totalFiles]) }}
                    @else
                        {{ $totalFiles }} {{ $totalFiles === 1 ? ':count file' : ':count files' }}
                    @endif
                    {{ $folderCount > 0 ? ', ' . $folderCount . ($folderCount === 1 ? ':count folder' : ':count folders') : '' }}
                </div>
            @else
                <div class="flex flex-1 flex-col items-center justify-center gap-3 p-16 text-gray-400 dark:text-gray-500">
                    <x-filament::icon icon="heroicon-o-folder-open" class="size-12" />
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('This folder is empty') }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('Upload files or create a new folder to get started') }}</p>
                </div>
            @endif
        </div>

        <x-filament-actions::modals />
    </div>
</div>
