<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'name', 'google_place_id', 'address', 'lat', 'lng', 'scope', 'icon'
   ];

   protected $dates = [
       'created_at', 'updated_at',
   ];

    /*
     * Relationships
     */
    public function itens()
    {
        return $this->hasMany('App\Models\Item');
    }
    
}
