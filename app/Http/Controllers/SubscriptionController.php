<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Package;
use Auth;
use Stripe\Error\InvalidRequest;
use Redirect;
use View;

class SubscriptionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $monthArray = array(
            "01" => "January", "02" => "February", "03" => "March", "04" => "April",
            "05" => "May", "06" => "June", "07" => "July", "08" => "August",
            "09" => "September", "10" => "October", "11" => "November", "12" => "December",
        );
        $start_year = date('Y', strtotime('-10 year'));  // get last 10 year based on current year
        $end_year = date('Y', strtotime('+10 year'));  // get next 10 year based on current year
        $yearArray = array(
            'start' => $start_year,
            'end' => $end_year
        );

        $packages = Package::get();

        return View::make('ads.ads', compact('monthArray', 'yearArray', 'packages'));
    }

    /**
     * function to create user subscription.
     *
     * @return Response
     */
    public function postJoin(Request $request) {
        $user = User::find(Auth::id());
        $data = $request->all();
        $package = Package::find($data['plan']);
        try {
            $user->newSubscription($package->name, $package->plan_id)->create($data['stripeToken'], [
                'email' => $user->email,
            ]);
        } catch (InvalidRequest $e) {
            return Redirect::back()->with('error-message', $e->getMessage());
        }

        return Redirect::back()
                        ->with('success-message', 'Payment successfully!');
    }

}
