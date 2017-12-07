<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use App\Notifications\ResetNotification;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','social_id','role_id','first_name','last_name','address','city','state','zip','country_id', 'email','password','verify_token','user_image','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function sendPasswordResetNotification($token) {
        $username = $this->first_name . ' ' . $this->last_name;
        $this->notify(new ResetNotification($token, $username));
    }
    
    
    /**
     * function to get user active plan
     *
     * @return Response
     */

    public function get_active_plan() {
        return $this->belongsTo('App\Subscription', 'id','user_id');
    }
    
    
    
    
    
    
}
