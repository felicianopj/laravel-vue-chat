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

	public function getSenderMessages(int $receiver_id)
	{
		return Message::where('sender_id', Auth::user()->id)
			->where('receiver_id', $receiver_id)
			->get();
	}

	public function getReceiverMessages(int $sender_id)
	{
		return Message::where('sender_id', $sender_id)
			->where('receiver_id', Auth::user()->id)
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
