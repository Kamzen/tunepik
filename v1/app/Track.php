<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{

    protected $table = 'track';

    protected $primaryKey = 'track_id';

    protected $fillable = [
        'ip_address', 'track_date', 'track_time', 'track_place', 'track_screen', 'track_status', 'track_id', 'user_id', 'platform', 'device', 'referer', 'browser'
    ];

    public $timestamps = false;

}
