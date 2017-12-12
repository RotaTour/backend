<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 *
 * @package App\Models
 *
 * @SWG\Definition(
 *     definition="NewItem",
 *     required={"place_id", "route_id"},
 *     @SWG\Property(
 *          property="place_id",
 *          type="integer",
 *          description="Place id in database"
 *     ),
 *     @SWG\Property(
 *          property="route_id",
 *          type="integer",
 *          description="Route id in database"
 *     )
 * )
 * @SWG\Definition(
 *     definition="Item",
 *     allOf = {
 *          { "$ref": "#/definitions/NewItem" },
 *          { "$ref": "#/definitions/Timestamps" },
 *          { "required": {"id"} }
 *     }
 * )
 *
 */
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
