<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Suspect extends Model
{
    use Userstamps, SoftDeletes;

    protected $guarded = [];

    public function setTimeOutAttribute($value)
    {
        $this->attributes['time_out'] = $value;

        // Calculate time_stayed when both time_in and time_out are present
        if ($this->time_in && $value) {
            $timeIn = Carbon::parse($this->time_in);
            $timeOut = Carbon::parse($value);
            $this->attributes['time_stayed'] = $timeIn->diff($timeOut)->format('%H:%I:%S'); // HH:MM:SS
            // Or for hours: $this->attributes['time_stayed'] = $timeIn->diffInHours($timeOut, true);
        } else {
            $this->attributes['time_stayed'] = null; // Clear time_stayed if time_out is unset
        }
    }

}
