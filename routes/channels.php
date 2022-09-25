<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/



Broadcast::channel('counter.{user_id}', function($user, $user_id){

	return (int) $user->user_id === (int) $user_id;

});

Broadcast::channel('instant-post-stats.{id}', function($user, $id){

  return $user;

});

Broadcast::channel('chats-event.{id}', function($user, $id){

	return true;/*(int) $user->user_id === (int) $id;*/

});

Broadcast::channel('messages-event.{from}.{to}', function($user, $from, $to){

	return true;/*($user->user_id == $from || $user->user_id == $to);*/

});

/*0719981975*/