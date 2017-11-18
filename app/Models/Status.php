<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'body', 'user_id', 'parent_id'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function scopeNotReply($query)
    {
        return $query->whereNull('parent_id');
    }


    public function replies()
    {
        return $this->hasMany('App\Models\Status', 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function likesString()
    {
        $count = $this->likes->count();
        return $count." ".(str_plural('like', $count));
    }

}
