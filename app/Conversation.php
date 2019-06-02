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
}
