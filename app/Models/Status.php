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

    private $like_count = null;
    private $comment_count = null;

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

    public function parent()
    {
        if( !empty($this->parent_id) ){
            return Status::find($this->parent_id);
        } else {
            return null;
        }
    }

    public function comments()
    {
        return $this->replies();
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

    public function checkLike($user_id)
    {
        if ($this->likes()->where('user_id', $user_id)->get()->first()){
            return true;
        }else{
            return false;
        }
    }

    public function getLikeCount(){
        if ($this->like_count == null){
            $this->like_count = $this->likes()->count();
        }
        return $this->like_count;
    }

    public function checkOwner($user_id){
        if ($this->user_id == $user_id)return true;
        return false;
    }

    public function getCommentCount(){
        if ($this->comment_count == null){
            $this->comment_count = $this->comments()->count();
        }
        return $this->comment_count;
    }

}
