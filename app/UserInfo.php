<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';

    protected $fillable = [
        'user_id', 'verified', 'bio', 'color', 'res', 'course', 'frequent_place'
    ];

    public $timestamps = false;
}
