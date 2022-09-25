<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = [
        'liker_id','user_id', 'post_id', 'type', 'like_id'
    ];

    protected $table = 'reaction';
    protected $primaryKey = 'like_id';

    public $timestamps = false;

}
