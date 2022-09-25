<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifCounter extends Model
{

    protected $table = 'notif_counter';
    protected $primaryKey = 'n_counter_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'post_id', 'type', 'n_counter_id'
    ];

}
