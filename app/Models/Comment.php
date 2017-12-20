<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @package App\Models
 *
 * @SWG\Definition(
 *     definition="NewComment",
 *     required={"body", "user_id", "commentable_id", "commentable_type"},
 *     @SWG\Property(
 *          property="body",
 *          type="string",
 *          description="User's Comment",
 *          example="lorem ipsum dollor..."
 *    ),
 *     @SWG\Property(
 *          property="user_id",
 *          type="integer",
 *          description="User's id in database"
 *    ),
 *     @SWG\Property(
 *          property="commentable_id",
 *          type="integer",
 *          description="id in database of resource that will receive the comment"
 *    ),
 *     @SWG\Property(
 *          property="commentable_type",
 *          type="string",
 *          description="The Model Class Path of resource that will receive the commnet",
 *          example="App\Models\Route"
 *    )
 * )
 * @SWG\Definition(
 *     definition="Comment",
 *     allOf = {
 *          { "$ref": "#/definitions/NewComment" },
 *          { "$ref": "#/definitions/Timestamps" },
 *          { "required": {"id"} }
 *     }
 * )
 *
 */
class Comment extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['body'];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


}
