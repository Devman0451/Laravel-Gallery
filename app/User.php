<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects() {
        return $this->hasMany('App\Project', 'owner_id');
    }

    public function profile() {
        return $this->hasOne('App\Profile', 'owner_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'owner_id');
    }

    public function likes() {
        return $this->hasMany('App\Like', 'owner_id');
    }

    public function followers() {
        return $this->hasMany('App\Like', 'followed_id', 'id');
    }

    public function sent_messages() {
        return $this->hasMany('App\Message', 'sender_id');
    }

    public function started_conversations() {
        return $this->hasMany('App\Conversation', 'sender_id');
    }

    public function received_conversations() {
        return $this->hasMany('App\Conversation', 'received_id');
    }

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('M d, Y  h:i:s a');
    }

    public function scopeGetByID($query, $param) {
        return $query->where('id', $param);
    }

    public function scopeGetAllUsers($query) {
        return $query->with('profile')
                     ->orderBy('created_at', 'desc')
                     ->paginate(15);
    }

    public function scopeGetOneUser($query, $param) {
        return $query->where('id', $param)
                     ->first();
    }
}
