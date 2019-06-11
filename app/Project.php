<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    protected $guarded = [];
    
    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'project_id');
    }

    public function likes() {
        return $this->hasMany('App\Like', 'project_id');
    }

    public function favorites() {
        return $this->hasMany('App\Favorite', 'project_id');
    }

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('M d, Y  h:i:s a');
    }

    public function scopeOrderByDate($query) {
        return $query->with('owner.profile')
                     ->orderBy('created_at', 'desc');
    }

    public function scopeOrderByLikes($query) {
        return $query->with('owner.profile')
                     ->orderBy('likes', 'desc');
    }

    public function scopeSearchTagsAndTitles($query, $param) {
        return $query->with('owner.profile')
                     ->where('tags', 'like', '%' . $param . '%')
                     ->orWhere('title', 'like', '%' . $param . '%');
    }

    public function scopeGetByID($query, $param) {
        return $query->where('id', $param);
    }
}
