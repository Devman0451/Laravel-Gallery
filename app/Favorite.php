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
        return $this->belongsTo('App\User');
    }
}
