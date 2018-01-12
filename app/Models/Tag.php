<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 *
 * @package App\Models
 *
 * @SWG\Definition(
 *     definition="NewTag",
 *     required={"name", "user_id"},
 *     @SWG\Property(
 *          property="name",
 *          type="string",
 *          description="Tag name",
 *          example="{litoral, rápido, baixo custo}"
 *    ),
 *     @SWG\Property(
 *          property="user_id",
 *          type="integer",
 *          description="The id of the Owner, user_id in database"
 *    )
 * )
 * @SWG\Definition(
 *     definition="Tag",
 *     allOf = {
 *          { "$ref": "#/definitions/NewTag" },
 *          { "$ref": "#/definitions/Timestamps" },
 *          { "required": {"id"} }
 *     }
 * )
 *
 */
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
