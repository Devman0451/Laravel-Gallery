<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function owner() {
        return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function conversation() {
        return $this->belongsTo('App\Conversation');
    }

}
