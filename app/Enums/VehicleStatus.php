<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum VehicleStatus: string implements HasColor, HasIcon, HasLabel
{
    case Active = 'active';
    case Maintenance = 'maintenance';
    case Retired = 'retired';

    public function getLabel(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Maintenance => 'Maintenance',
            self::Retired => 'Retired',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Maintenance => 'warning',
            self::Retired => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Active => 'heroicon-m-check-circle',
            self::Maintenance => 'heroicon-m-wrench',
            self::Retired => 'heroicon-m-archive-box',
        };
    }
}