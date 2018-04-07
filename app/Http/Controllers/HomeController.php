<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Review;
use App\Event;
use Newsletter;
use App\StaticPage;
use View;

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
    public function getAboutUs() {
        $data['content'] = StaticPage::where('slug', 'about-us')->first();
        return View::make('about-us', $data);
    }
    public function getAdvertise() {
        $data['content'] = StaticPage::where('slug', 'advertise')->first();
        return View::make('advertise', $data);
    }
    public function getJoinTeam() {
        $data['content'] = StaticPage::where('slug', 'join-team')->first();
        return View::make('team', $data);
    }
    public function getMerchandise() {
        $data['content'] = StaticPage::where('slug', 'merchandise')->first();
        return View::make('merchandise', $data);
    }
    public function getPromotionalPackage() {
        $data['content'] = StaticPage::where('slug', 'promotional-packages')->first();
        return View::make('package', $data);
    }
    public function getBusinessSupport() {
        $data['content'] = StaticPage::where('slug', 'business-support')->first();
        return View::make('support', $data);
    }
    public function getTermCondition() {
        $data['content'] = StaticPage::where('slug', 'terms-and-agreement')->first();
        return View::make('term', $data);
    }
    
    public function saveUserLocation(Request $request){
        $data = $request->all();
        dd($data);
        if($data['latitude'] != null){
            $request->session()->put('latitude', $data['latitude']);
        }
        
        if($data['longitude'] != null){
            $request->session()->put('longitude', $data['longitude']);
        }
        
//        if($data['user_location'] != null){
//            $request->session()->put('user_location', $data['user_location']);
//        }
        
        return true;
//        return redirect('/');
    }
    
    public function getMapLocation(Request $request,$id){
         $data['event'] = Event::Where('id', $id)->first(array('latitude','longitude','formatted_address'));
         return view('events.map',$data);
    }
}
