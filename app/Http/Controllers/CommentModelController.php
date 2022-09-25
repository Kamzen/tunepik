<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Reaction;

class CommentModelController extends Controller
{
    /*
     * User Ids
     * */
    protected $UserId = 0;
    protected $LoggedInId = 0;

    /*
     * Class Vars
     * */
    protected $PostId = 0;
    protected $CommentId = 0;

    public function view(){

        return response()->json($this->commentPage());

    }

    public function viewComments($postId){

        $this->setIds();

        if(empty($postId)) return $this->error('Incomplete Request');

        if(!preg_match("/[0-9]/", $postId)) return $this->error('Invalid Request');
        /*
         * Check If Post Exists!
         * */

         if(!Post::all()->where('media_id', $postId)->count() == 1) return $this->error('This Post Does Not Exist Longer Exists!');

        /*
         * Get All Comments!
         * */
        $mComments = Comment::all()->where('post_id', $postId);

        /*
         * Check If Post Has Comments, If Not Return
         * */
        if($mComments->count() == 0) return response()->json([
            'error'     => false,
            'list'      => false,
            'message'   => 'No Comments, Be There First To Add A Comment!'
        ]);

        return response()->json($this->buildList($mComments->toArray()));

    }

    public function single($commentId){

        if(empty($commentId)) return $this->error('Incomplete Request!');

        if(!preg_match("/[0-9]/", $commentId)) return $this->error('Invalid Request');

        $mComment = Comment::all()->where('comment_id', $commentId);

        if(!$mComment->count() == 1) return $this->error('This Comment Does Not Exist!');

        return response()->json($this->buildList($mComment->toArray()));

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

    public function setIds($id = null){

        /*
         * Check If User Making Requests Is Authenticated Or Not!
         * */
        $this->LoggedInId = (new AuthController())->authenticate();

        $this->UserId = $id;

    }

    public function error($e){

        /*
         * To Catch And Report All Generic Errors
         * */
        return response()->json([
            'error'     => true,
            'message'   => $e
        ]);

    }

    protected function buildList(array $Comments){

        $response['list']       = true;
        $response['message']    = 'Comments For This Post Found!';
        $response['count']      = count($Comments);
        $response['error']      = false;

            foreach ($Comments as $comment){

                $response['comments'][] = $this->makeCommentModel(new Comment($comment));

            }

        return $response;

    }

    public function makeCommentModel($mComment){

        /*
         * Model Individual Comment Data Dynamically
         * */
        return [

            /*
             * User Data Of Person Who Made The Comment
             * */
            'user_info'     => (new UserModelController)->buildUser($mComment->user_id),

            /*
             * Actual Data Of The Comment
             * */
            'comment_info' => [

                'user_id'       => $mComment->user_id,
                'post_id'       => $mComment->post_id,
                'comment_text'  => $mComment->comment_text,
                'comment_url'   => $mComment->comment_url,
                'thumbnail_url' => $mComment->thumbnail_url,
                'comment_time'  => $mComment->comment_time,
                'comment_date'  => $mComment->comment_date,
                'now'           => TunepikUtilController::timeDifference($mComment->comment_date, $mComment->comment_time),
                'comment_type'  => $mComment->comment_type,
                'app_name'      => $mComment->app_name,
                'comment_id'    => $mComment->comment_id

            ],

            /*
             * Comment Stats
             * */
            'likesCount'    => Reaction::all()
                                            ->where('post_id', $mComment->comment_id)
                                            ->where('type', 'comment')
                                            ->count(),

            'isLiked'       => Reaction::all()
                                            ->where('post_id', $mComment->comment_id)
                                            ->where('type', 'comment')
                                            ->where('user_id', $this->LoggedInId)
                                            ->count() == 1

        ];

    }

    protected function commentPage(){

        return [

            "page" => '

    <div class="row" style="">
       <div class="col-lg-8 post-viewport-wrapper-lg" style="">

         <div class="app-comment-header app-header visible-xs darkmode-wrapper" style="height:49px;border-bottom:.05em solid lightgrey;">
           <div class="space-small visible-xs"></div>

           &nbsp;&nbsp;<a class="app-modal-xs-btn"></a>
           &nbsp;&nbsp;<span class="app-max-text" style="position:relative;top:-5px">Full Post</span>

         </div>

         <div class="space-large visible-xs"></div>
         <br class="visible-xs" />

         <div class="post-viewport">
          <a class="app-modal-lg-btn visible-lg">
           </a>
         </div>

       </div>
       <div class="col-lg-4 comments-viewport-main darkmode-wrapper">
        <div class="app-comment-header-fixed">
         <div class="visible-lg app-post-owner-header"></div>
         <div class="app-write-comment-viewport darkmode-wrapper">

           <div class="media">
              <div class="media-left pull-left" style="padding-left:15px;">
                 <center>
                    <a class="comment-remove"></a>
                 </center>
              </div>
              <div class="media-body">
                 <div class="comment-audio-viewport">
                 </div>
                 <center>
                   <span class="img-choose-text app-grey-text-lg"></span>
                 </center>
              </div>
           </div>

         <div class="app-input-wrapper comment-control-input">
          <div class="app-input-wrapper-inner">
           <form class="form-group">

           <div class="input-group input-group-md">

              <span class="input-group-addon">
                <label for="media">
                  <span class="input-file-icon"></span>
                </label>
              </span>
              <a class="input-group-addon input-record-icon">

              </a>

              <textarea type="text" class="comment-input-text app-input-field" placeholder="Reply"></textarea>

              <a class="input-group-addon input-send-icon">

              </a>
           </div>

        </form>
        </div>
         </div>

       </div>
       <div class="space-small"></div>
         <!--<div class="comments-view-header" style="">
           <div class="" style="padding: 1%;">

              <center>
                 <span class="app-bold-text">Comments</span>
              </center>

           </div>
           <div class="space-small"></div>
         </div>-->
       </div>
         <div class="comments-viewport"></div>


       </div>
       <div class="visible-xs space-large"></div>
       <div class="visible-xs space-large"></div>
       <div class="visible-lg space-large"></div>



    </div>

    ',


    "error" => false

        ];


    }

}
