<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Route
 *
 * @package App\Models
 *
 * @SWG\Definition(
 *     definition="NewRoute",
 *     required={"name", "user_id"},
 *     @SWG\Property(
 *          property="name",
 *          type="string",
 *          description="Route full name",
 *          example="Rota de teste"
 *    ),
 *     @SWG\Property(
 *          property="user_id",
 *          type="integer",
 *          description="Owner of the Route, User id in database"
 *    ),
 *     @SWG\Property(
 *          property="body",
 *          type="string",
 *          description="The route description"
 *    )
 * )
 * @SWG\Definition(
 *     definition="Route",
 *     allOf = {
 *          { "$ref": "#/definitions/NewRoute" },
 *          { "$ref": "#/definitions/Timestamps" },
 *          { "required": {"id"} }
 *     }
 * )
 *
 */
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

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
    
    /**
     * Get all of the tags for the post.
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

}
