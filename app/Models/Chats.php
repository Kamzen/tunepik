<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    
    protected $table = 'chats';
    protected $primaryKey = 'chats_id';
    protected $fillable = [
    	'user_id_one', 'user_id_two', 'last_msg', 'type', 'seen', 'chat_date', 'chat_time', 'chat_id'
    ];

    public $timestamps = false;

}
