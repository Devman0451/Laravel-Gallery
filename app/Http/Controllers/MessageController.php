<?php

namespace App\Http\Controllers;

use App\Message;
use App\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Conversation $conversation) {
        return $conversation->messages()->with('owner.profile')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Conversation $conversation)
    {
        return $this->validateConversation($request, $conversation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }

    protected function validateConversation($request, $conversation) {
        $this->validate($request, [
            'message' => 'required|min:1'
        ]);

        $message = $conversation->messages()->create([
            'message' => $request->message,
            'sender_id' => Auth::id()
        ]);

        $message = Message::where('id', $message->id)->with('owner.profile')->first();

        broadcast(new NewMessage($conversation, $message))->toOthers();

        return $message->toJson();
    }
}
