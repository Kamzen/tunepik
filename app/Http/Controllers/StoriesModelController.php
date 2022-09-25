<?php

namespace App\Http\Controllers;

use App\Stories;
use Illuminate\Http\Request;

class StoriesModelController extends Controller
{
    private $id;
    function __construct()
    {
        $this->id = TunepikUtilController::id();
    }

    public function stories(Request $request){

        $Stories = $request->has('last_id') ? Stories::all()
            ->sortByDesc('media_id')
            ->where('media_id', '<', $request->last_id)
            ->take(20)
            :
            Stories::all()
                ->sortByDesc('media_id')
                ->take(20);

        if($Stories->count() == 0) return TunepikUtilController::error("No Stories At The Moment");

        return response()->json($this->buildStoriesFeed($Stories->toArray()));

    }

    public function userStories(Request $request, $id){

        $Stories = $request->has('last_id') ? Stories::all()
            ->sortByDesc('media_id')
            ->where('user_id', $id)
            ->where('media_id', '<', $request->last_id)
            ->take(20)
            :
            Stories::all()
                ->where('user_id', $id)
                ->sortByDesc('media_id')
                ->take(20);

        if($Stories->count() == 0) return TunepikUtilController::error("No Stories At The Moment");

        return response()->json($this->buildStoriesFeed($Stories->toArray()));

    }

    public function storyViewers(Request $request, $storyId){

    }

    private function buildStoriesFeed(array $stories){

        $response['message'] = 'Stories Available';
        $response['error']   = false;

        foreach ($stories as $story){

            $response['stories'][] = $this->modelStory(new Stories($story));

        }

        return $response;

    }

    public function modelStory(Stories $story){

        return [

            "user"      => (new UserModelController())->buildUser($story->user_id),
            "story"     => [

                "user_id"       => $story->user_id,
                "story_id"      => $story->story_id,
                "story_message" => $story->story_message,
                "story_url"     => $story->story_url,
                "story_type"    => $story->story_type,
                "story_date"    => $story->story_date,
                "story_time"    => $story->story_time,
                "now"           => TunepikUtilController::timeDifference($story->story_date, $story->story_time),

            ],
            "view_count"=> 0,  // Count Of All Users Who Viewed This Story

        ];

    }
}
