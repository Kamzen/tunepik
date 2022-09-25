<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileVisit extends Model
{
    protected $table = 'profile_visits';

    protected $fillable = [
    	'user_id', 'visitor_id', 'visit_date', 'visit_time', 'visit_id'
    ];

    public $timestamps = false;

}
