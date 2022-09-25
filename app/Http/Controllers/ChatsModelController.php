<?php

namespace App\Http\Controllers;

use App\Chats;
use App\Messages;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChatsModelController extends Controller
{

	protected $userOne = 0;
	protected $chatUserId = 0;

	function __construct(){

	    $this->middleware('auth');
		$this->userOne = (new AuthController())->authenticate('api'); //auth('api')->check() ? auth('api')->user()->user_id : 0;

	}

	private function error($e){

		return response()->json(['error' => true, 'message' => $e]);

	}
	public function chats(){

		if(!auth('api')->check()) return response()->json($this->error("Unauthorized Request"));

		$mChats = DB::table('chats')
															->where('user_id_one', $this->userOne)
															->orWhere('user_id_two', $this->userOne)
															->get();

		if($mChats->count() == 0) return response()->json([

				'error' 	=> false,
				'list'  	=> false,
				'message' => 'Conversations With Other Users Will Appear Here, Start A Conversation'

		]);


		return response()->json($this->formatChats($mChats->toArray()));

	}

	public function chatsChannel(){

		$mChats = DB::table('chats')
															->where('user_id_one', $this->userOne)
															->where('seen', 0)
															->orWhere('user_id_two', $this->userOne)
															->where('seen', 0)
															->get();

		if($mChats->count() == 0) return response()->json([

				'error' 	=> false,
				'list'  	=> false,
				'message' => 'Conversations With Other Users Will Appear Here, Start A Conversation'

		]);

			return $this->formatChats($mChats->toArray());

	}

	public function messagesChannel($from, $to){

		$mMessages = DB::table('messages')
																->where('user_id_one', $from)
																->where('user_id_two', $to)
																->where('seen', 0)
																->orWhere('user_id_one', $to)
																->where('user_id_two', $from)
																->where('seen', 0);

		if($mMessages->get()->count() == 0) return [

				'error' 	=> false,
				'chats'  	=> false,
				'message' => 'Start A Conversation With @'.$mUser->user_athandle

		];

		return $this->formatMessages($mMessages->get()->toArray());

	}

	public function messages($handle){

		if(!auth('api')->check()) return $this->error("Unauthorized Request");

		if(empty($handle)) return $this->error('Bad Request');

		$mUser = User::all()
										->where('user_athandle', $handle);

		if($mUser->count() == 0) return $this->error('This User Does Not Exist On Our Platform');

		$mUser = $mUser->first();

		$mMessages = DB::table('messages')
																->where('user_id_one', $this->userOne)
																->where('user_id_two', $mUser->user_id)
																->orWhere('user_id_one', $mUser->user_id)
																->where('user_id_two', $this->userOne);

		if($mMessages->get()->count() == 0) return response()->json([

				'error' 	=> false,
				'chats'  	=> false,
				'message' => 'Start A Conversation With @'.$mUser->user_athandle

		]);

		$mMessages = $mMessages->get();
			
		DB::table('messages')
										->where('user_id_one', $this->userOne)
										->where('user_id_two', $mUser->user_id)
										->orWhere('user_id_one', $mUser->user_id)
										->where('user_id_two', $this->userOne)
										->update(['seen' => 1]);
		  // $mMessages->update(['seen' => 1]);

		return response()->json($this->formatMessages($mMessages->toArray()));

	}

	public function user($handle){

		if(!auth('api')->check()) return $this->error("Unauthorized Request");

		if(empty($handle)) return $this->error('Bad Request');

		$mUser = User::all()
										->where('user_athandle', $handle);

		if($mUser->count() == 0) return $this->error('This User Does Not Exist On Our Platform');

		$mUser = $mUser->first();

		return response()->json([

			'error'  		=> false,
			'messages' 	=> 'User Found',
			'user'			=> (new UserModelController)->buildUser($mUser->user_id, 'api')

		]);

	}

	private function delete($id){

		if(!auth('api')->check()) return response()->json($this->error("Unauthorized Request"));

		if(empty($id)) return $this->error('Bad Request');

		$mUser = User::all()
										->where('user_id', $id);

		if($mUser->count() == 0) return $this->error('This User Does Not Exist On Our Platform');

		return response()->json($this->deleteMessages($mUser));

	}

	private function deleteMessages(User $user){

		$chats = DB::table('chats')
                        ->where('user_id_one', $user->user_id)
                        ->where('user_id_two', $this->userOne)
                        ->orWhere('user_id_one', $this->userOne)
                        ->where('user_id_two', $user->user_id);

        if($chats->get()
      					 ->count() > 0){

        	 $messages = DB::table('messages')
                        ->where('user_id_one', $user->user_id)
                        ->where('user_id_two', $this->userOne)
                        ->orWhere('user_id_one', $this->userOne)
                        ->where('user_id_two', $user->user_id);

             if($messages->get()
           							 ->count() > 0){

             			if($chats->delete() > 0 && $messages->delete() > 0){

             				return ['error' => false, 'message' => 'Conversation Deleted'];

             			}else{

             				return ['error' => true, 'message' => 'Encountered An Error, Conversation Not Deleted'];

             			}

             }else{

             	return ['error' => false, 'message' => 'Nothing To Delete'];

             }

        }else{


        	return ['error' => false, 'message' => 'Nothing To Delete'];

        }

	}

	public function buildMessagesCounts(){

	    if(!auth()->check()) return $this->error('Unauthorized Request');

        $mChats = DB::table('chats')
                                    ->where('user_id_one', $this->userOne)
                                    ->orWhere('user_id_two', $this->userOne)
                                    ->get();

        return ['count' => $mChats->count()];

    }

	private function formatChats(array $chats){

		$response = ['error' =>false, 'list' => !empty($chats), 'message' => 'You Have Chats' ];

		foreach($chats as $chat){

			$response['chats'][] = $this->buildChats($chat /*new Chats($chat)*/);

		}

		return $response;

	}


	private function formatMessages(array $messages){

		$response = ['error' =>false, 'chats' => !empty($chats), 'message' => 'You Have Messages' ];

		foreach($messages as $message){

			$response['messages'][] = $this->buildMessages($message/*new Messages($message)*/);

		}

		return $response;

	}

	private function getChatUserId($model){

		$this->chatUserId = $this->userOne == $model->user_id_one ? $model->user_id_two : $model->user_id_one;

	}

	public function buildChats(/*Chats*/ $chat){

		// $this->chatUserId = $this->userOne == $chat->user_id_one ? $chat->user_id_two : $chat->user_id_one;

		$this->getChatUserId($chat);

		return [

				'user_info' 		=> (new UserModelController)->buildUser($this->chatUserId, 'api'),

				'chat' 					=> [

						'message'		=> $chat->last_msg,
						'seen'			=> $chat->seen,
						'chat_id'		=> $chat->chat_id,
						'time'		    => $chat->chat_time,
						'date'			=> $chat->chat_date,
            'now'       => TunepikUtilController::timeDifference($chat->chat_date, $chat->chat_time),
						'type'			=> $chat->type,
						'count' 		=> DB::table('messages')
                                                                    ->where('user_id_one', $this->userOne)
                                                                    ->where('user_id_two', $this->chatUserId)
                                                                    ->where('seen', 0)
                                                                    ->orWhere('user_id_one', $this->chatUserId)
                                                                    ->where('user_id_two', $this->userOne)
                                                                    ->where('seen', 0)
                                                                    ->get()
                                                                    ->count()

				]

		];

	}


	public function buildMessages(/*Messages*/ $message){

		$this->getChatUserId($message);

		return [

				'user_info' 		=> (new UserModelController)->buildUser($this->chatUserId, 'api'),

				'message'				=> [

                    'user_id_one'		=> $message->user_id_one,
                    'user_id_two'		=> $message->user_id_two,
                    'message'			=> $message->message,
                    'url'				=> $message->url,
                    'type' 				=> $message->type,
                    'msg_date' 			=> $message->msg_date,
                    'msg_time' 			=> $message->msg_time,
                    'now'               => TunepikUtilController::timeDifference($message->msg_date, $message->msg_time),
                    'seen'				=> $message->seen,
                    'msg_id'			=> $message->msg_id

				]

		];

	}

} // End Of Class
