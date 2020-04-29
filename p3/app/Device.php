<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function readings()
    {
        # Device has many Readings
        # Define a one-to-many relationship.
        return $this->hasMany('App\Reading');
    }


    public static function findBySlug($slug)
    {
        return self::where('slug', '=', $slug)->first();
    }
}
