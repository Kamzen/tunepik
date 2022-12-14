<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Reaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostModelController extends Controller
{
    protected $PostModel = null;
    protected $mResponse = [
        'error'   => false,
        'list'    => false,
        'message' => 'No Posts Found'
    ];
    protected $LoggedId = 0;

    public function __construct()
    {
        $this->LoggedInId();
    }

    protected function LoggedInId(){

        $this->LoggedId = (new AuthController)->authenticate();

    }

    public function error($e){

        return response()->json([
            'error'     => true,
            'message'   => $e
        ]);

    }

    /**
     * @param Request $mRequest
     * @return \Illuminate\Http\JsonResponse
     *
     * Get Posts For The Main Feed!
     * Should Only Show Posts Of The Users A LoggedIn User Follows!
     *
     */
    public function feed(Request $mRequest){

        $this->LoggedInId();

        /**
         * Get Posts
         * */
        $Posts = $mRequest->has('last_id') ? Post::all()
            ->sortByDesc('media_id')
            ->where('media_id', '<', $mRequest->last_id)
            ->take(20)
            ->toArray()
            :
            Post::all()
            ->sortByDesc('media_id')
            ->take(20)
            ->toArray();

        /**
         * Check If There Are Posts
         * */
        if(count($Posts) == 0) return response()->json($this->mResponse);

        return response()->json($this->makeResponse($Posts));

    }

    /**
     * @param Request $mRequest
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     *
     * Get Posts That Belong To A Certain User Only
     *
     */
    public function user(Request $mRequest, $userId){

        /**
         * Validate The Request!
         * */
        if(empty($userId)) return $this->error('Incomplete Request!');

        if(!preg_match("/[0-9]/", $userId)) return $this->error('Invalid URL');

        /**
         * Check If User Exists!
         * */
        $user = User::all()->where('user_id', $userId);
        if($user->count() != 1) return $this->error('This User Does Not Exist');

        /**
         * Get All Users' Posts
         * */
        $Posts = $mRequest->has('last_id') ? Post::all()
            ->sortByDesc('media_id')
            ->where('user_id', $userId)
            ->where('media_id', '<', $mRequest->last_id)
            ->take(20)
            :
            Post::all()
            ->sortByDesc('media_id')
            ->where('user_id', $userId)
            ->take(20);

        $this->mResponse['message'] = "@{$user->first()->user_athandle} Has Not Posted Anything!";
        if($Posts->count() == 0) return response()->json($this->mResponse);

        $this->LoggedInId();

        return response()->json($this->makeResponse($Posts->toArray()));

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * Get A Single Post Only
     */
    public function single($id){

        /**
         * Validate The Request!
         * */
        if(empty($id)) return $this->error('Incomplete Request');

        if(!preg_match("/[0-9]/", $id)) return $this->error('Invalid Url');

        /**
         * Get The Post To Check For Existence
         * */
        $Post = Post::all()->where('media_id', $id);

        $this->mResponse['message'] = 'This Post Does Not Exist';
        if($Post->count() != 1) return response()->json($this->mResponse);

        $this->LoggedInId();

        return response()->json($this->makeResponse($Post->toArray()));

    }


    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     *
     * Get All Posts A Certain User Has Liked
     *
     */
    public function liked($userId){

        /**
         * Validate $userId
         * */
        if(empty($userId)) return $this->error('Incomplete Request');

        if(!preg_match("/[0-9]/", $userId)) return $this->error('Invalid Request');

        /**
         * Check If User Exists!
         * */
        $user = User::all()->where('user_id', $userId);
        if($user->count() != 1) return $this->error('This User Does Not Exist');

        /**
         * Get Posts That The User Has Liked
         * */
        $reaction = Reaction::all()
                                ->where('liker_id', $userId)
                                ->where('type', 'post');

        /**
         * Check If User Has Already Liked Posts!
         * */
        $this->mResponse['message'] = "@{$user->first()->user_athandle} Has Not Liked Any Post";

        if($reaction->count() == 0) return response()->json($this->mResponse);

        /**
         * Return The Modelled Data As Response!
         * */
        return response()->json($this->buildFromReactions($reaction->toArray()));

    } // To Implement!

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Get Posts That A User Has To Discover!.
     * Does Not Have To Follow Those Users!
     *
     */
    public function discover(Request $request){

        /**
         * Check If Theres A Last ID
         * If Its There, Collect Posts Less Than That Id
         * Its For Infinity Scroll!
         * */
        $Posts = $request->has('last_id') ? Post::all()
                    ->sortByDesc('media_id')
                    ->where('media_id', '<', $request->last_id)
                    ->where('type', 'image')
                    ->take(20)
            :
            Post::all()
                ->sortByDesc('media_id')
                ->where('type', 'image')
                ->take(20);

        /**
         * Check If There Are Posts To Show!
         * */
        if($Posts->count() == 0) return response()->json($this->mResponse);

        /**
         * Return The All Posts Data Model!
         * */
        return response()->json($this->makeResponse($Posts->toArray()));

    }

    public function makeResponse(array $Posts){

        /**
         * Model The Whole Data Model That Would Be Requested
         * */
        $this->mResponse['list'] = true;
        $this->mResponse['message'] = 'Posts Available';

        foreach ($Posts as $post){

            /**
             * Posts Data Is Pushed Inside 'post' Index
             * */
            $this->mResponse['posts'][] = $this->makePostModel(new Post($post));

        }

        /**
         * The Entire Data Payload That Is Requested Is Returned
         * */
        return $this->mResponse;

    }


    public function buildFromReactions(array $reactions){

        $this->mResponse['list']    = true;
        $this->mResponse['message'] = 'Posts Available';
        $this->mResponse['error']   = false;

        /**
         * Get Posts Models Of The Posts Liked In Reactions := $reactions
         * */
        foreach ($reactions as $reaction){

            /**
             * Get The Individual Posts By Id
             * */
            $mpost = Post::all()
                            ->where('media_id', (new Reaction($reaction))->post_id)
                            ->first();

            $this->mResponse['posts'][] = $this->makePostModel($mpost);

        }

        /**
         * Return The Modelled Data In $this->mResponse
         * */
        return $this->mResponse;

    }

    public function getSinglePost($id){

        $mPost = Post::all()->where('media_id', $id);

        if($mPost->count() == 0) return [];

        return $this->makePostModel($mPost->first());

    }

    public function makePostModel(Post $mPost){

        /**
         * Model Individual Posts Dynamically According To :mPost Object Passed As Argument To The Method
         * */
        return [

            /**
             * Data About The User Related To This Post
             * */
            'user' => (new UserModelController)->buildUser($mPost->user_id),

            /**
             * Data About The Post That Is Being Modelled
             * */
            'post' => [
                'user_id'        => $mPost->user_id,
                'media_url'      => $mPost->media_url,
                'text'           => $mPost->text,
                'media_date'     => $mPost->media_date,
                'media_time'     => $mPost->media_time,
                'type'           => $mPost->type,
                'shared_from_id' => $mPost->shared_from_id,
                'media_id'       => $mPost->media_id
            ],

            /**
             * Find Out If This Post Original Or Was Just Shared
             * */
            'is_original_post' => $mPost->shared_from_id == 0,
            'original_post'    => $this->getOriginalPost($mPost->shared_from_id),

            /**
             * Post Statistics
             * */
            'likesCount'       => Reaction::all()
                                                ->where('post_id', $mPost->media_id)
                                                ->where('type', 'post')
                                                ->count(),
            'commentCount'         => DB::table('comments')
                                                ->select('comment_id')
                                                ->where('post_id', $mPost->media_id)
                                                ->count(),
            'isLiked'          => Reaction::all()
                                                ->where('liker_id', $this->LoggedId)
                                                ->where('post_id', $mPost->media_id)
                                                ->where('type', 'post')
                                                ->count() == 1,

            /**
             * Get Atleast One Comment Associated With This Post If It Exists
             * */
            'comments' => $this->getSingleAssociatedComment($mPost->media_id) // Will Implement It After Implementing CommentModelController class.
        ];

    }

    protected function getSingleAssociatedComment($postId){

        /**
         * Get All Post Related Associated With This Post
         * */
        $mComment = Comment::all()->where('post_id', $postId);

        /**
         * Local Response Variable
         * */
        $response = [];

        /**
         * Check If There Are Comments For This Post To Start With
         * */
        if($mComment->count() == 0){

            /**
             * There Are No Comments!
             * */
            $response['list'] = false;

        }else{

            /**
             * There Are Comments
             * */
            $response = (new CommentModelController)->makeCommentModel($mComment->random(1)->first());
            $response['list'] = true;

        }

        /**
         * Return The Local Variable
         * */
        return $response;

    }

    protected function getOriginalPost($postId){

        /**
         * If :$postId == 0 Means This Post Is Original, Return An Empty Array
         * */
        if($postId == 0) return [];

        /**
         *  :$postId != 0, This Post Is A Shared Post, Return That Shared Posts!
         *
         *  :$Post Should Be Instance Of Post:: Rather Than Casting The Instance To Array Should Use ->first()
         * */
        $Post = (array) Post::all()->where('media_id', '=', $postId)->take(1)->toArray();

        /**
         * I Don't Know Why I Implemented This Like This, Will Have To Find A Re-Do More Efficiently.
         * */
        foreach ($Post as $thisPost){ return $this->makePostModel(new Post($thisPost)); }

    }

}
