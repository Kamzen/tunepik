<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table = 'notif_holder';
    protected $primaryKey = 'notif_holder_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'post_id', 'owner_id', 'notif_type', 'seen', 'type', 'notif_holder_id'
    ];

}
