<?php

namespace App\Http\Controllers;

use App\Block;
use App\Follow;
use App\Image;
use App\PlayViews;
use App\Post;
use App\ProfileVisit;
use App\Trending;
use App\User;
use App\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserModelController extends Controller
{

    protected $LoggedId = '', $UserId = '';
    protected $defaultProfileImg = 'http://localhost/kampuscrush/default_profile.png';
    protected $defaultCoverImg = 'http://localhost/kampuscrush/static/assets/default_cover.jpg';

    public function user($id){

        $this->LoggedId = (new AuthController)->authenticate('api');

        $this->UserId = $id;

        return response()->json($this->buildUser());

    }

    public function getProfileByUsername($username){

        $this->LoggedId = (new AuthController)->authenticate('api');

        // Validate The Username
        if(empty($username)) return $this->error("Invalid URL");

        if(preg_match("/[0-9]/", $username)) return $this->error("Invalid Username");

        $mUser = User::all()
                            ->where("user_athandle", $username);

        if($mUser->count() != 1) return $this->error("User Not Found");

        $mUser = $mUser->first();

        $response['user'] = $this->buildUser($mUser->user_id, 'api');

        $response["analyse"] = $this->analyseUser($username);

        $response['error'] = false;

        $response['message'] = "User Found!";

        return response()->json($response);

    }

    public function getId($id = null){

        return empty($this->UserId) ? $id : $this->UserId;
    }

    public function getBasic($id = null){

        $this->UserId = $this->getId($id);

         $mUser = User::all()->where('user_id', $this->UserId);

         if($mUser->count() == 0) return [$this->UserId];

         $mUser = $mUser->first();

         return [
             'user_name'     => $mUser->user_name,
             'user_athandle' => $mUser->user_athandle,
             'user_date'     => $mUser->user_date,
             'user_id'       => $mUser->user_id,
             'has_face_map'  => $mUser->face_map != ''
         ];
    }

    public function getUserInfo($id){

        $this->UserId = $this->getId($id);

        $userInfo = UserInfo::all()->where('user_id', $this->UserId);

        if($userInfo->count() == 0) return [$this->UserId];

        $userInfo = $userInfo->first();

        return [
            'user_id'       => $userInfo->user_id /*== null ? "" : $userInfo->user_id*/,
            'bio'           => $userInfo->bio /*== null ? "" : $userInfo->bio*/,
            'color'         => $userInfo->color /*== null ? "" : $userInfo->color*/,
            'res'           => $userInfo->res /*== null ? "" : $userInfo->res*/,
            'course'        => $userInfo->course /*== null ? "" : $userInfo->course*/,
            'frequent_place'=> $userInfo->frequent_place /*== null ? "" : $userInfo->frequent_place*/,
            'verified'      => Follow::all()->where('user_2_id', $userInfo->user_id)->count() > 10
        ];

    }

    public function getActivity($id = null){

        return [

            'me'            => \auth('api')->check() ? \auth('api')->user()->user_id == $id : false,
            /*'me'            => $this->getId($id) == $this->LoggedId,*/
            'following'     => Follow::all()->where('user_1_id', auth('api')->user()->user_id)->where('user_2_id', $this->getId($id))->count() == 1,
            'followers'     => Follow::all()->where('user_2_id', $this->getId($id))->count(),
            'follows'       => Follow::all()->where('user_1_id', $this->getId($id))->count(),
            'you_blocked'   => Block::all()->where('blocker_id', $this->LoggedId)->where('blocked_id', $this->getId($id))->where('block_type', 'user')->count() == 1,
            'blocked'       => DB::table('block')
                                            ->where('blocker_id', $this->LoggedId)
                                            ->where('blocked_id', $this->getId($id))
                                            ->orWhere('blocker_id', $this->getId($id))
                                            ->where('blocked_id', $this->LoggedId)
                                            ->get()
                                            ->count() == 1
        ];

    }

    public function getImages($id = null){

        $this->UserId = $this->getId($id);

        $ProfileImage = Image::all()->where('user_id', $this->UserId)->where('type', 'profile');
        $CoverImage = Image::all()->where('user_id', $this->UserId)->where('type', 'cover');

        return [

          'profileImg' => $ProfileImage->count() == 0 ? $this->defaultProfileImg : $ProfileImage->first()->image_link,
            'coverImg' => $CoverImage->count() == 0 ? $this->defaultCoverImg : $CoverImage->first()->image_link

        ];

    }

    public function getMedia($id = null){

        $this->UserId = $this->getId($id);

        $UserPosts = Post::all()->where('user_id', $this->UserId);

        return [

            'totCount' => $UserPosts->count(),
            'imgCount' => $UserPosts->where('type', 'image')->count(),
            'vidCount' => $UserPosts->where('type', 'video')->count(),
            'audCount' => $UserPosts->where('type', 'audio')->count()

        ];

    }

    /**
     * Get User Analytics For Their Profile!
     */
    public function analyseUser($handle){

        if(empty($handle)) return $this->error('URL Malformed');

        $mUser = User::all()
                            ->where('user_athandle', $handle);

        if($mUser->count() != 1) return $this->error('This User Does Not Exist!');

        /*
         * Since User Exists, Get That Users' User Id
         * */
        $UserId = $mUser->first()->user_id;

        $responseBuilder = [];

        /*
         * Check For theme Data
         * */
        $themeSong = Post::all()
            ->where('user_id', $UserId)
            ->where('type', 'theme-audio');

            $responseBuilder['has_theme'] = $themeSong->count() > 0;

            /*
             * Get Theme As Post Modelled Data!
             * */
            $responseBuilder['theme_data']     = $themeSong->count() > 0 ? (new PostModelController())->makeResponse($themeSong->toArray()) : "";

        /*
         * Get User Trending!
         * */
        $mTrending = Trending::all();

        $mTrendingResponse  = (new FollowModelController())->getTrending($mTrending->toArray(), 6, $UserId);

        $responseBuilder['user_trending']   = $mTrendingResponse['list'] ? $mTrendingResponse : "";

        /*
         * Get Other Stats
         * */

        /*
         * Get Count Of Users Who Have Visited/ Checked Out Your Profile
         * */
        $responseBuilder['profile_visits']  = ProfileVisit::all()
                                                                ->where('user_id', $UserId)
                                                                ->count();

        /*
         * Get Count Of How Many Views Do Your Videos Have, All Videos Count!
         * */
        $responseBuilder['video_plays']     = PlayViews::all()
                                                            ->where('owner_id', $UserId)
                                                            ->count();

        /*
         * Get Count Of How Many Listens Do Your Audios Have, All Audios Count!
         * */
        $responseBuilder['audio_plays']     = PlayViews::all()
                                                            ->where('owner_id', $UserId)
                                                            ->count();
        $responseBuilder['face_map']        = $mUser->first()->face_map;
        /*
         * Return The Modelled Data!
         * */

        return $responseBuilder;

    }

    public function buildUser(int $id = null, $guard = null){

        $this->LoggedId = (new AuthController())->authenticate($guard);

        return [

            'basic_info' => $this->getBasic($id),
            'info'       => $this->getUserInfo($id),
            'activity'   => $this->getActivity($id),
            'images'     => $this->getImages($id),
            'media'      => $this->getMedia($id),
            'auth'       => \auth('api')->check(),
            'auth_id'    => \auth('api')->check() ? \auth('api')->user()->user_id : 0

        ];

    }


    protected function error($e){

        return response()->json([
            'error' => true,
            'message' => $e
        ]);

    }
}
