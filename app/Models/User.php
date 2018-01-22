<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Status;

/**
 * Class User
 *
 * @package App\Models
 *
 * @SWG\Definition(
 *     definition="NewUser",
 *     required={"name", "email", "provider"},
 *     @SWG\Property(
 *          property="name",
 *          type="string",
 *          description="User's full name",
 *          example="Beltrano da Silva"
 *    ),
 *     @SWG\Property(
 *          property="email",
 *          type="string",
 *          description="User's email",
 *          example="beltrano@gmail.com"
 *    ),
 *     @SWG\Property(
 *          property="provider",
 *          type="string",
 *          description="User's account provider",
 *          example={"local", "facebook", "google"}
 *    )
 * )
 * @SWG\Definition(
 *     definition="User",
 *     allOf = {
 *          { "$ref": "#/definitions/NewUser" },
 *          { "$ref": "#/definitions/Timestamps" },
 *          { "required": {"id"} }
 *     }
 * )
 *
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
        'avatar', 'provider', 'provider_id', 'provider_id_mobile',
        'first_name', 'last_name', 'location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
     * get user by username or e-mail
     * 
     * Show the form for editing the specified resource.
     *
     * @param  string  $username
     * @return App\Models\User
     */
    static public function getUser($username)
    {
        $user = User::where('username', $username)->first();
        if(!$user){
            $user = User::where('email', $username)->first();
        }
        return $user;
    }

    public function getName()
    {
        if ($this->first_name && $this->last_name){
            return "{$this->first_name} {$this->last_name}";
        }

        if ($this->first_name) return $this->first_name;
        
        return null;
    }

    public function getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }

    public function getFirstNameOrUsername()
    {
        return $this->first_name ?: $this->username;
    }

    public function getUsernameOrEmail()
    {
        return $this->username ?: $this->email;
    }

    public function getAvatarUrl()
    {
        if ( $this->avatar != '' )
            return $this->avatar;
        else
            $md5 = md5($this->email);
            //return "https://www.gravatar.com/avatar/{{ md5($this->email) }}?d=mm&s=40"; 
            return "https://www.gravatar.com/avatar/".$md5."?d=mm";
    }

    public function validateUsername($filter = "[^a-zA-Z0-9\-\_\.]"){
        return preg_match("~" . $filter . "~iU", $this->username) ? false : true;
    }

    public function statuses()
    {
        return $this->hasMany('App\Models\Status', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like', 'user_id');
    }

    public function routes()
    {
        return $this->hasMany('App\Models\Route', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'user_id');
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendsOf()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends()
    {
        return $this->friendsOfMine()
        ->wherePivot('accepted', true)
        ->get()
        ->merge( $this->friendsOf()
                    ->wherePivot('accepted', true)
                    ->get()
                );
    }

    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    public function friendRequestsPending()
    {
        return $this->friendsOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    public function addFriend(User $user)
    {
        $this->friendsOf()->attach($user->id);
    }

    public function deleteFriend(User $user)
    {
        $this->friendsOf()->detach($user->id);
        $this->friendsOfMine()->detach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)
            ->first()
            ->pivot->update(['accepted'=>true]);
    }

    public function isFriendsWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    public function hasLikedStatus(Status $status)
    {
        return (bool) $status->likes
            ->where('user_id', $this->id)
            ->count();
    }
}
