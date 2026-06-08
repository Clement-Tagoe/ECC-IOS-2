<?php

namespace App\Filament\Resources\Visitors\Schemas;

use App\Helpers\Nationalities;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VisitorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Visitor Details')
                    ->schema([
                        DatePicker::make('date')
                            ->required(),
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('contact')
                            ->required(),
                        Select::make('nationality')
                            ->options(Nationalities::getNationalities())
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('officer_sought')
                            ->required(),
                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name'),
                        Select::make('purpose')
                            ->required()
                            ->options([
                                'Official' => 'Official',
                                'Personal' => 'Personal'
                            ]),
                        Select::make('sex')
                            ->required()
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female'
                            ]),
                        TimePicker::make('time_in')
                            ->required(),
                        TimePicker::make('time_out'),
                        Select::make('status')
                            ->required()
                            ->options([
                                'Visitor' => 'Visitor',
                                'Staff' => 'Staff'
                            ]),
                        Select::make('card_number')
                            ->searchable()
                            ->options(
                                collect(range(1, 50))->mapWithKeys(fn ($number) => [
                                    str_pad($number, 3, '0', STR_PAD_LEFT) => str_pad($number, 3, '0', STR_PAD_LEFT)
                                ])->toArray()
                            ),
                        Textarea::make('remarks')
                            ->columnSpanFull(),
                    ])->columns(2)->columnSpan(2),
            ]);
    }
}
