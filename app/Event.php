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
        'user_id', 'event_slug', 'name', 'description', 'address','phone_number', 'city', 'state', 'zip','country_id','formatted_address','daily_deal','happy_hour','happy_hour_note','brunch_hour','brunch_hour_note','operation_hour','vegan','vegetarian','gluten','parking','latitude','longitude', 'website_url', 'price_to', 'price_from', 'category_id','sub_category_id', 'status','start_date','end_date',
    ];
    
    /**
     * function to get use details based on user id
     *
     * @return Response
     */
    public function getUserDetails() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    /**
     * function to get use details based on user id
     *
     * @return Response
     */
    public function getSubCategory() {
        return $this->belongsTo('App\SubCategory', 'sub_category_id', 'id');
    }
    
    
     /**
     * function to get category
     *
     * @return Response
     */
    public function getCategory() {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    /**
     * function to check event likes
     *
     * @return Response
     */
    public function check_event_like() {
        return $this->belongsTo('App\EventLike', 'id', 'event_id')->select('id');
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
