<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    protected $guarded = [];

    public function owner() {
        return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function conversation() {
        return $this->belongsTo('App\Conversation');
    }

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('M d, Y  h:i:s a');
    }

    public function getUpdatedAtAttribute($date) {
        return Carbon::parse($date)->format('M d, Y  h:i:s a');
    }

}
