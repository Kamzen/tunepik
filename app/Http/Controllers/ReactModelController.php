<?php

namespace App\Http\Controllers;

use App\Block;
use App\Comment;
use App\PlayViews;
use App\Post;
use App\Reaction;
use App\User;
use App\Events\InstantPostStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReactModelController extends Controller
{
    /*
     * User Ids
     * */
    protected $LoggedInId = 0;
    protected $UserId     = 0;

    /*
     * Class Vars
     * */
    protected $PostId  = 0;
    protected $OwnerId = 0;
    protected $type    = 'post';



    public function like(Request $mRequest, $postId){

        $this->setIds();

        /*event(new \App\Events\UserCounter(\auth()->user()));*/


        if(empty($postId) || empty($mRequest->type)) return $this->error('Incomplete Request');

        if(!preg_match("/[0-9]/", trim($postId))) return $this->error('Invalid Request!');

        /*
         * Check If User Logged In. If Not, Dont Process The Request Any Further
         * */
        if($this->LoggedInId == 0) return $this->error('Unauthorized Request');

        /*
         * Check If Post Exists
         * */
         if(!Post::all()->where('media_id')->count() == 1) return $this->error('This Post Does Not Exist!');

        /*
         * Check If Post Id Of The Liked Post Is Avail In The Request. If Not, Dont Process
         * The Request Any Further
         * */
        if(!$mRequest->has('type')) return $this->error('Incomplete Request');

        /*
         * All Checks Where Made, Process Request
         * */
        return $this->processLike($postId, $mRequest->type);

    }

    public function views($postId){

        $this->setIds();

        /*
         * Check If postId is Set
         * */
        if(empty($postId) || $postId == 0) return $this->error('Incomplete Request');

        /*
         * Check If Post Id Is All Digits
         * */
        if(!preg_match("/[0-9]/", trim($postId))) return $this->error('Invalid Request');
        /*
         * Check If Post Exists
         * */
        if(!Post::all()->where('media_id')->count() == 1) return $this->error('This Post Does Not Exist!');


        /*
         * For Not Logging Views Of Users Not Logged In
         * */
        if($this->LoggedInId == 0) return response()->json([
            'error' => false,
            'pass'  => true
        ]);

        return $this->insertViews($postId);

    }

    public function block($userId){

        /*
         * Block Users From Viewing Your Posts And Profile!
         * */
        if(empty($userId)) return $this->error('Imcomplete Request');

        if(!preg_match("/[0-9]/", trim($userId))) return $this->error('Invalid Request');

        if(!User::all()->where('user_id', trim($userId))->count() == 1) return $this->error('This User Does Not Exist');

        $this->setIds(trim($userId));

        if($this->LoggedInId == 0) return $this->error('Unauthorized Request');

            return response()->json($this->processBlock());

    }

    public function blocked(Request $request){

        /*
         * Show Users Logged In User Has Blocked
         * */
        $this->setIds();

        if($this->LoggedInId == 0) return $this->error('Unauthorized Request');

            return response()->json($this->showBlocked($request));

    }

    public function deletePost(Request $request, $postId){

        /*
         * Check If postId is Set
         * */
        if(empty($postId) || $postId == 0) return $this->error('Incomplete Request');

        if(!$request->has('type')) return $this->error('Incomplete Request');
        /*
         * Check If Post Id Is All Digits
         * */
        if(!preg_match("/[0-9]/", trim($postId))) return $this->error('Invalid Request');

         $this->setIds();

        if($this->LoggedInId == 0) return $this->error('Unauthorized Request');
        
        switch ($request->type) {

            case 'post':

                /*
                 * Check If Post Exists
                 * */
                if(!Post::all()->where('media_id')->count() === 1) return $this->error('This Post Does Not Exist!');

                return response()->json($this->processDeletePost($postId));

                break;
            case 'comment':

                if(!Comment::all()->where('post_id')->count() === 1) return $this->error('This Comment Does Not Exist');

                return response()->json($this->processDeleteComment($postId));
            
            default:
                # code...
                break;
        }

        /*
         * Delete Either A Post
         * */

    }

    public function likers(Request $request, $postId){

        if(!$request->has('type')) return $this->error('Incomplete Request');

        if(!$request->type == 'post' || !$request->type == 'comment') return $this->error('Invalid Request');

        if(empty($postId)) return $this->error('Invalid Request');

        if(!preg_match("/[0-9]/", $postId)) return $this->error('Invalid Request');

        if($request->type == 'post'){

            if(!Post::all()->where('media_id', $postId)->count() == 1) return $this->error('This Post Is Invalid');

        }else{

            if(!Comment::all()->where('comment_id', $postId)->count() == 1) return $this->error('This Comment Is Invalid');

        }

        $mLikers = $request->has('last_id') ? Reaction::all()
                                                            ->where('post_id', $postId)
                                                            ->where('type', $request->type)
                                                            ->where('like_id', '<', $request->last_id)
                                                            ->take(20)
                                            : Reaction::all()
                                                            ->where('post_id', $postId)
                                                            ->where('type', $request->type)
                                                            ->take(20);

            if($mLikers->count() == 0) return response()->json([
                'error' => false,
                'list'  => false,
                'message'=> 'No One Has Liked This, Be The First!'
            ]);

         /*
          * Return The Data For Response
          * */

        return response()->json($this->buildUserList($mLikers->toArray()));

    }

    public function commenters($postId){

        if(empty($postId)) return $this->error('Invalid Request');

        if(!preg_match("/[0-9]/", $postId)) return $this->error('Invalid Request');

        if(!Post::all()->where('media_id', $postId)->count() == 1) return $this->error('This Post Is Invalid');

        $Commenters = Comment::all()->where('post_id', $postId);

         if($Commenters->count() == 0) return response()->json([
             'error'    => false,
             'list'     => false,
             'message'  => 'No One Has Commented On This Post, Be The First!'
         ]);

         return response()->json($this->buildCommenterUsersList($Commenters->toArray()));

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

    public function error($e){

        /*
         * Error Method For Handling All Generic Errors
         * :$e Is The Error Message
         * */
        return response()->json([
            'error'     => true,
            'message'   => $e
        ]);

    }

    public function setIds($id = null){

        $this->LoggedInId = (new AuthController)->authenticate();

        $this->UserId = $id;

    }

    /**
     *
     * Methods That Follow Are Only Related To Liking!
     *
     **************************************************************/

    protected function processLike($postId, $type){

        $this->PostId = $postId;
        $this->type   = $type;

        /*
         * Start Processing The Like Request
         * */

        /*
         * First, Check If You Already Liked This Post/ Comment.
         * If Not Liked, You Can Proceed Liking
         * Else, You Can Process Unliking
         * */
        $mReaction = Reaction::all()
                                ->where('liker_id', $this->LoggedInId)
                                ->where('type', $this->type)
                                ->where('post_id', $this->PostId);

            if($mReaction->count() == 0){

                /*
                 * You Have Not Liked This Post/ Comment.
                 * You Can Proceed Liking It!
                 * */

                /*
                 * Create New Reaction Object To Start DB Inserting!
                 * */
                $mReaction = new Reaction();

                $mReaction->fill([
                   'liker_id'   => $this->LoggedInId,
                   'post_id'    => $this->PostId,
                   'type'       => $this->type,
                    'like_id'   => null
                ]);

                (new NotificationModelController())->addLikePostNotification($this->PostId);

                return $mReaction->save() ?
                /*
                 * On Successful DB Save.
                 * Return Success Payload
                 * */
                    $this->likePayload(['message' => 'flamed']) :
                 /*
                  * On Unsuccessful DB Save,
                  * Return On Fail Payload
                  * */
                    $this->error('Request Not Processed');

            }else{

                /*
                 * You Have Already Liked This Post/ Comment
                 * You Can Proceed Unliking It!
                 * */

                try {

                    return DB::table('reaction')
                        ->where('liker_id', $this->LoggedInId)
                        ->where('type', $this->type)
                        ->where('post_id', $this->PostId)
                        ->delete() ?

                        /*
                         * Unliked Successfully.
                         * Return Success Payload
                         * */
                        $this->likePayload(['message' => 'unflamed']) :

                        /*
                         * Unliked Unsuccessfully.
                         * Return On Fail Payload
                         * */
                        $this->error('Request Not Processed');

                } catch (\Exception $e) {

                    return $this->error('Request Failure');

                }

            }

    }

    protected function likePayload(array $crumbs){

        $payload = [
          'error'       => false,
          'message'     => $crumbs['message'],
          'count'       => Reaction::all()->where('post_id', $this->PostId)->where('type', $this->type)->count(),
            'type'      => $this->type,
            'liked'     => $crumbs['message'] == 'flamed',
            'liked_by'  => (new PostModelController())->getLikedBy($this->PostId),
            'id'        => $this->PostId,
            'comments'  => Comment::all()
                                    ->where('post_id', $this->PostId)
                                    ->count(),
            'shares'    => Post::all()
                                    ->where('shared_from_id', $this->PostId)
                                    ->count()
        ];

       /* event(new InstantPostStats($payload));*/

        return $payload;

    }

    /**
     *
     *  End Of All Like Methods
     ***************************************************************/

    /**
     *
     * Methods That Follow Are Only Related To Views
     ****************************************************************/

    protected function insertViews($postId){

        /*
         * Get The Post In Question
         * */
        $mPost = Post::all()->where('media_id', $this->PostId)->first();

        /*
         * $postId = Id Of The Post
         * $ownerId = Id Of Whom The Post Belongs To
         * $type   = Type Of The Post, video | audio
         * */
        $this->PostId   = $postId;
        $this->OwnerId  = $mPost->user_id;
        $this->type     = $mPost->type;

        /*
         * Check If This You Already Seen The Media.
         * If Not Seen, Log The View
         * Else, Don't Log The View
         * */

        if(PlayViews::all()
            ->where('user_id', $this->LoggedInId)
            ->where('post_id', $this->PostId)
            ->count() == 0){

            /*
             * Now Insert The View!
             * */
            $mPlayView = new PlayViews();

            $mPlayView->fill([
               'user_id'    => $this->LoggedInId,
               'owner_id'   => $this->OwnerId,
               'post_id'    => $this->PostId,
               'play_id'    => null,
               'play_date'  => date_format(date_create(date("m/d/Y")), "D, d M Y"),
               'play_time'  => date('g:ia'),
               'type'       => $this->type
            ]);

            return $mPlayView->save() ?
                /*
                 * On Successful DB Save
                 * */
                    [
                        'error'     => false,
                        'pass'      => false,
                        'count'     => PlayViews::all()->where('post_id', $this->PostId),
                        'type'      => $this->type
                    ] :
                /*
                 * On Unsuccessful DB Save
                 * */
                    $this->error('Request Not Processed');

        }else{

            return [
              'error'   => false,
              'pass'    => true
            ];

        }

    }

    protected function processBlock(){

        /*
         *  Check If You Already Blocked This User Or Not.
         *  If Not Blocked, Continue To Blocking This User.
         *  Else, Continue To Unblocking This User
         * */

        $mBlock = Block::all()
            ->where('blocker_id', $this->LoggedInId)
            ->where('blocked_id', $this->UserId);

        if($mBlock->count() == 0){

            /*
             * You Have Not Blocked This User, You Can Continue To Blocking This User
             * */

            $mBlock = new Block([
                'blocker_id'    => $this->LoggedInId,
                'blocked_id'    => $this->UserId,
                'block_type'    => 'user',
                'block_date'    => date_format(date_create(date('m/d/Y')), "D, d M Y"),
                'block_time'    => date('g:ia'),
                'block_id'      => null
            ]);

            return $mBlock->save() ?
                /*
                 * On Successful Save
                 * */
                    [
                        'error'     => false,
                        'message'   => 'Unblock',
                        'blocked'   => true
                    ] :
                /*
                 * On Unsuccessful Save
                 * */
                    $this->error('Failed To Block User');

        }else{

            /*
             * You Have Already Blocked This User, You Can Continue To Unblocking This User
             * */

            try {

                return  DB::table('block')
                        ->where('blocker_id', $this->LoggedInId)
                        ->where('blocked_id', $this->UserId)
                        ->delete() ?
                    /*
                     * On Successful Delete
                     * */
                       [
                           'error'      => false,
                           'message'    => 'Block',
                           'blocked'    => false
                       ] :
                    /*
                     * On Unsuccessful Delete
                     * */
                       $this->error('Failed To Unblock User');

            } catch (\Exception $e) {

                return $this->error('Request Not Processed');

            }

        }

    }

    protected function processDeletePost($postId){

        /*
         * Delete Post
         * */
        $this->PostId = $postId;

        /*
         * Fetch The Post In Question
         * */
        $mPost = Post::all()->where('media_id', $this->PostId)->where('user_id', $this->LoggedInId);

        /*
         * Check If This Post Exists!
         * */
        if($mPost->count() == 1){

            /*
             * Post Exists!.
             * Update `text` & `type`
             * */

            return DB::table('mediauploads')
                ->where('user_id', $this->LoggedInId)
                ->where('media_id', $this->PostId)
                ->update([
                    /*'media_url' => "",*/
                    /*'text'      => 'This Post Has Been Deleted By The Author',*/
                    'type'      => 'deleted'
                ]) == 1 ?
                [
                    'error'     => false,
                    'deleted'   => true,
                    'message'   => 'Post Has Been Deleted'
                ] : [
                    'error'     => true,
                    'deleted'   => false,
                    'message'   => 'Encountered An Error While Deleting'
                ];

        }else{

            /*
             * Post Doesn't Exist!
             * */

            return [
                'error'     => true,
                'message'   => 'Unable To Delete, Either This Post Does Not Exist Or You Are The Original Author Of This Post!'
            ];

        }

    }

    protected function processDeleteComment($commentId){

        /*
         * Process The Deletion A Comment By Logged In User
         * */

        $this->PostId = $commentId;

        $mComment = Comment::all()
                            ->where('comment_id', $this->PostId)
                            ->where('user_id', $this->LoggedInId);

        /*
         * Check If Comment Really Exists!
         * */

            if($mComment->count() == 1){

                /*
                 * Comment Really Exists!.
                 * Update The `type` & `comment_text`
                 * */
                return DB::table('comments')
                    ->where('comment_id', $this->PostId)
                    ->where('user_id', $this->LoggedInId)
                    ->update([
                        /*'comment_url'   => "",*/
                        /*'comment_text'  => "This Comment Has Been Deleted By The Author",*/
                        'comment_type'  => 'deleted'
                    ]) == 1 ? [
                        'error'     => false,
                        'deleted'   => true,
                        'message'   => 'Comment Deleted Successfully'
                ] : [
                    'error'     => true,
                    'deleted'   => false,
                    'message'   => 'Encountered An Error While Deleting Commnet'
                ];

            }else{

                /*
                 * Comment Doesn't Exist!
                 * */

                return [
                    'error'     => true,
                    'message'   => 'Comment Does Not Exist Or You Are Not Original Author Of This Comment!'
                ];

            }

    }

    public function buildCommenterUsersList(array $commenters){

        $response['error'] = false;
        $response['list']  = true;
        $response['message'] = "Users Found";

        foreach ($commenters as $user){

            $response['users'][] = [

                "user_info" => (new UserModelController)->buildUser((new Comment($user))->user_id)

            ];

        }

        return $response;

    }

    private function showBlocked($request){

        $mBlock = $request->has('last_id') ? Block::all()
                                                        ->where("blocker_id", $this->LoggedInId)
                                                        ->where("block_id", '<', $request->last_id)
                                                        ->take(20)
                                            : Block::all()
                                                        ->where("blocker_id", $this->LoggedInId)
                                                        ->take(20);
        $response = [];
        $response['error'] = true;
        $response['list']  = false;
        $response['message'] = "You Have Not Blocked Any Account Yet, All Accounts You Block You Appear Here";

        if($mBlock->count() == 0) return $response;

        $response['error'] = false;
        $response['list']  = true;
        $response['message'] = "Users You Have Blocked";

        foreach ($mBlock->toArray() as $block) {

            $response['users'][] = [

                "user_info" => (new UserModelController)->buildUser((new Block($block))->blocked_id)

            ];

        }

        return $response;

    }

    public function buildUserList(array $Users){

        $response['error'] = false;
        $response['list']  = true;
        $response['message'] = "Users Found";

        foreach ($Users as $user){

            $response['users'][] = [

                "user_info" => (new UserModelController)->buildUser((new Reaction($user))->liker_id)

            ];

        }

        return $response;

    }

}
