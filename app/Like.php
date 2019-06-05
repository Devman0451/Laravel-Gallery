<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function scopeGetUserLike($query, $param) {
        return $query->where('owner_id', auth()->user()->id)
                    ->where('project_id', $param);
    }
}
