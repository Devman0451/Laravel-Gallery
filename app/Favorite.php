<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = [];

    public function project() {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function owner() {
        return $this->belongsTo('App\User', 'owner_id', 'id');
    }

    public function scopeGetUserFavorite($query, $param) {
        return $query->where('owner_id', auth()->user()->id)
                    ->where('project_id', $param);
    }

    public function scopeGetFavorites($query, $param) {
        return $query->with('project.owner.profile')
                     ->where('owner_id', $param)
                     ->orderBy('created_at', 'desc')
                     ->paginate(40);
    }
}
