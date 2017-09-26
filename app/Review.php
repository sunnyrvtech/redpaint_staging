<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {

    protected $fillable = ['user_id', 'event_id', 'comment', 'rate', 'status'];

    /**
     * function to get use details based on user id
     *
     * @return Response
     */
    public function getUserDetails() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * function to get event details
     *
     * @return Response
     */
    public function getEventDetails() {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }

}
