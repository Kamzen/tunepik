<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
      'user_id', 'media_url', 'thumbnail_url', 'text', 'media_date', 'media_time', 'type', 'app_name', 'shared_from_id', 'media_id'
    ];

    public $timestamps = false;

    protected $table = 'mediauploads';
    protected $primaryKey = 'media_id';


}
