<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'block';
    protected $primaryKey = 'block_id';
    protected $fillable = [
        'blocker_id', 'blocked_id', 'block_date', 'block_time', 'block_type', 'block_id'
    ];

    public $timestamps = false;

}
