<?php

namespace App\Filament\Resources\ForensicCases\Schemas;

use App\Enums\ForensicCaseStatus;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ForensicCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Forensic Case Details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('case_title')
                            ->required(),
                        TextInput::make('reference_id')
                            ->label('Reference ID')
                            ->required(),
                        TextInput::make('location')
                            ->required(),
                        ToggleButtons::make('status')
                            ->options(ForensicCaseStatus::class)
                            ->inline()
                            ->required()
                            ->live()
                            ->default(ForensicCaseStatus::InReview)
                            ->disabled(fn () => !Auth::user()->hasRole(['System-Admin', 'Director', 'Unit-Head(Call-Taking)'])),
                        Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('evidence_files')
                                ->collection('forensic-evidence-files')
                                ->multiple()
                                ->preserveFilenames()
                                ->maxFiles(4)
                                ->nullable(),
                        SpatieMediaLibraryFileUpload::make('chain_of_custody_files')
                                ->collection('forensic-chain-of-custody-files')
                                ->multiple()
                                ->preserveFilenames()
                                ->maxFiles(4)
                                ->nullable(),
                        SpatieMediaLibraryFileUpload::make('images')
                                ->collection('forensic-images')
                                ->multiple()
                                ->image()
                                ->preserveFilenames()
                                ->maxFiles(4)
                                ->nullable(),
                    ]),
            ]);
    }
}
