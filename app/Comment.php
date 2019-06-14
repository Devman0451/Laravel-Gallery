<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    protected $guarded = [];

    public function owner() {
        return $this->belongsTo('App\User', 'owner_id', 'id');
    }

    public function project() {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }

    function scopeGetProjectComments($query, $param) {
        return $query->with('owner.profile')
                     ->where('project_id', $param)
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
    }

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('M d, Y  h:i:s a');
    }
}
