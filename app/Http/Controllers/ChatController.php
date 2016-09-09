<?php

namespace App\Http\Controllers;

use Auth;
use App\Message;
use App\Http\Requests;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
    	return view('index');
    }

    public function getSender()
    {
    	
    }

	public function getReceiver()
	{

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

	public function postMessages()
	{

	}

	public function patchMessages()
	{

	}

	public function deleteMessages()
	{

	}

}
