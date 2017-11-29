<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'body', 'user_id'
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    /*
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function itens()
    {
        return $this->hasMany('App\Models\Item');
    }

}
