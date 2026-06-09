<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum VehicleAvailability: string implements HasColor, HasIcon, HasLabel
{
    case Available = 'available';
    case InUse = 'in-use';
    case Unavailable = 'unavailable';
    case Reserved = 'reserved';

    public function getLabel(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::InUse => 'In Use',
            self::Unavailable => 'Unavailable',
            self::Reserved => 'Reserved',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Available => 'success',
            self::InUse => 'info',
            self::Unavailable => 'danger',
            self::Reserved => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Available => 'heroicon-m-key',
            self::InUse => 'heroicon-m-arrow-path',
            self::Unavailable => 'heroicon-m-x-circle',
            self::Reserved => 'heroicon-m-bookmark',
        };
    }
}