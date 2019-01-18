<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimBusiness extends Model
{
    protected $fillable = ['user_id', 'event_id'];
    
    
    
     /**
     * function to get use details based on user id
     *
     * @return Response
     */
    public function useInfo() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    /**
     * function to get use details based on user id
     *
     * @return Response
     */
    public function eventInfo() {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }
    
    
    
}
