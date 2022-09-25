<?php

namespace App\Http\Controllers;

use App\Image;
use App\Post;
use App\User;
use App\UserInfo;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class WebPagesController extends Controller
{

    /*
     * LoggedIn Id!
     * */
    protected $LoggedInId = 0;
    protected $userAgent = '';
    protected $userIpAddress = '';

    protected $browser, $isMobile, $device, $platform, $robot;

    function __construct()
    {
        $this->userAgent();
    }

    public function home(Request $request){

        $crumbs = $this->getCrumbs();
        $title = "";

        if(auth('web')->check()){

            $title = '@'.auth('web')->user()->user_athandle.' - TunePik Home';

        }else{

            $title = 'TunePik Home';

        }

        $crumbs['title']   = $title;

        /**
         * Add Tracker
         * */
        $this->tracker($request, $title);

        /**
         * Return The Correct View Based On Screen!
         * */
        return view($this->isMobile ? 'app.mobile.home' : 'app.desktop.home', $crumbs);

    }

    public function posts(Request $request, $handle, $postId){

        /**
         * Validate Input
         * */
        if(empty($handle) || empty($postId)) return response('This Post Does Not Exist', 404);

        if(!preg_match("/[0-9]/", $postId)) return response('Invalid Post Id',404);

        /**
         * Check If User And Post Exists
         * */
        $mUser = User::all()
                            ->where('user_athandle', $handle);

        $mPost = Post::all()
                            ->where('media_id', $postId)
                            ->where('user_id', $mUser->first()->user_id); // Make Sure This Post Belongs The Handle Owner

        if($mUser->count() == 1 && $mPost->count() == 1){

            /**
             * Everything Is Alright
             * Get The Post Being Requested!
             * */
            $crumbs = $this->getCrumbs();
            $crumbs['post'] = (new PostModelController())->makeResponse($mPost->toArray());
            $crumbs['title'] = "View @{$handle}'s Post";

            /**
             * Add Tracker
             * */
            $this->tracker($request, $crumbs['title']);

            /**
             * Return The Correct View Based On Screen!
             * */
            return view($this->isMobile ? 'app.mobile.posts' : 'app.desktop.posts', $crumbs);

        }else{

            /**
             * Either One Of the Conditions is Fucked Up
             * */
            return response('Invalid URL', 404);

        }

    }

    public function profile(Request $request, $handle){

        /**
         * Check If Handle Is Not Empty!
         * */
        if(empty($handle)) return response('This User Does Not Exist', 404);

        $mUser = User::all()->where('user_athandle', $handle);

        /**
         * Check If A User With This Handle Exists!
         * */
        if($mUser->count() != 1) return response('Either Too Many Users Associated With This Id Or User With This Handle Does Not Exists', 404);

        $mUserModelController = new UserModelController();

        /**
         * Get Logged In User Styles And Preffered Settings
         * */
        $crumbs = $this->getCrumbs();

        /**
         * Get User Data Of The Person This Page Belongs To!
         * */
        $crumbs['handle']       = $handle;
        $crumbs['profileModel'] = $mUserModelController->buildUser($mUser->first()->user_id, 'web');
        $crumbs['analyseData']  = $mUserModelController->analyseUser($handle);
        $crumbs['title']    = "{$mUser->first()->user_name} (@{$handle})";

        /**
         * Add Tracker
         * */
        $this->tracker($request, $crumbs['title']);

        /**
         * Save Profile Visitations
         * Arising Error Would Not Be Handled Here!
         * */
         $visit = (new ErrandsModelController())->profileVisitHelper($mUser->first()->user_id, 'web');

        /**
         * Return The Correct View Based On Screen!
         * */
        return view($this->isMobile ? 'app.mobile.profile' : 'app.desktop.profile', $crumbs);

    }

    public function notifications(Request $request){} // Might Not Implement

    public function followers(Request $request){} // Might Not Implement This!

    public function follows(Request $request){} // Might Not Implement This!

    protected function getCrumbs(){

        return [

            'auth_data'   =>  $this->userSession(),
            'model'       => $this->user(),
            'styles'      => $this->userStyles(),
            'color'       => $this->getColor()

        ];

    }

    /**
     *
     * All Methods Below Are Helper Methods.
     * They Don't Interact With Requests Directly Only When Called Within Methods
     * That Are Defined In The api.php Routes File!
     * Essentially This Methods Are The Brains Behind The Responses Given To The
     * Requests
     *
     *****************************************************************************/

    protected function tracker(Request $request, $title){

        (new ErrandsModelController())->addTrackerHelper([
            'ip'        => $request->ip(),
            'place'     => $title,
            'referer'   => $request->headers->has('referer') ? $request->headers->get('referer') : ''
        ], 'web');

    }

    public function userAgent(){

        $agent = new Agent();

        $this->isMobile = $agent->isMobile();

        $this->browser = $agent->browser();

        $this->device = $agent->device();

        $this->platform = $agent->platform();

    }

    /**
     *
     * @param Request $request : request from the web
     *
     * Set All Neccessary Information That Is Needed To Track Users
     ***/

    protected function setAppHeaders(Request $request){

        $this->userAgent        = $request->server('HTTP_USER_AGENT');
        $this->userIpAddress    = $request->getClientIp();

    }

    /**
     *
     * Check For A User Session To Send To The WebPage!
     *
     */
    protected function userSession(){

        $userName = $userHandle = $userImage = $userId = "";
        /*
         * Check If Theres A User Logged In To This Session!
         * */
        if(auth('web')->check()){

            /*
             * True, A User Has Logged In This Session!
             * */
            /*
             * Check If Logged In User Exists!
             * */
            if(User::all()
                        ->where('user_id', auth()->user()->user_id)
                        ->count() == 1){
                /*
                 * User Exists!
                 * */

                /*
                 * Get User Basic Info!
                 * */
                $mUser = auth('web')->user();

                $userId     = $mUser->user_id;
                $userHandle = $mUser->user_athandle;
                $userName   = $mUser->user_name;

                /*
                 * Get User Profile Picture!
                 * */
                $mImage = Image::all()
                                    ->where('user_id', $mUser->user_id)
                                    ->where('type', 'profile');

                $userImage  = $mImage->count() == 0 ? 'http://localhost/kampuscrush/default_profile.png' : $mImage->first()->image_link;


            }else{

                /*
                 *
                 * False, This User Does Not Exist!!
                 * */
                $userId     = 0;
                $userHandle = '@default';
                $userName   = '@default';
                $userImage  = 'http://localhost/kampuscrush/default_profile.png';

            }

        }else{

            /*
             *
             * False, A User Has Not Logged In To This Session!
             * */
            $userId     = 0;
            $userHandle = '@default';
            $userName   = '@default';
            $userImage  = 'http://localhost/kampuscrush/default_profile.png';

        }

        /*
         * Model The Data To Return To The Web Page!
         * */
        return [
            'user_id'       => $userId,
            'user_name'     => $userName,
            'handle'        => $userHandle,
            'img_url'       => $userImage,
            'isLogged'      => auth('web')->check()
        ];

    }

    /**
     * Get Logged In User Modelled Data!
     * If No User Is Logged In, Return An Empty Array
     */
    protected function user(){

        if(auth('web')->check()){

            /*
             * Other Than That!
             * Return The Whole Modelled Data Of The User
             * */
            return (new UserModelController)->buildUser(auth('web')->user()->user_id, 'web');

        }else{

            /*
             * Since Theres No User Logged In
             * Return An Empty Array!
             * */
            return [];

        }

    }

    protected function userStyles(){

        $APP_COLOR = $this->getColor();

        $greyText = $APP_COLOR == '#111' ? 'lightgrey' : 'rgb(105,105,105)';
        $mainText = $APP_COLOR == '#111' ? 'white' : '#111';
        $shadows = $APP_COLOR == '#111' ? 'rgba(211, 211, 211, .175)' : 'rgba(0, 0, 0, .175)';
        $blockPop = $APP_COLOR == '#111' ? ($this->isMobile ? 'rgba(0, 0, 0, 1)' : '#111') : '#fff';
        $listBack = $APP_COLOR == '#111' ? 'rgba(33, 26, 35, 1)' : '#f5f5f5';
        $opposite = $APP_COLOR == '#111' ? 'rgba(211, 211, 211, .175)' : '#fff';

        return "

        .app-nav-xs{

        }

        .reaction-btns-react{
            background-color : {$opposite};
        }

        .feed-comment-body{
            background-color : {$opposite};
        }

        .icon-table{
            border: .05em solid {$opposite};
        }

 		 .app-post-text,
         .app-bold-text,
         .app-max-text,
         .app-bolder-text,
         .like-count,
         .app-mid-text,
         .app-input-field,
         .upload-text{
          color : ".$mainText.";
         }


         .app-grey-text,
         .app-grey-text-lg,
         .app-grey-text-sm{
          color : ".$greyText.";
         }

         .list-group-item.active,
         .list-group-item.active:hover{
            background-color: ".$listBack.";

         }


         .list-group-item{
          border : 0;
         }

         .app-user-info-nav{
          border-bottom: .05em solid rgba(211, 211, 211, .4);
         }

         .reaction-btns-react,
         .feed-comment-body,,
         .main-input-wrapper,
         .edit-input-wrapper,
         .options-pop,
         .record-wrapper,
         .share-audio-record-timer,
         .app-block-post,
         .profile-user-info{
          -webkit-box-shadow: 0 1px 2px ".$shadows.";
            box-shadow: 0 1px 2px  ".$shadows.";
        }

        .mobile-share-control{
           -webkit-box-shadow: 0 2px 3px 4px {$shadows};
            box-shadow: 0 2px 3px 4px {$shadows};
        }

         @media only screen and (max-width: 700px){

          .app-block-popout-content{

            background-color: ".$blockPop.";

          }

          .app-network-status-wrapper{

              position: relative;
              top: -10px;

           }

         }";

    }

    protected function getColor(){

        /**
         * Check If User Is Logged!
         * */
        if(auth('web')->check()){

            /**
             * Get User Info To Fetch Their Preffered Colour
             */
            $mUserInfo = UserInfo::all()
                ->where('user_id', auth('web')->user()->user_id);

            /**
             * This Value Should Always Be One !!
             * */
            if($mUserInfo->count() == 1){

                /**
                 * This User Exists In The Table
                 * */

                $mUserInfo = $mUserInfo->first();

                return $mUserInfo->color/* == '#111' ? '#121212' : '#fff'*/;

            }else{

                return '#fff';

            }

        }else{

            /**
             * If User Not Logged In
             * Return #fff -> White As The Primary Color
             * */
            return '#fff';

        }

    }

}
