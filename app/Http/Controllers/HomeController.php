<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Review;
use App\Event;
use Newsletter;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $events = Event::Where('status', 1)->orderby('created_at', 'DESC')->take(20)->get();
        $review_of_day = Review::Where('status', 1)->orderby('created_at', 'DESC')->first();
        return view('index', compact('events', 'review_of_day'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribeNewsletter(Request $request) {

        if ($request->get('email') != 'undefined') {
            $email = $request->get('email');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['error' => "Please enter valid email address !"], 401);
            }
            if (Newsletter::isSubscribed($email)) {
                return response()->json(['error' => $email . " is already subscribed to list Redpaint"], 401);
            } else {
                Newsletter::subscribe($email);
                return response()->json(['success' => "Thank you for subscribe !"]);
            }
        } else {
            return response()->json(['error' => "Please enter email address"], 401);
        }
    }

}
