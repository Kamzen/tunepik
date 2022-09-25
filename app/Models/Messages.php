<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    
    protected $table = 'messages';
    protected $primaryKey = 'msg_id';
    protected $fillable = [
    	'user_id_one', 'user_id_two', 'message', 'url', 'type', 'msg_date', 'msg_time', 'seen', 'msg_id'
    ];

    public $timestamps = false;

}
