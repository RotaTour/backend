<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id'
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get all of the places that are assigned this tag.
     */
    public function places()
    {
        return $this->morphedByMany('App\Models\Places', 'taggable');
    }

    /**
     * Get all of the routes that are assigned this tag.
     */
    public function routes()
    {
        return $this->morphedByMany('App\Models\Route', 'taggable');
    }

}
