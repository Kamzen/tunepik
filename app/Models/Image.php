<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'profilepic';
    protected $primaryKey = 'image_id';

    protected $fillable = [

        'user_id', 'image_text', 'image_link', 'image_date', 'image_time', 'type', 'image_id'

    ];

    public $timestamps = false;

}
