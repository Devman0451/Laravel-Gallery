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

    public function likes() {
        return $this->hasMany('App\Like', 'project_id');
    }

}
