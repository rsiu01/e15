<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    public function device()
    {
        # Reading belongs to device
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('App\Device');
    }

    public static function findByDevice($slug)
    {
        return self::where('device_id', '=', $slug);
    }
}
