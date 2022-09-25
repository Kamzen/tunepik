<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\UserModelController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function current(Request $request)
    {

        $currentUser = $request->user();

        $currentUser['model'] = (new UserModelController())->buildUser($request->user()->user_id, 'api');

        return response()->json($request->user());
    }
}
