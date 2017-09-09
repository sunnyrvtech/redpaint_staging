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

        //$user = User::find(Auth::id());
//        if (Auth::user()->subscribed('ads_subscription')) {
//            die('yes');
//        }else{
//            die('no');
//        }
        //$user->subscription('Daily')->swap('Weekly');
        //$user->subscription('Daily')->resume();
        //$user->subscription('Daily')->cancel();





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

        $view = View::make('ads.ads', compact('monthArray', 'yearArray', 'packages'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    /**
     * function to create user subscription.
     *
     * @return Response
     */
    public function subscriptionJoin(Request $request) {
        $user = User::find(Auth::id());
        $data = $request->all();
        $package = Package::find($data['plan']);
        try {
            $user->newSubscription("ads_subscription", $package->plan_id)->create($data['stripeToken'], [
                'email' => $user->email,
            ]);
        } catch (InvalidRequest $e) {
            return Redirect::back()->with('error-message', $e->getMessage());
        }

        return Redirect::back()
                        ->with('success-message', 'Payment successfully!');
    }

    /**
     * function to change user subscription.
     *
     * @return Response
     */
    public function subscriptionChange(Request $request) {
        $user = User::find(Auth::id());
        $package = Package::find($request->get('id'));
        $user->subscription('ads_subscription')->swap($package->plan_id);
        return response()->json(['success' => true, 'html' => $this->index($request), 'messages' => "Plan changed successfully!"]);
    }

    /**
     * function to cancel user subscription.
     *
     * @return Response
     */
    public function subscriptionCancel(Request $request) {
        $user = User::find(Auth::id());
        $user->subscription('ads_subscription')->cancel();
        return response()->json(['success' => true, 'html' => $this->index($request), 'messages' => "Subscription cancelled successfully!"]);
    }

    /**
     * function to resume user subscription.
     *
     * @return Response
     */
    public function subscriptionResume(Request $request) {
        $user = User::find(Auth::id());
        $user->subscription('ads_subscription')->resume();
        return response()->json(['success' => true, 'html' => $this->index($request), 'messages' => "Subscription resume successfully!"]);
    }

    /**
     * function to update card information.
     *
     * @return Response
     */
    public function updateCard(Request $request) {
        $user = User::find(Auth::id());
        $stripeToken = $request->get('stripeToken');
        try {
            $user->updateCard($stripeToken);
        } catch (InvalidRequest $e) {
            return Redirect::back()->with('error-message', $e->getMessage());
        }
        return Redirect::back()->with('success-message', "Your card has been updated successfully");
    }

}
