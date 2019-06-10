<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function project() {
        return $this->belongsTo('App\Project');
    }

    function scopeGetProjectComments($query, $param) {
        return $query->with('owner.profile')
                     ->where('project_id', $param)
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
    }
}
