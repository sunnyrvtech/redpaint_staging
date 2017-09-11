<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'stripe_id','subscription_plan','amount','subscription_start','subscription_end'];
}
