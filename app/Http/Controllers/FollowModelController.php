<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Post;
use App\Trending;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowModelController extends Controller
{
    protected $LoggedId = 0;
    protected $UserId = 0;
    protected $Response = [
        'error' => false,
        'list'  => false,
        'message' => 'No Users Found'
    ];

    protected function LoggedInId(){

        $this->LoggedId = (new AuthController)->authenticate();

    }

    protected function UserId($id){

        if(empty($id)) return  $this->error('Request Not Processed');

        $this->LoggedInId();

        $this->UserId = $id;

    }

    protected function error($e){

        return response()->json([
           'error'      => true,
           'message'    => $e
        ]);

    }

    public function followers(Request $request, $UserId){

        if(empty($UserId)) return $this->error('Incomplete Request');

        if(!preg_match("/[0-9]/", $UserId)) return $this->error('Invalid Request');

        if(!User::all()->where('user_id', $UserId)->count() == 1) return $this->error('This User Does Not Exist');

        $this->UserId($UserId);

        $Followers = $request->has('last_id') ? Follow::all()
                                                            ->where('user_2_id', $this->UserId)
                                                            ->where('follow_id', '<', $request->last_id)
                                                            ->take(20)
                                               : Follow::all()
                                                            ->where('user_2_id', $this->UserId)
                                                            ->take(20);

        if($Followers->count() == 0) {

            $this->Response['message'] = '@'.User::all()
                                                    ->where('user_id', $UserId)
                                                    ->first()
                                                    ->user_athandle.' Is Not Followed By Anyone At The Moment';

            return response()->json($this->Response);

        }

        return response()->json($this->buildList($Followers->toArray(), 1));

    }

    public function follows(Request $request, $UserId){

        if(empty($UserId)) return $this->error('Incomplete Request');

        if(!preg_match("/[0-9]/", $UserId)) return $this->error('Invalid Request');

        if(!User::all()->where('user_id', $UserId)->count() == 1) return $this->error('This User Does Not Exist');

        $this->UserId($UserId);

        $Follows = $request->has('last_id') ? Follow::all()
                                                            ->where('user_1_id', $this->UserId)
                                                            ->where('follow_id', '<', $request->last_id)
                                                            ->take(20)
                                               : Follow::all()
                                                            ->where('user_1_id', $this->UserId)
                                                            ->take(20);

        if($Follows->count() == 0) {

            $this->Response['message'] = '@'.User::all()
                                                    ->where('user_id', $UserId)
                                                    ->first()
                                                    ->user_athandle.' Is Not Following Anyone At The Moment';

            return response()->json($this->Response);

        }

        return response()->json($this->buildList($Follows->toArray(), 2));

    }

    public function followUser($UserId){

        if(empty($UserId)) return $this->error('Incomplete Request');

        if(!preg_match("/[0-9]/", $UserId)) return $this->error('Invalid Request');

        if(!User::all()->where('user_id', $UserId)->count() == 1) return $this->error('This User Does Not Exist');
        /*
         * Initialize All User Variables/ Ids
         * */
        $this->UserId($UserId);

        /*
         * Check If User Is Already Logged In, If Not Return
         * */
        if($this->LoggedId == 0) return $this->error('Unauthorized Request');

        if($this->LoggedId == $UserId) return $this->error('How You Gonna Follow Yourself?');

        /*
         * Finally Call Request Follow To Start Processing The Request
         * */
        return $this->requestFollow();

    }

    protected function suggests(Request $mRequest){

        $limit = 8;

        $this->LoggedInId();

        if($mRequest->has('limit')){

            $limit = $mRequest->limit;

        }

        /*
         * Return All User Suggestions As Response Of The Request
         * */

        $reqResponse = $this->getSuggestions($limit);
        $reqResponse['trending'] = $this->buildTrending('trends', 8);

        return response()->json($reqResponse);

    }

    public function trending($where, $limit){

        if(empty($where) || empty($limit)) return $this->error('Invalid Request');

        if(preg_match('/[0-9]/', $limit)) return $this->error('Invalid URL');

        /*
         * Return Generic Modelled Data!
         * */
        return response()->json($this->buildTrending($where, $limit));

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

    /**
     *
     * @param array $HashTags : All Distinct hashtags
     * method should be able to get each hashtags total count and then arrange
     * them in Descending order!
     *
     */

    protected function buildTrending($where, $limit){

        $mUser = $mTrending= "";

        /*
         * Get Trending For Home & Search Bar
         * */
        $mTrending = Trending::all();

        /*
         * Check If There Are Hash Tags For Generic Request
         * */
        if($mTrending->count() == 0) return response()->json([
            'list'      => false,
            'error'     => true,
            'message'   => 'There Are No Trending Hashtags At The Moment'
        ]);

        return $this->getTrending($mTrending->toArray(), $limit, $where);

    }

    public function getTrending(array $HashTags, $limit, $where){

        /*
         * Limit The Limit Of Hashtags The Can Be Returned!
         * */
        $limit = $limit > 15 ? 15 : $limit;

        $HashTagArray = [];

        /*
         * Should Get A Better Algorithm To Finding The Total Count Of Trending Hashtags
         * */
        foreach ($HashTags as $hashTag){

            $theTag = "#".(new Trending($hashTag))->trend;

             if($where == 'trends'){

                 /*
                 * For General Showcasing Of Hashtagd
                 * */
                 $HashTagArray[$theTag] = DB::table('mediauploads')
                     ->where('text', 'like' ,"{$theTag}%")
                     ->count();

             }else{

                 /*
                  * Check Hashtags A Certain User Has Used!
                  * */
                 $match = DB::table('mediauploads')
                     ->where('text', 'like' ,"{$theTag}%")
                     ->where('user_id', $where);

                 /*
                  * If User Has Not Used It, Skip!
                  * */
                 if($match->count() == 0) continue; // No Hashtag Found!, Skip Dont Add

                 /*
                  * If Used, Get Count Of All Users Who Have Used This Hashtag
                  * */
                 $HashTagArray[$theTag] = DB::table('mediauploads')
                                                         ->where('text', 'like' ,"{$theTag}%")
                                                         ->count(); // Keep Count Of Every HashTag In All Posts!
             }

        }

        /*
         * If Array That Tracks The Hashtags Is Empty
         * This Method Should Terminate
         * */
        if(empty($HashTagArray)) return [
            'list'      => false,
            'error'     => false,
            'message'   => 'Not Hashtags Found!'
        ];

        /*
         * Sort The Array In Descending Order!!
         * */
        arsort($HashTagArray);

        $response['list']   = true;

        /*
         * Get Array Keys Of Array $HashTagArray
         * */
        $Keys = array_keys($HashTagArray);

            /*
             * Loop Through The Keys To Get Their Values!
             * */
            $iterator = 0;

            foreach ($Keys as $key){

                /*
                 * Set Limit Of How Many Hashtags You Want To Fetch
                 * */
                if($limit == $iterator) break;

                /*
                 * Model Trending Data
                 * */
                $response['trends'][] = [
                        'trend_count'   => $HashTagArray[$key],
                        'trend_hash'    => $key
                ];

                $iterator++; // Increment

            }

            /*
             * Return The Modelled Trending Data!!
             * */
        return $response;

    }

    protected function getSuggestions($limit){

        $mUsers = User::all()->where('user_id', '!=',$this->LoggedId)->random($limit)->toArray();

        $AllSuggestedUsers = [];

        foreach ($mUsers as $user){

            /*
             * Check If Logged In User Follows The Other Users In The Array
             * If Not, Add The User As A Suggestion For Logged In User To Follow
             * If Yes, Skip The User
             * */
            if(Follow::all()
                    ->where('user_1_id', $this->LoggedId)
                    ->where('user_2_id', (new User($user))->user_id)
                    ->count() == 0){

                /*
                 * Add User Into Suggestions Array
                 * */
                $AllSuggestedUsers[] = $user;

            }

        }

        /*
         * If Array's count is Less Than 3, Near Empty
         * Run The Function Again To Try And Populate It Further More!
         * */
        if(count($AllSuggestedUsers) < 3){
            $this->getSuggestions($limit);
        }

        /*
         * Build The Response With More Detailed User Info
         * */
        return $this->buildList($AllSuggestedUsers, 3);

    }

    protected function requestFollow(){

        /*
         * Check If You Already Follow The User Or Not
         * */
        if(Follow::all()
                ->where('user_1_id', $this->LoggedId)
                ->where('user_2_id', $this->UserId)
                ->count() == 0){

            /*
             * You = Logged In User
             * Since You Don't Already Follow This User, You Can Proceed And Follow This User
             * */
            $mFollow = new Follow();

            $mFollow->fill([
                'user_1_id'     => $this->LoggedId,
                'user_2_id'     => $this->UserId,
                'type'          => 'follow',
                'f_date'        => date_format(date_create(date("m/d/Y")), "D, d M Y"),
                'f_time'        => date('g:ia'),
                'follow_id'     => null
            ]);

            if($mFollow->save()){

                /*
                 * On Successful DB Save
                 * */
                (new NotificationModelController())->addFollowNotification($this->UserId, 'Started Following You');

                    return $this->requestFollowPayload([
                        'message'   => 'Following',
                        'follow'    => true
                    ]);

                }else {
                    
                /*
                 * On Unsuccessful DB Save
                 * */
                return $this->error('Request Not Processed');

            }

        }else{

            /*
             * You = Logged In User
             * Since You Already Follow This User, You Can Proceed And Unfollow This User
             * */
            try {

                /*
                 * Delete The Row To Unfollow
                 * */
                if (DB::table('follow')
                    ->where('user_1_id', $this->LoggedId)
                    ->where('user_2_id', $this->UserId)
                    ->delete() == 1){

                    /*
                     * On Successful Unfollow.
                     * Return Success Response Payload
                     * */

                    (new NotificationModelController())->addFollowNotification($this->UserId, 'Unfollowed You');

                    return $this->requestFollowPayload([
                        'follow' => false,
                        'message' => 'Follow'
                    ]);

                }else {

                    /*
                     * On Fail Follow
                     * Return Error Response Payload
                     * */
                    return $this->error('Request Not Processed');
                }

            } catch (\Exception $e) {

                return $this->error('Request Unsuccessful '.$e);

            }

        }

    }

    protected function getUser($id){

        /*
         * Get User Modelled Data From UserModelController Class
         * */
        return (new UserModelController)->buildUser($id);

    }

    public function requestFollowPayload(array $crumbs){

        /*
         * Data Payload To Be Returned When A User Either Follow Or Unfollow Another User.
         * */

        return [

            'error'     => false,
            'follow'    => $crumbs['follow'],
            'message'   => $crumbs['message'],
            'followers' => Follow::all()->where('user_2_id', $this->UserId)->count(),
            'following' => Follow::all()->where('user_1_id', $this->UserId)->count(),
            'mine'      => [
                'followers'     => Follow::all()->where('user_2_id', $this->LoggedId)->count(),
                'following'     => Follow::all()->where('user_1_id', $this->LoggedId)->count()
            ]

        ];

    }

    public function buildList(array $Follows, $followers = 3){

        /*
         * Modelling Data Payload To Be Returned When A User Requests To View Followers/ Following List
         * Of Another User
         * */

        $this->Response['list']     = true;
        $this->Response['error']    = false;
        $this->Response['message']  = 'User List Found';
        $this->Response['count']    = count($Follows);

        /*
         * Iterate Through The Array :$Users
         * */

        foreach ($Follows as $follower) {

            /*
             * :getUser() Gets Users From The UserModelController Class.
             * Pushes All Users Inside An Array Of 'follow_list' Index
             * */
            if($followers < 3) $Id = $followers == 1 ? (new Follow($follower))->user_1_id : (new Follow($follower))->user_2_id;

            $this->Response['follow_list'][] = $this->getUser($followers > 2 ? (new User($follower))->user_id : $Id);

        }
        /*
         * Return The Modelled Data Payload!
         * */
        return $this->Response;

    }
}
