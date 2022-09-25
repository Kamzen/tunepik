<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayViews extends Model
{

    protected $table = 'plays';
    protected $primaryKey = 'play_id';

    protected $fillable = [
      'user_id', 'owner_id', 'post_id', 'play_id', 'play_date', 'play_time', 'type'
    ];

    public $timestamps = false;

}
