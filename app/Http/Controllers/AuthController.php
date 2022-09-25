<?php

namespace App\Http\Controllers;

use App\User;
use http\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    protected $mUser = null;

    public function validateForPassportPassword($password){

        return Hash::check($password, $this->password);

    }

    public function signup(Request $mRequest){

        $mRequest->validate([
            'username' => 'required|string',
            'email' => 'required|string|',
            'password' => 'required|string'
        ]);

        if(User::all()->where('user_email', '=', $mRequest['email'])->count() > 0) return response()
            ->json([
                'error' => true,
                'message' => 'Email Already Has An Account Registered With Us'
        ]);

        if(User::all()->where('user_athandle', '=', $mRequest['username'])->count() > 0) return response()
            ->json([
                'error' => true,
                'message' => 'Username Has Already Been Taken, Choose One That Is Unique'
            ]);

        $defaultNum = '201710000';

        if($this->createUser([
           'user_athandle'      => trim($mRequest->username),
           'user_name'          => trim($mRequest->username),
           'user_email'         => trim($mRequest->email),
           'user_stunumber'     => $defaultNum,
            'user_date'         => date_format(date_create(date("m/d/Y")), "D, d M Y"),
            'user_password'     => Hash::make(trim($mRequest->password)),
            'user_repassword'   => Hash::make(trim($mRequest->password)),
            'user_id'           => null
        ])) {


            return response()->json([
                'error'   => false,
                'token'   => $this->mUser->createToken('Personal Access Token'),
                'message' => 'Account Created Successfully',
                'user'    => $this->login($mRequest)
            ]);

        }else{
            return response() ->json([
                'error'     => true,
                'message'    => 'Account Creation Unsuccessful'
            ]);

        }

    }

    /**
     * @param array $UserData
     * @return bool
     */
    public function createUser(array $UserData): bool
    {

        $this->mUser = new User;

        $this->mUser->fill($UserData);

        return $this->mUser->save();

    }

    /**
     * @param Request $mRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $mRequest){

        /*if(\auth('api')->check()) return response()
                                                    ->json([
                                                        'error' => true,
                                                        'message' => 'You Are Already Logged In'
                                                    ]);*/

        /*
         * Validate Input Coming In From Request!
         * */
        $validator = Validator::make($mRequest->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string'
        ]);

        /*
         * If Validation Fails, Return Error
         * */
        if($validator->fails()) return response()->json($this->onResponse(false, 'Make Sure All Fields Are Filled'));


        $userCredentials = [
            'user_email' => trim($mRequest->email),
            'password' => trim($mRequest->password)
        ];



       /* if(!Auth::attempt($userCredentials)) return response()->json([
            'message' => 'Unauthorized ',
            'cred' => $userCredentials
        ]);*/

        /*
         * Get Users With This Email.
         * Should Return Only One User.
         * More Than That, Don't Log In This Attempted Login
         * */
        $mUser = User::all()->where('user_email', $userCredentials['user_email']);

        if($mUser->count() == 1){

            /*
             * May Proceed To Check User Credentials
             * */
            if(Auth::attempt($userCredentials)){

                /*
                 * Passwords Match
                 * Log This User In
                 * */

                /*
                 * Get That Specific User Model
                 * */
                $user = $mUser->first();

                /*
                 * Create User Authentication Tokens
                 * */
                $token = \auth()->user()->createToken('Personal Access Token')->accessToken;

                if($mRequest->context == 1){

                    \session([
                        "id"    => \auth()->id()
                    ]);

                }
                $resp = $this->onResponse(true, 'User Login Successful');
                $resp['user'] = (new UserModelController)->buildUser($user->user_id);
                $resp['key']  = $token;

                return response()->json($resp);

            }else{

                /*
                 * Passwords Dont Match!
                 * Don't Log This User In
                 * */

                $resp = $this->onResponse(false, 'Password Is Incorrect');
                $resp['from_user'] = $userCredentials['password'];
                $resp['from_db']   = $mUser->first()->user_password;

                return response()
                                ->json($resp);

            }

        }else{

            /*
             * Return An Error!
             * No User Was Found With Matching This Email
             * */

            return response()
                            ->json($this->onResponse(false, 'Account Matching This Email Address Not Found'));

        }

    }

    public function user(Request $mRequest){

        /*
         * Return User Logged In Modelled Data Info!
         * */
        return response()->json((new UserModelController())->buildUser(\auth('api')->user()->user_id));

    }

    public function authenticate($guard = null){

        $guard = ($guard == null) ? 'api' : 'web';

        return auth('api')->check() ? auth('api')->user()->user_id : 0;

    }

    public function onResponse(bool $logged, $e){

        return [

            'error'     => $logged ? false : true,
            'login'     => $logged,
            'message'   => $e,
            'redirect'  => $logged,
            'url'       => '/'

        ];

    }

}
