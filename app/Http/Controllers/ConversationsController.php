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
        $conversations = Conversation::findConversations()->get();

        return view('conversations.index', compact('conversations'));
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

        $user = User::with('profile')->getByID($_GET['user'])->get();

        return view('conversations.create', [
            'conversation' => $conversation,
            'user'=> $user[0]
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

        $this->validateConversation($request, $conversation->id);
        $conversation->touch();

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
    public function destroy(Conversation $message)
    {
        $message->delete();
        return redirect()->back();
    }


    protected function verifyConversation($id) {
        if (!isset($id)) {
            return null;
        }

        $to = User::getByID($id)->get();

        if (count($to) == 0) {
            return null;
        }

        $conversation = Conversation::conversationExists($id)->first();

        if ($conversation == null) {
            Conversation::create([
                'sender_id' => auth()->user()->id,
                'received_id' => $_GET['user']
            ]);

            return $this->verifyConversation($id);
        }

        return $conversation;
    }

    protected function validateConversation($request, $id) {
        $attributes = $this->validate($request, [
            'message' => 'required|min:1'
        ]);

        $attributes['sender_id'] = auth()->user()->id;
        $attributes['conversation_id'] = $id;

        Message::create($attributes);
    }
}
