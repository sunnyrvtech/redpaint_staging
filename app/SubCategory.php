<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
     protected $fillable = ['category_id','slug','name','category_image'];
     
     public function getCategory(){
          return $this->belongsTo('App\Category', 'category_id', 'id');
     }
}
