<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum VehicleCategory: string implements HasColor, HasIcon, HasLabel
{
    case SUV = 'suv';
    case Sedan = 'sedan';
    case PickupTruck = 'pickup truck';
    case Van = 'van';
    case Minibus = 'minibus';
    case Bus = 'bus';
    case Truck = 'truck';
    case Motorcycle = 'motorcycle';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::SUV => 'SUV',
            self::Sedan => 'Sedan',
            self::PickupTruck => 'Pickup Truck',
            self::Van => 'Van',
            self::Minibus => 'Minibus',
            self::Bus => 'Bus',
            self::Truck => 'Truck',
            self::Motorcycle => 'Motorcycle',
            self::Other => 'Other',
        };
    }

    public function getColor(): string
    {
        // Using 'gray' or 'info' as a neutral default for categories
        return 'gray';
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Motorcycle => 'heroicon-m-bolt', // Closest default icon for bike/speed
            default => 'heroicon-m-truck',          // Generic vehicle icon fallback
        };
    }
}