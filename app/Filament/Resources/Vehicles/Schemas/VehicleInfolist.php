<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class VehicleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                            TextEntry::make('name'),
                            TextEntry::make('registration_number'),
                            TextEntry::make('vehicle_make'),
                            TextEntry::make('model'),
                            TextEntry::make('year'),
                            TextEntry::make('category'),
                            TextEntry::make('status'),
                            TextEntry::make('availability'),
                            TextEntry::make('assigned_driver'),
                            TextEntry::make('location'),
                            TextEntry::make('last_service_date'),
                            TextEntry::make('notes')
                                ->columnSpanFull(),
                        ]),

                Section::make()
                    ->columnSpanFull()
                    ->schema([
                            Group::make([
                                TextEntry::make('creator.name')
                                    ->label('Created by'), 
                                TextEntry::make('editor.name')
                                    ->label('Edited by'),
                                TextEntry::make('destroyer.name') 
                                    ->label('Deleted by')
                                ])->columns(3)->columnSpan(2),
                            Group::make([
                                TextEntry::make('created_at')
                                    ->dateTime(),
                                TextEntry::make('updated_at')
                                    ->dateTime(),
                                TextEntry::make('deleted_at')
                                    ->dateTime(),
                                ])->columns(3)->columnSpan(2),
                            ]),
                ]);
    }
}