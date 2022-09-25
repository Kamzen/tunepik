<?php

namespace App\Http\Controllers;

use App\Post;
use App\Report;
use App\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    private $loggedInId = 0;
    //
    public function __construct(){

        $this->loggedInId = (new AuthController)->authenticate('api');

    }

    public function makeReport(Request $request, $type, $id){

        if(!$request->hasAny(['type', 'report_text'])) return TunepikUtilController::error('Incomplete Request');

        if(!preg_match("/[0-9]/", $id)) return TunepikUtilController::error('Invalid Request');

        $rows = $request->type == 'post' ? Post::all()
                                                    ->where('user_id', $id) :
                                           User::all()
                                                    ->where('user_id', $id);

        if($rows->count() != 1) return TunepikUtilController::error($request->type == 'post' ? "Post You're Trying To Report Does Not Exist" : "User You're Trying To Report To Report Does Not Exist");

        return response()->json($this->processReport([
            'reporter_id'   => $this->loggedInId,
            'report_type'   => $request->type,
            'report_text'   => $request->report_text,
            'report_status' => 0,
            'report_date'   => date_format(date_create(date('m/d/Y')), 'D, d M Y'),
            'report_time'   => date('g:ia'),
            'report_id'     => null
        ]));

    }

    public function viewReports(Request $request){

    }

    private function processReport(array $report){

        $Report = new Report($report);

        if($Report->save()){

            return [

                'error'     => false,
                'message'     => 'Report Sent, Our Team Will Look Into It As Soon As Possible'

            ];

        }else{

            return [

                'error' => true,
                'message'     => 'Report Filling Unsuccesful, try again later'

            ];

        }

    }

}
