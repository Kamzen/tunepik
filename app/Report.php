<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    //
    protected $table = 'reports';
    protected $primaryKey = 'report_id';
    protected $fillable = [
        'reporter_id', 'report_type', 'reported_id', 'report_text', 'report_status', 'report_date', 'report_time', 'report_id'
    ];

    public $timestamps = false;
}
