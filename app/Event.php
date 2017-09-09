<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','event_slug','name','description','address','city', 'state','zip','date','website_url','price_to','price_from','category_id','status',
    ];
    
    /**
     * function to get owner event images
     *
     * @return Response
     */

    public function getOwnerEventImages() {
        return $this->belongsTo('App\EventImage', 'user_id','user_id');
    }
}
