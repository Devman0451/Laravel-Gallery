<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = [];

    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function messages() {
        return $this->hasMany('App\Message', 'conversation_id');
    }

    public function latestMessage() {
        return $this->hasOne('App\Message', 'conversation_id')->latest();
    }

    public function sender() {
        return $this->hasOne('App\User', 'id', 'sender_id');
    }

    public function receiver() {
        return $this->hasOne('App\User', 'id', 'received_id');
    }

    public function scopeFindConversations($query) {
        return $query->where('sender_id', auth()->user()->id)
                     ->orWhere('received_id', auth()->user()->id);
    }

    public function scopeConversationExists($query, $param) {
        return $query->where('sender_id', auth()->user()->id)
                    ->where('received_id', $param)
                    ->orWhere('sender_id', $param)
                    ->where('received_id', auth()->user()->id);
    }
}
