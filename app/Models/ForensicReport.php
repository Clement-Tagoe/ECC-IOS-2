<?php

namespace App\Models;

use App\Enums\ForensicReportStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ForensicReport extends Model implements HasMedia
{
    use Userstamps, SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'status' => ForensicReportStatus::class,
    ];
}
