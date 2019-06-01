<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\User;
use App\Message;
use Illuminate\Http\Request;

class ConversationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('conversations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $conversation = $this->verifyConversation($_GET['user']);
        
        if ($conversation == null) return redirect('/messages');

        return view('conversations.create', [
            'conversation' => $conversation[0],
            'send_id'=> $_GET['user']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conversation = $this->verifyConversation($_GET['user']);
        
        if ($conversation == null) return redirect('/messages');

        $attributes = $this->validate($request, [
            'message' => 'required|min:1'
        ]);

        $attributes['sender_id'] = auth()->user()->id;
        $attributes['conversation_id'] = $conversation[0]->id;

        Message::create($attributes);

        $messages = Message::where('conversation_id', $conversation[0]->id);

        return redirect()->back()->with('conversation', $conversation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }

    protected function verifyConversation($id) {
        if (!isset($id)) {
            return null;
        }

        $to = User::where('id', $id)->get();

        if (count($to) == 0) {
            return null;
        }

        $conversation = Conversation::where('sender_id', auth()->user()->id)
                                    ->where('received_id', $id)
                                    ->orWhere('sender_id', $id)
                                    ->where('received_id', auth()->user()->id)
                                    ->get();

        if (count($conversation) == 0) {
            $conversation = Conversation::create([
                'sender_id' => auth()->user()->id,
                'received_id' => $_GET['user']
            ]);
        }

        return $conversation;
    }
}
