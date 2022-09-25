<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileEditModelController extends Controller
{

     protected $LoggedInId = 0;
    protected $counter    = 0;
    protected $password   = "";

    function __construct()
    {

        $this->LoggedInId = \auth('api')->check() ? \auth('api')->user()->user_id : 0;

    }

    public function selfie(Request $request){

        if($this->LoggedInId == 0) return $this->error('Login Into Your Account First');

        if(!$request->has('descriptor')) return $this->error('Incomplete Request');

        if($this->change('users', 'face_map', $request->descriptor)) {
            return response()->json([
                    'error'         => false,
                    'message'       => 'Selfie ID Updated Successfully'
            ]);
        }
        else {

            return $this->error('Updating Selfie Id Failed');

        }

    }

    public function colorMode(Request $request){

        /*
         * Validate tHe Request!
         * */
        if($this->LoggedInId == 0) return response()->json([
            'error'         => true,
            'message'       => 'Log In To Change Your Color Mode'
        ]);

        if(!$request->has('ch-color')) return response()->json([
            'error'         => true,
            'message'       => 'Incomplete Request'
        ]);

        /*
         * Change Color
         * */
        if(!empty($request['ch-color']) && $this->change('user_info', 'color', $request['ch-color'])){

            $this->counter++;

        }

        /*
         * Return On Success Message
         * */
        return response()->json([
            'error'     => false,
            'message'   => 'Color Mode Changed!'
        ]);

    }
    public function edit(Request $request){

        /*
         * Validate The Request
         * */

        if(!$request->has([
            'ch-name', 'ch-email', 'ch-bio', 'ch-residence'
        ])) return response()->json([
            'error'     => true,
            'message'   => 'Request Incomplete'
        ]);

        /*
         * Authenticate User!!
         * */
        /*if($this->authUser($request->password)['error']) return response()->json([
            'error'         => true,
            'message'       => 'Passwords Do Not Match, Enter Your Correct Current Password To Edit Profile!'
        ]);*/

        /*
         * Update Username
         * */

        // dd($request);
        if(!empty($request['ch-name']) && $this->change('users', 'user_name', $request['ch-name'])){

            $this->counter++;

        }

        /*
         * For Email
         * */
        if(!empty($request['ch-email']) && $this->change('users', 'user_email', $request['ch-email'])){

            $this->counter++;

        }

        /*
         * Bio
         * */
        if(/*!empty($request['ch-bio']) && */$this->change('user_info', 'bio', $request['ch-bio'])){

            $this->counter++;

        }

        /*
         * Location
         * */
        if(/*!empty($request['ch-residence']) && */$this->change('user_info', 'res', $request['ch-residence'])){

            $this->counter++;

        }

        /*
         * Change Password
         * */
        /*if(!empty($request['ch-password']) && $this->change('users', 'user_password', $request['ch-password'])){

            $this->counter++;

        }*/

        /*
         * Return Message Letting User Know Whether They Successfully OR Unsuccessfully Changed Their Details
         * */
        return response()->json([
            'error'     => $this->counter == 0,
            'message'   => $this->counter == 0 ? 'Changes Were Applied Unsuccessfully' : "Update Successful, Refresh"
        ]);

    }

    protected function password(Request $request){

        if(!$request->has(
                    [
                    'ch_password', 'confirm_password', 'password'
                ]
            )
          ) return response()->json([

                'error'     => true,
                'message'   => 'Request Incomplete'

            ]);

         if(empty($request->ch_password) && empty($request->confirm_password) && empty($request->password)) return response()->json([
                
             'error'    => true,
             'message'  => 'Password Fields Are Empty'

         ]);

        if($request->ch_password != $request->confirm_password) return response()->json([
            
            'error'     => true,
            'message'   => 'Passwords Do Not Match'
        
        ]);

        $auth = $this->authUser($request->password);

        if($auth['error']) return response()->json($auth);

        /*
         * Change Password
         * */
        if(!empty($request['ch_password']) && $this->change('users', 'password', $request['ch_password'])){

            $this->counter++;

        }

         return response()->json([
            'error'     => $this->counter == 0,
            'message'   => $this->counter == 0 ? 'Changes Were Applied Unsuccessfully' : "Update Successful, Refresh"
        ]);


    }

    protected function authUser(string $password){

        /*
         * Check If User With This Password & User Id Exists!
         * */
        $mUser = User::all()
                            ->where('user_id', $this->LoggedInId);

        /*
         * Check Count First
         * */
        if($mUser->count() != 1) return [
            'error'     => true,
            'message'   => 'User Does Not Exist'
        ];

        $mUser = $mUser->first();

        $credentials = [
            'email'    => $mUser->email,
            'password' => $password
        ];

        if(Auth::attempt($credentials)) return [
            'error'     => true,
            'message'   => 'Current Password Entered Does Not Match Any In Our Record'
        ];

        /*
         * Error Notifier
         * */
        return [ 'error' => false ];

    }

    protected function change(string $table, string $where, $value){

        if(!\auth('api')->check()) return $this->error('Login To Make Any Update');

        /*
         * Update All That Needs Updating!
         * */
        return DB::table($table)
                    ->where('user_id', \auth('api')->check() ? \auth('api')->user()->user_id : 0)
                    ->update([
                        $where => $value
                    ]) == 1;

    }

    protected function error($e){
        return response()->json([
            'error' => true,
            'message' => $e
        ]);
    }


}
