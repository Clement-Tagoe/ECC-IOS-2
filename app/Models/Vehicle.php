<?php

namespace App\Models;

use App\Enums\VehicleAvailability;
use App\Enums\VehicleCategory;
use App\Enums\VehicleStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Vehicle extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => VehicleStatus::class,
        'category' => VehicleCategory::class,
        'availability' => VehicleAvailability::class,
    ];
}
