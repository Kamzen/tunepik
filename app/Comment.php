<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = 'comments';
    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'user_id', 'post_id', 'comment_text', 'comment_url', 'thumbnail_url', 'comment_date', 'comment_time',
        'comment_type', 'app_name', 'comment_id'
    ];

    public $timestamps = false;

}
