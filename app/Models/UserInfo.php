<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';

    protected $fillable = [
        'user_id', 'bio', 'color', 'res', 'course', 'frequent_place'
    ];
}
