<?php

namespace App\Models;

use App\Enums\ProcurementPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Procurement extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, Userstamps;

    protected $guarded = [];

    protected $casts = [
        'priority' => ProcurementPriority::class,
    ];
}
