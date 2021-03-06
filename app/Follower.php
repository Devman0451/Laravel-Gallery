<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $guarded = [];

    public function owner() {
        return $this->belongsTo('App\User', 'follower_id', 'id');
    }

    public function scopeGetUserFollowing($query, $param) {
        return $query->where('follower_id', auth()->user()->id)
                     ->where('followed_id', $param);
    }

    public function scopeGetAllFollowers($query, $param) {
        return $query->where('followed_id', $param)
                     ->orderBy('created_at', 'desc')
                     ->paginate(40);
    }
}
