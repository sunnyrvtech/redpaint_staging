<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'class_name','status'];
    
    
    /**
     * function to get sub category data
     *
     * @return Response
     */
    public function getSubCategory() {
        return $this->hasMany('App\SubCategory', 'category_id', 'id');
    }
}
