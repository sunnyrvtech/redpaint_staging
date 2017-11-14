<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Review;
use App\Event;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::Where('status',1)->get();
        $events = Event::Where('status',1)->orderby('created_at','DESC')->take(20)->get();
        $review_of_day = Review::Where('status',1)->orderby('created_at','DESC')->first();
        return view('index',compact('categories','events','review_of_day'));
    }
}
