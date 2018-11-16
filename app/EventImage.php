<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventImage extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'event_id', 'event_images',
    ];

    /**
     * function to get user details
     *
     * @return Response
     */
    public function getUserByEventImageUserId() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public static function getUserEventImages($event_id, $user_id) {
        return EventImage::where(['user_id' => $user_id, 'event_id' => $event_id])->first(array('event_images'));
    }

}
