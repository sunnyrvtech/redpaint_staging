<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

    protected $fillable = ['user_id', 'stripe_id', 'subscription_plan', 'amount', 'subscription_start', 'subscription_end'];

    /**
     * function to get use details based on user id
     *
     * @return Response
     */
    public function getUserDetails() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
