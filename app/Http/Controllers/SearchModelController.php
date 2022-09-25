<?php

namespace App\Http\Controllers;

use App\Post;
use App\Trending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchModelController extends Controller
{

    protected $UserId = 0;
    protected $Logged = 0;

    protected $searchQuery = '';

    /**
     * SearchModelController constructor.
     */
    public function search(Request $mRequest){

        /**
         * Validate The Request
         * */
        if(!$mRequest->has('q')) return $this->error('Incomplete Search Query');

        if(empty($mRequest->q)) return response()->json([
            'error'         => true,
            'users'         => false,
            'hashtags'      => false,
            'words_used'    => false,
            'message'       => 'No Results For Empty Search Query'
        ]);

            /**                      **
             * Implement Using Switch *
             * */                  /**/

        /**
         * Remove Leading Characters On Search Queries
         * */
        if(substr($mRequest->q, 0, 1) == '@'){

            $this->searchQuery = substr($mRequest->q, 1);

            /**
             * Implement Search Users Only
             * */
            $response = [

                'error'       => false,
                'users'       => $this->searchUsers($this->searchQuery),
                'hashtags'    => $this->searchTags($this->searchQuery),
                'words_used'  => [ 'found' => false, 'words' => false ]

            ];

            /**
             * End Everything Here!
             * Return All Modelled Data As Response
             * */
            return response()->json($response);

        }else if(substr($mRequest->q, 0, 1) == '#'){

            $this->searchQuery = substr($mRequest->q, 1);

            /**
             * Implement Search Hashtags Only
             * */
            $response = [

                'error'       => false,
                'users'       => [ 'found' => false, 'users' => false ],
                'hashtags'    => $this->searchTags($this->searchQuery),
                'words_used'  => $this->searchWords($this->searchQuery)

            ];

            return response()->json($response);

        }else{

            /**
             * Just Set The searchQuery!
             * */
            $this->searchQuery = $mRequest->q;

        }

        /**
         * General Search Will Happen Here If The User Has Not Specified Any Leading Characters To Show Context Of Search
         *
         * e.g '@Madd' This Search Query Will Only Search For Users
         *     '#Madd' This Search Query Will Only Search For Hashtags
         *     'Madd' This Seach Query Will Search For Users, Hashtags, And Posts That Have That Word!
         * */

          $response = [
              'error'       => false,
              'users'       => $this->searchUsers($this->searchQuery),
              'hashtags'    => $this->searchTags($this->searchQuery),
              'words_used'  => $this->searchWords($this->searchQuery)

          ];

        /**
         * Return The Request Response
         * */
        return response()->json($response);

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

    protected function setIds($id = null){

        $this->UserId = $id;
        $this->Logged = (new AuthController)->authenticate();

    }

    public function error($e){

        return response()->json([
            'error'     => true,
            'message'   => $e
        ]);

    }

    /**
     * @param string $word
     * @return array
     */
    protected function searchWords(string $word){

        /**
         * Search For The Word In Posts Posted By Users
         * */
        $Posts = DB::table("mediauploads")
                            ->where('text', 'like', "%{$word}%");

        /**
         * Check If The Word/Term Was Found/Mentioned In Any Posts
         * */
        if($Posts->count() == 0) return [
                                            'found'     => false,
                                            'words'     => false,
                                            'message'   => "'{$word}' Not Found In Any Posts"

                                        ];

        $response['found']  = true;
        $response['words']  = true;

            /**
             * Model The Data Returned!
             * */
            $response['list']  = [
                                    'term'      => $word,
                                    'count'     => $Posts->count(),
                                    'message'   => "Found {$word} In {$Posts->count()} Conversations"
                                 ];

        /**
         * Return The Data As Response
         * */
        return $response;

    }

    /**
     * @param string $tag
     * @return array
     */
    protected function searchTags(string $tag): array {

        /**
         * Get All Tags That Start Like $tag That Is Being Searched For
         * */
        $Hashes = DB::table("trending")/*Trending::all*/
                                ->where('trend', 'like', "{$tag}%")->get();

        /**
         * Check If Hash Tag Has Been Used In Posts
         * */
        if($Hashes->count() == 0) return [
                                            'found'     => false,
                                            'hashes'    => false,
                                            'message'   => 'Found In 0 Conversations'
                                         ];

        /*
         * Convert $Hashes Collection To Array
         * */
        $Hashes = $Hashes->toArray();

        $response['found']      = true;
        $response['hashes']     = true;
        $response['message']    = '{$tag} found in conversations';

        /**
         * Iterate Through All Hashtags Found!
         * */
        foreach ($Hashes as $hash){

            /**
             * Find How Many Times Has The Hashtag Been Used!
             * */
            $count = DB::table("mediauploads")
                                ->where('text', 'like', "#{$hash->trend}%")
                                ->get()
                                ->count();

            /**
             * Model The Data Returned By The API
             * */
            $response['trends'][] = [

                                    'trend_hash'      => "{$hash->trend}",
                                    'trend_count'     => $count,
                                    'message'         => "Found In {$count} Conversations"

                                    ];

        }

        /**
         * Return The Modelled Data!
         * */
        return $response;

    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function searchUsers(string $name){

        /**
         * Search Users
         * */
        $mUsers = DB::table('users')
                                ->where('user_athandle', 'like', "{$name}%")
                                ->orWhere('user_name', 'like', "{$name}%")
                                ->get();

        /**
         * Check If Users Results Where Returned!
         * */
        if($mUsers->count() == 0) return [

            'found'      => false,
            'users'      => false,
            'message'    => "Results For '{$name}' Were Not Found"

        ];

        /**
         * Turn mUsers Collection To Array $Users
         * */
        $Users = $mUsers->toArray();

       $response['found']   = true;
       $response['users']   = true;
       $response['message'] = "Results For '{$name}'";

       /**
        * Iterate Through The Array
        * */
       foreach ($Users as $user){

           /**
            * Return The Users In A Unified Modelled Way!
            * */
           $response['list'][] = (new UserModelController())->buildUser($user->user_id, 'api');

       }

       /**
        * Return The Response
        * */
       return $response;

    }

}
