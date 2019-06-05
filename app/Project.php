<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];
    
    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'project_id');
    }

    public function scopeOrderByDate($query) {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOrderByLikes($query) {
        return $query->orderBy('likes', 'desc');
    }

    public function scopeSearchTagsAndTitles($query, $param) {
        return $query->where('tags', 'like', '%' . $param . '%')
                     ->orWhere('title', 'like', '%' . $param . '%');
    }

    public function scopeGetByID($query, $param) {
        return $query->where('id', $param);
    }
}
