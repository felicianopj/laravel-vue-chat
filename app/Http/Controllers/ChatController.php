<?php

namespace App\Http\Controllers;

use Auth;
use App\Message;
use App\Http\Requests;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Events\MessageDeleted;
use App\Events\MessageUpdated;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\DeleteMessageRequest;

class ChatController extends Controller
{
    public function index()
    {
    	return view('index');
    }

    public function getMessage(int $message_id)
    {
    	$message = Message::findOrFail($message_id);
    	return (Auth::user()->id == $message->sender_id) ? $message : null;
    }

	public function getMessages(int $user_id)
	{
		return Message::where('sender_id', Auth::user()->id)
			->where('receiver_id', $user_id)
			->orWhere('sender_id', $user_id)
			->where('receiver_id', Auth::user()->id)
			->orderBy('created_at', 'asc')
			->get();
	}

	public function postMessage(StoreMessageRequest $request)
	{
		$message = new Message;
		$message->sender_id = Auth::user()->id;
		$message->receiver_id = $request->input('receiver_id');
		$message->content = $request->input('content');
		$message->save();

		event(new MessageSent($message));
	}

	public function updateMessage(StoreMessageRequest $request, int $message_id)
	{
		$message = Message::find($message_id);
		$message->content = $request->input('content');
		$message->save();
		event (new MessageUpdated($message));
	}

	public function deleteMessage(DeleteMessageRequest $request, int $message_id)
	{
		event (new MessageDeleted(Message::find($message_id)));
		Message::destroy($message_id);
	}

}
