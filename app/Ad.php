<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model {

    protected $fillable = ['user_id','name','banner','link'];
    
    
    /**
     * function to get use details based on user id
     *
     * @return Response
     */

    public function getUserDetails() {
        return $this->belongsTo('App\User', 'user_id','id');
    }

}
