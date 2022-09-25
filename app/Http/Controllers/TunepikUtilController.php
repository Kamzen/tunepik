<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TunepikUtilController extends Controller
{
    //
    public static function timeDifference($date, $time){

        $now = Carbon::now();
        $dateTime = "";

        if(strlen($date) == 10){
            $dateTime = Carbon::createFromFormat("d/m/Y g:ia ", "{$date} {$time}");
        }else{
            $dateTime = "{$date} {$time}";
        }

        $minutes = Carbon::parse($dateTime)->diffInMinutes($now);
        // $minutes = Carbon::parse($timeNow)->diffInMinutes($now);

        if($minutes <= 3){ // Just Now

            return 'just now';

        }else if ($minutes > 3 && $minutes < 60) { // Minutes, Less Than An Hour

            return $minutes.'m ago';

        }else if($minutes >= 60 && $minutes < 1440){ // Hours, Less Than A Day

            return round(($minutes/60)).'h ago';

        }else if($minutes >= 1440 && $minutes < 10080){ // Days, Less Than A Week

            return round(($minutes / 1440)).'d ago';

        }else if($minutes >= 10080 && $minutes < 40320){ // Weeks, Less Than A Month

            return round(($minutes / 10080)).'wk ago';

        }else{

            return "{$date}";

        }

    }

    public static function error($e){

        return response()->json([

            'error' => true,
            'message' => $e,

        ]);

    }

    public static function id(){
        return auth('api')->check() ? auth('api')->user()->user_id : 0;
    }
    public static function hasUser(){}
    public static function hasPost(){}
    public static function isNumber(){}
}
