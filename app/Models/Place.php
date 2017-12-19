<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Place
 *
 * @package App\Models
 *
 * @SWG\Definition(
 *     definition="NewPlace",
 *     required={"google_place_id", "name"},
 *     @SWG\Property(
 *          property="google_place_id",
 *          type="string",
 *          description="UUID Google Place Id",
 *          example="ChIJVyuijGQZqwcREEzZ32LILvA"
 *    ),
 *     @SWG\Property(
 *          property="name",
 *          type="string",
 *          description="Place name",
 *          example="Hospital das Clínicas - HC - UFPE"
 *    )
 * )
 * @SWG\Definition(
 *     definition="Place",
 *     allOf = {
 *          { "$ref": "#/definitions/NewPlace" },
 *          { "$ref": "#/definitions/Timestamps" },
 *          { "required": {"id"} }
 *     }
 * )
 *
 */
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

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
    
    /**
     * json_decode google json
     *
     * @return json_decode
     */
    public function json()
    {
        return json_decode($this->google_json);
    }
}
