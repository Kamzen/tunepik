<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    //
	protected $table = 'stories';
	protected $primaryKey = 'story_id';
	protected $fillable = ['user_id', 'story_message', 'story_url', 'story_type', 'story_time', 'story_date', 'story_id'];
	public $timestamps = false;
}
