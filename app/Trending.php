<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trending extends Model
{
    protected $table = 'trending';
    protected $primaryKey = 'trend_id';

    protected $fillable = [
        'user_id', 'trend', 'trend_date', 'trend_time', 'trend_id'
    ];

    public $timestamps = false;
}
