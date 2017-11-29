<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_id', 'route_id', 'order', 'action', 'done'
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];
    
    /*
     * Relationships
     */
    public function route()
    {
        return $this->belongsTo('App\Models\Route');
    }

    public function place()
    {
        return $this->belongsTo('App\Models\Place');
    }
}
