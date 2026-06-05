<?php

namespace App\Models;

use App\Enums\ForensicCaseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ForensicCase extends Model implements HasMedia
{
    use Userstamps, SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'status' => ForensicCaseStatus::class,
    ];
}
