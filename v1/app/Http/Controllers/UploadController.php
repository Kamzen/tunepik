<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{

    /*
     * User Id
     * */
    protected $LoggedId = 0;

    protected $filePath = "";

    protected $URL = 'http://192.168.43.13:8000/storage/';

    protected $fileType = 'text';

    protected $UploadText = "";


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
        return response()->json($this->insertPost([
            'user_id'       => $this->LoggedId,
            'media_url'     => $this->getURL($this->filePath),
            'text'          => $this->UploadText,
            'media_date'    => date_format(date_create(date('m/d/Y')), 'D, d M Y'),
            'media_time'    => date('g:ia'),
            'type'          => $this->fileType,
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
            'text'          => $this->UploadText,
            'media_date'    => date_format(date_create(date('m/d/Y')), 'D, d M Y'),
            'media_time'    => date('g:ia'),
            'type'          => $this->fileType,
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
            'comment_date'  => date_format(date_create(date('m/d/Y')), 'D, d M Y'),
            'comment_time'  => date('g:ia'),
            'comment_type'  => $this->fileType,
            'comment_id'    => null
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
        $hasImage = \App\Image::all()
                                    ->where('user_id', $this->LoggedId)
                                    ->where('type', $picture['type']);

        $mImage = new \App\Image($picture);

        /*
         * Check If User Already Has Images Stored
         * */
        if($hasImage->count() == 0){

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
            if($hasImage->find($this->LoggedId)->delete()){

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

    protected function formatProfileImages(\App\Image $img){

        return [

            'error'     => false,
            'type'      => $img->type,
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
