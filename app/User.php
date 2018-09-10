<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function microposts(){
        return $this->hasMany(Micropost::class);
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        $exist = $this->is_following($userId);
        
        $its_me = $this->id == $userId;
        
        if( $exist || $its_me) {
            return false;
        }else{
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        $exist = $this->is_following($userId);
        
        $its_me = $this->id == $userId;
        
        if( $exist && !$its_me) {
            $this->followings()->detach($userId);
            return true;
        }else{
            return false;
        }
    }
    
    public function is_following($userId){
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    public function feed_microposts()
    {
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
    public function favourings()
    {
        return $this->belongsToMany(Micropost::class, 'favourite', 'user_id', 'favour_id')->withTimestamps();
    }
    
    /** public function favoureds()
     *{
     *  return $this->hasMany(Micropost::class, 'favourite', 'favour_id', 'user_id')->withTimestamps();
    *}
     */
    
    public function favour($microId)
    {
        $exist = $this->is_favouring($microId);
        
        if( $exist )
        {
            return false;
        }else{
            $this->favourings()->attach($microId);
            return true;
        }
    }
    
    public function unfavour($microId)
    {
        $exist = $this->is_favouring($microId);
        
        if( $exist )
        {
            $this->favourings()->detach($microId);
            return true;
        }else{
            return false;
        }
    }
    
    public function is_favouring($microId)
    {
        return $this->favourings()->where('favour_id', $microId)->exists();
    }
    
}
