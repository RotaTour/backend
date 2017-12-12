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
 *          description="Route's full name",
 *          example="Rota de teste"
 *    ),
 *     @SWG\Property(
 *          property="user_id",
 *          type="integer",
 *          description="User's id in database"
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

}
