<?php

namespace App\Http\Controllers;

use App\ProfileVisit;
use App\Track;
use App\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ErrandsModelController extends Controller
{
    //
    protected $loggedInId = 0;

    public function __construct()
    {
        $this->loggedInId = (new AuthController())->authenticate();
    }

    /**
     * @param $userId := Belongs To The Person Whose Profile Is Being Visited!
     */
    public function addProfileVisits($userId){

        /**
         * Validate @param $userId
         * */
        if(empty($userId)) return \response()->json([
            'error'  => true,
            'message'=> 'Invalid Request'
        ]);

        if(!preg_match("/[0-9]/", $userId)) return \response()->json([
            'error'     => true,
            'message'   => 'Malformed URL'
        ]);

        /**
         * Check If User Exists
         * */
        if(User::all()
                    ->where('user_id', $userId)
                    ->count() != 1) return \response()->json([
                        'error'     => true,
                        'message'   => 'User Does Not Exist'
        ]);

        return response()->json($this->profileVisitHelper($userId, null));

    }

    public function addTrack(Request $request){

        if(!$request->has([
            'screen_size', 'place'
        ])) return $this->error('Failed To Track');

        return response()->json($this->addTrackerHelper([
            'ip'       => $request->ip(),
            'place'    => $request->place,
            'referer'  => $request->headers->has('referer') ? $request->headers->get('referer') : ''
        ]));

    }

    public function addTrackerHelper(array $crumbs, string $guard = null){

        $this->loggedInId = (new AuthController())->authenticate($guard);

        $mAgent = new Agent();

        $tracker = [
                'ip_address'        => $crumbs['ip'],
                'user_id'           => $this->loggedInId,
                'platform'          => $mAgent->platform(),
                'device'            => $mAgent->device(),
                'track_time'        => date('g:ia'),
                'track_date'        => date_format(date_create(date('m/d/Y')), 'D, d M Y'),
                'track_screen'      => $mAgent->isMobile() ? 'Mobile' : 'Desktop',
                'track_status'      => $this->loggedInId == 0 ? 'Offline' : 'Online',
                'track_place'       => $crumbs['place'],
                'referer'           => $crumbs['referer'],
                'browser'           => $mAgent->browser()
            ];

        $mTracker = new Track($tracker);

        return $mTracker->save() ? [
            'error'     => false,
            'message'   => 'tracked'
        ] : [
            'error'     => true,
            'message'   => 'failed'
        ];

    }

    public function profileVisitHelper($userId, $guard = null){

        $this->loggedInId = (new AuthController())->authenticate($guard);

        if($this->loggedInId == 0) return [
            'error'     => false,
            'logged'    => false,
            'message'   => 'Login As A User First'
        ];

        /**
         * Check For Self-Visitations
         * */
        if($this->loggedInId == $userId) return [
            'error'  => false,
            'logged' => false,
            'message'=> 'You Are Visiting Your Own Profile'
        ];

        /**
         * Create New Visit Model
         * */
        $mProfileVisit = new ProfileVisit([
            'visitor_id'        => $this->loggedInId,
            'user_id'           => $userId,
            'visit_date'        => date_format(date_create(date("m/d/Y")), "D, d M Y"),
            'visit_time'        => date("g:ia"),
            'visit_id'          => null
        ]);

        /**
         * Save Visitation
         * */
        $mProfileVisit->save() ? [
            'error'     => false,
            'logged'    => true,
            'message'   => 'Profile Visit Logged'
        ] :
            [
                'error'     => true,
                'logged'    => true,
                'message'   => 'Encountered Error Logging Visit'
            ];

    }

    private function error(string $error){

        return response()->json([
            'error'     => true,
            'message'   => $error
        ]);

    }

}
