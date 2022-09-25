<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\UserCounter;
use App\Post;
use App\User;
use App\Stories;
use App\Chats;
use App\Messages;
use App\Events\ChatsEvent;
use App\Events\MessagesEvent;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{

    /*
     * User Id
     * */
    protected $LoggedId = 0;

    protected $filePath = "";

    protected $URL = '/storage/'; # http://192.168.43.13:8000

    protected $thumbnailVideoURL = '';

    protected $fileType = 'text';

    protected $UploadText = "";

    protected $date = "";
    protected $time = "";

    function __construct(){

        $this->LoggedId = auth()->check() ? auth()->user()->user_id : 0;

        $this->date = date_format(date_create(date('m/d/Y')), 'D, d M Y');
        $this->time = date("g:ia");

    }


    public function post(Request $request){

        /*
         * Validate The Request Incoming
         * */
        $validated = $this->validateRequest($request);

        /*
         * Validation Fail, Return An Error With Error Message
         * */
        if($validated['error']) return response()->json($validated);

        /*
         * Work File
         * */

        if($validated['hasFile']){

            /*return response()->json([
                'heelo' => 'heelo'
            ]);*/

            $results = $this->workFile($request->file('media'), 'post');

              if($results['error']) return response()->json($this->error('Unresolved Error Encountered. You Might Be Trying To Upload An Unsupported File, Are You?!'));

        }
        /*
         * Insert Post!
         * */

        $request->app_name = (!isset($request->app_name) || empty($request->app_name)) ? 'Tunepik Web' : $request->app_name;

        return response()->json($this->insertPost([
            'user_id'       => $this->LoggedId,
            'media_url'     => $this->getURL($this->filePath),
            'thumbnail_url' => $this->thumbnailVideoURL,
            'text'          => $this->UploadText,
            'media_date'    => $this->date,
            'media_time'    => $this->time,
            'type'          => $this->fileType,
            'app_name'      => $request->app_name,
            'shared_from_id'=> 0,
            'media_id'      => null
        ], 'post'));

    }

    public function share(Request $request, $sharedPostId){

        /*
         * Validate The Request Incoming
         * */
        $validated = $this->validateRequest($request);

        /*
         * Validation Fail, Return An Error With Error Message
         * */
        if($validated['error']) return response()->json($validated);

        /*
         * Validate Shared Post Id
         * Check If The Shared Post Exists!
         * */
        if(empty($sharedPostId)) return response()->json($this->error('No Post To Share!'));

        if(!preg_match("/[0-9]/", $sharedPostId)) return response()->json($this->error('Malformed URL'));

        if(!(Post::all()->where('media_id', $sharedPostId)->count() == 1)) return response()->json($this->error('Shared Post Does Not Exists, Try Sharing An Existig Post'));

        /*
         * Work File
         * */
        if($validated['hasFile']){

            $results = $this->workFile($request->media, 'post');

            if($results['error']) return response()->json($this->error('Unresolved Error Encountered. You Might Be Trying To Upload An Unsupported File, Are You?!'));

        }

        /*
         * Insert Post!
         * */
        return response()->json($this->insertPost([
            'user_id'       => $this->LoggedId,
            'media_url'     => $this->getURL($this->filePath),
            'thumbnail_url' => $this->thumbnailVideoURL,
            'text'          => $this->UploadText,
            'media_date'    => $this->date,
            'media_time'    => $this->time,
            'type'          => $this->fileType,
            'app_name'      => $request->app_name,
            'shared_from_id'=> $sharedPostId,
            'media_id'      => null
        ], 'share'));


    }

    public function comment(Request $request, $postId){

        /*
         * Validate The Request Incoming
         * */
        $validated = $this->validateRequest($request);

        /*
         * Validation Fail, Return An Error With Error Message
         * */
        if($validated['error']) return response()->json($validated);

        /*
         * Validate Post Id
         * Check If The Post Exists!
         * */
        if(empty($postId)) return $this->error('Provide The Post You Are Trying To Comment On');

        if(!preg_match('/[0-9]/', $postId)) return response()->json($this->error('Malformed URL'));

        if(!(Post::all()->where('media_id', $postId)->count() == 1)) return response()
                                                                ->json($this->error('Post You Are Trying To Comment On Does Not Exist'));

        /*
         * Good To Go To Comment On The Post
         * */

        return response()->json($this->insertComment([
            'user_id'       => $this->LoggedId,
            'post_id'       => $postId,
            'comment_text'  => $this->UploadText,
            'comment_url'   => $this->getURL($this->filePath),
            'thumbnail_url' => $this->thumbnailVideoURL,
            'comment_date'  => $this->date,
            'comment_time'  => $this->time,
            'comment_type'  => $this->fileType,
            'app_name'      => $request->app_name,
            'comment_id'    => null
        ]));

    }

    public function stories(Request $request){

        $validated = $this->validateRequest($request);

        if($validated['error']) return response()->json($validated);

        if($validated['hasFile']) $this->workFile($request->media, 'story');

        return response()->json($this->insertStory([
            'user_id'       => $this->LoggedId,
            'story_message' => $this->UploadText,
            'story_url'     => $this->getURL($this->filePath),
            'story_type'    => $this->fileType,
            'story_time'    => $this->time,
            'story_date'    => $this->date,
            'story_id'      => null
        ]));

    }

    public function profile(Request $request){

        /*
         * Validate The Request Incoming
         * */
        $validated = $this->validateRequest($request);

        /*
         * Validation Fail, Return An Error With Error Message
         * */
        if($validated['error']) return response()->json($validated);

        /*
         * Work File
         * */
        $this->workFile($request->media, 'profile');

        /*
         * Insert Profile Picture!
         * */
        return response()->json($this->insertUserPicture(
            [

           'user_id'        => $this->LoggedId,
           'image_text'     => "",
           'image_link'     => $this->getURL($this->filePath),
            'image_date'    => date_format(date_create(date('m/d/Y')), 'D, d M Y'),
            'image_time'    => date('g:ia'),
            'type'          => 'profile',
            'image_id'      => null

        ]

      ));

    }

    protected function cover(Request $request){

        /*
         * Validate The Request Incoming
         * */
        $validated = $this->validateRequest($request);

        /*
         * Validation Fail, Return An Error With Error Message
         * */
        if($validated['error']) return response()->json($validated);

        /*
         * Work File!!
         * */

        $this->workFile($request->media, 'cover');

        /*
         * Update Cover Of User!
         * */
        return response()->json($this->insertUserPicture(
            [

            'user_id'        => $this->LoggedId,
            'image_text'     => "",
            'image_link'     => $this->getURL($this->filePath),
            'image_date'    => date_format(date_create(date('m/d/Y')), 'D, d M Y'),
            'image_time'    => date('g:ia'),
            'type'          => 'cover',
            'image_id'      => null

        ]

      ));

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

    protected function insertPost(array $post, $type){

        $mPost = new Post($post);

        /*
         * Save The Post In The DB
         */
        if($mPost->save()) {

            /*
             * If The Post Was A Share Of Another Post
             * Add A Nofication To Alert The Original Owner That Their Post Has Just
             * Been Shared
             */
            if($type == 'share'){

                /*
                 * Create New Notifications Object!
                 */
                $mNotifications = new NotificationModelController();
                $mNotifications->addSharedPostNotification($mPost->media_id);

            }

            /*
             * Returned The Post/ Shared Post That Was Just Shared Right Now To Be Appended On
             * The View!
             */
            return [

                'error'     => false,
                'uploaded'  => true,
                'message'   => 'Post Published',
                'list'      => true,
                'shared'    => [
                    "list"      => true,
                    "posts"     => [(new PostModelController())->makePostModel($mPost)]

                ]

            ];

        }else{

            /*
             * On Error At Saving In The DB,
             * Return An ERROR Message
             */
            return $this->uploadError();

        }

    }

    protected function insertUserPicture(array $picture){

        /*
         * Get Images This User Already Has
         * */
        $hasImage = DB::table('profilepic')
                                    ->where('user_id', $this->LoggedId)
                                    ->where('type', $picture['type']);

        $mImage = new \App\Image($picture);

        /*
         * Check If User Already Has Images Stored
         * */
        if($hasImage->get()->count() == 0){

            /*
             * User Does Not Have An Image Of This Type.
             * You Can Proceed Uploading Picture
             * */
            return $mImage->save() ? $this->formatProfileImages($mImage) : $this->uploadError();

        }else{

            /*
             * User Does Have An Image Of This Type,
             * Delete This Image, Then Add Another One
             * */
            if($hasImage->delete()){

                return $mImage->save() ? $this->formatProfileImages($mImage) : $this->uploadError();

            }else{

                return $this->uploadError();

            }


        }



    }

    public function insertComment(array $Comment){

        $mComment = new Comment($Comment);

        if(($mComment->save())){

            $mNotifications = new NotificationModelController();

            $mNotifications->addCommentedNotification($Comment['user_id'], $Comment['post_id']);
            $mNotifications->addMentionedNotification($Comment['post_id'], 'Mentioned On A Comment');

            return [

                'error'     => false,
                'uploaded'  => true,
                'message'   => 'Comment Published',
                'shared'       => [

                    "count"     => Comment::all()->where('post_id', $Comment['post_id'])->count(),

                    "comments"  => (new CommentModelController())->makeCommentModel($mComment)

                ]

            ];

        }else{

            return [

                'error'     => true,
                'uploaded'  => false,
                'message'   => 'Encountered An Error While Publishing Your Comment'

            ];

        }

    }

    public function insertStory(array $story){

        $mStory = new Stories($story);

        if($mStory->save()){

            return [
                'error'     => false,
                'uploaded'  => true,
                'message'   => 'Story Uploaded',
                'story'     => (new StoriesModelController())->modelStory($mStory)
            ];

        }else{

            return [
                'error'     => true,
                'uploaded'  => false,
                'message'   => 'Story Upload Unsuccessful',
                'story'     => []
            ];

        }

    }

    public function message(Request $request, $id){

        if(empty($id)) return response()->json($this->error('Invalid Request'));

        if(!preg_match("/[0-9]/", $id)) return response()->json($this->error('Invalid Request'));

        $mUser = User::all()
                            ->where('user_id', $id);

        if($mUser->count() == 0) return response()->json($this->error('User Does Not Exist'));

        /*
         * Validate The Request Incoming
         * */
        $validated = $this->validateRequest($request);

        /*
         * Validation Fail, Return An Error With Error Message
         * */
        if($validated['error']) return response()->json($validated);

        /*
         * Work File
         * */

        if($validated['hasFile']){

            /*return response()->json([
                'heelo' => 'heelo'
            ]);*/

            $results = $this->workFile($request->file('media'), 'message');

              if($results['error']) return response()->json($this->error('Unresolved Error Encountered. You Might Be Trying To Upload An Unsupported File, Are You?!'));

        }

        return response()->json($this->sendMessage([

            'user_id_one'       => $this->LoggedId,
            'user_id_two'       => $id,
            'last_msg'          => $request->text,
            'type'              => $this->fileType,
            'seen'              => 0,
            'chat_date'         =>date_format(date_create(date('m/d/Y')), 'D, d M Y'),
            'chat_time'         =>date("g:ia"),
            'chat_id'           => null

        ]));

    }

    protected function sendMessage(array $chat){

        $mChat = new Chats($chat);

        $findChats = DB::table('chats')
                        ->where('user_id_one', $mChat->user_id_one)
                        ->where('user_id_two', $mChat->user_id_two)
                        ->orWhere('user_id_one', $mChat->user_id_two)
                        ->where('user_id_two', $mChat->user_id_one);

        if($findChats->get()->count() == 1){

            return $findChats->delete() == 1 ? $this->saveChat($mChat) : [

                'error'     => true,
                'message'   => 'E_1 : Unable To Send Text, Try Again Later'

            ];

        }else{

            return $this->saveChat($mChat);

        }


    }

    protected function saveChat(Chats $chat){

        if($chat->save()){

            /*event(new ChatsEvent($chat->user_id_two));*/

            return $this->saveMessage(
                new Messages([

                            'user_id_one'       => $chat->user_id_one,
                            'user_id_two'       => $chat->user_id_two,
                            'message'           => $chat->last_msg,
                            'url'               => $this->getURL($this->filePath),
                            'type'              => $this->fileType,
                            'msg_date'          => date_format(date_create(date('m/d/Y')), 'D, d M Y'),
                            'msg_time'          => date("g:ia"),
                            'seen'              => $chat->seen,
                            'msg_id'            => null

                ])
            );



        }else{

            return [
                'error'     => true,
                'message'   => 'Unable To Send Text, Try Again Later'
            ];

        }

    }

    protected function saveMessage(Messages $message){

        if($message->save()){

           /* event(new UserCounter(auth()->user()));

            event(new MessagesEvent($message->user_id_two, $message->user_id_one));*/

            $mMessages = DB::table('messages')
                                        ->where('user_id_one', $this->LoggedId)
                                        ->where('seen', 0)
                                        ->orWhere('user_id_two', $this->LoggedId)
                                        ->where('seen', 0)
                                        ->get();
            $newMessage = [];

            foreach($mMessages as $text){

                $newMessage[] = (new ChatsModelController)->buildMessages($text);

            }


            return [
                'error'      => false,
                'message'    => 'Message Sent',
                'chats'      => $newMessage
            ];

        }else{

            return [
                'error'     => true,
                'message'   => 'Unable To Send Message, Try Again Later'
            ];

        }

    }


    protected function formatProfileImages(\App\Image $img){

        return [

            'error'     => false,
            'type'      => $img->type,
            'message'   => "Upload Successful",
            'url'       => $img->image_link,

        ];

    }

    protected function createThumb(UploadedFile $file, string $fileName, int $size){

        $file->filename = "thumb_{$fileName}";

        $thumbPath = $file->store('uploads/thumbs', 'public');

        Image::make(public_path("storage/{$thumbPath}"))->fit($size, $size)->save();

    }

    protected function fullImage(UploadedFile $file, string $fileName, int $size = null){

        $this->filePath = $file->store('uploads/images', 'public');

        if($size != null){

            Image::make(public_path("storage/{$this->filePath}"))
                                                                    ->fit($size)
                                                                    ->save();
            return 0;
        }

        Image::make(public_path("storage/{$this->filePath}"))->save();

    }

    protected function workFile(UploadedFile $file, $where){

        if(!$file->isFile()) return ['hasFile' => false, 'error' => false];

        $file->filename = md5(date("d/m/Y g:ia")).auth('api')->user()->user_athandle.$file->getFilename();

        switch (strtolower($file->getMimeType())){

            case 'image/jpeg'   :
            case 'image/png'    :
            case 'image/jpg'    :
            case 'image/gif'    :



                    $this->fileType = 'image';

                    switch ($where){

                        case 'post'     :
                        case 'comment'  :
                        case 'share'    :
                        case 'message'  :
                        case 'story'    :

                              $this->createThumb($file, $file->filename, 601);
                              $this->fullImage($file, $file->filename, 1200);

                             break;

                        case 'profile'  :

                             $this->createThumb($file, $file->filename, 80);
                             $this->fullImage($file, $file->filename, 80);

                             break;

                        case 'cover'    :

                            $this->filePath = $file->store('uploads/cover', 'public');
                            Image::make(public_path("storage/{$this->filePath}"))->fit(800, 400);

                            break;

                        default         :

                            return $this->error("Unresolved Section");
                    }

                break;

                /*
                 * Handling Of Video Files
                 */
            case 'video/mp4'    :
            case 'video/mkv'    :

                $this->filePath = $file->store('uploads/videos', 'public');
                $this->fileType = 'video';

                $this->createVideoThumbnail($file->getFilename());

                break;

                /*
                 * Handling Of Audio Files
                 */
            case 'audio/x-wav'  :
            case 'application/x-font-gdos' :
            case 'audio/wav'    :
            case 'audio/mp3'    :
            case 'audio/m4a'    :
            case 'audio/mpeg'   :

                $this->filePath = $file->store('uploads/audios', 'public');
                $this->fileType = 'audio';

                break;
            default             :

                // echo $file->getMimeType();
                return $this->error("Unresolved File");

        }

        return [
            'error' => false,
            'hasFile' => $file->isFile()
        ];

    }

    protected function createVideoThumbnail($filename){

        $thumbNail = new \Pawlox\VideoThumbnail\VideoThumbnail();

        $this->thumbnailVideoURL = $this->URL."videos/thumbnails/{$filename}";

        $thumbNail->createThumbnail(public_path("storage/{$this->filePath}"), public_path("storage/videos/thumbnails"), $filename, 4);

    }

    protected function uploadError(){

        return [

            'error'     => false,
            'uploaded'  => false,
            'message'   => 'Upload Failed'

        ];

    }

    protected function validateRequest(Request $req){

        $this->setId();

        if($this->LoggedId == 0) return $this->error('Unauthorized Request');

        if(!$req->has([

            'text',
            'media'

        ])) return $this->error('Incomplete Request');

        if(empty($req->text) && empty($req->media)) return $this->error('How You Tryna Upload An Empty Post');

        $this->UploadText = empty($req->text) ? "" : $req->text;

        return [

            'error'     => false,
            'hasFile'   => $req->hasFile('media')

        ];

    }

    protected function getURL($url){

        /*
         * Can Also Check If File Exists!!
         * */

        /*
         * If URL Is Empty, Return An Empty String

         * */
        return empty($url) ? "" : $this->URL.$url;

    }

    protected function error($e){

        /*
         * Error Function To Handle To All Generic Errors
         * */
        return [
            'error' => true,
            'message' => $e
        ];

    }

    protected function setId(){

        /*
         * Error To Authenticate User!
         * */
        $this->LoggedId = (new AuthController)->authenticate();

    }


}
