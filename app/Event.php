<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'event_slug', 'name', 'description', 'address', 'city', 'state', 'zip','country_id','formatted_address','operation_hour','latitude','longitude', 'website_url', 'price_to', 'price_from', 'category_id', 'status',
    ];
    
    
     /**
     * function to get category
     *
     * @return Response
     */
    public function getCategory() {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    /**
     * function to get owner event images
     *
     * @return Response
     */
    public function getOwnerEventImages() {
        return $this->belongsTo('App\EventImage', 'id', 'event_id');
    }
    
    /**
     * function to get all event images
     *
     * @return Response
     */
    public function getEventImages() {
        return $this->hasMany('App\EventImage', 'event_id', 'id')->orderBy('updated_at','DESC');
    }

    /**
     * function to get owner event images
     *
     * @return Response
     */
    public function getReviews() {
        return $this->hasMany('App\Review', 'event_id', 'id')->Where('status',1)->orderBy('created_at','DESC');
    }

}
