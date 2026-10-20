<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Earthquake extends Model
{
    //
    protected $fillable = ['usgs_id', 'magnitude', 'location', 'occured_at'];

    protected $casts = [
        'occured_at' => 'datetime',
    ];

}
