<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follow';
    protected $primaryKey = 'follow_id';

    public $timestamps = false;

    protected $fillable = [
      'user_1_id', 'user_2_id', 'type', 'f_date', 'f_time', 'follow_id'
    ];
    //
}
