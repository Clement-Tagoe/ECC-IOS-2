<?php

namespace App\Filament\Resources\Suspects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SuspectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Suspect Details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                    DatePicker::make('date')
                        ->required(),
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('officer_in_charge')
                        ->required(),
                    TimePicker::make('time_in')
                        ->required(),
                    TimePicker::make('time_out'),
                    RichEditor::make('personal_items')
                        ->columnSpanFull(),
                    Textarea::make('notes')
                        ->columnSpanFull(),
                ]) 
            ]);
    }
}
