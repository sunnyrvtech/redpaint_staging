<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Package;
use App\Payment;
use App\Subscription;
use Auth;
use Stripe\Error\InvalidRequest;
use Redirect;
use Mail;
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

    /**
     * function to get payment information from stripe through webhook url.
     *
     * @return Response
     */
    public function paymentStatus() {
        $input = @file_get_contents("php://input");
        $event_json = json_decode($input);
        $user = User::where('stripe_id', 'cus_BNW17HQj2JqeIm')->select('id', 'email', 'first_name', 'last_name')->first();
        $subscription = Subscription::Where('user_id', $user->id)->first();
        $last_invoice = last($event_json->data->object->lines->data);
        if ($event_json->type == 'invoice.payment_succeeded') {
            ///  insert user subscription data in the payment table
            $subscription->fill(array('ends_at', null))->save();
            
            $payment = array(
                'user_id' => $user->id,
                'stripe_id' => $event_json->data->object->customer,
                'subscription_plan' => $last_invoice->plan->id,
                'amount' => ($last_invoice->plan->amount) / 100,
                'subscription_start' => date('Y-m-d H:i:s', $last_invoice->period->start),
                'subscription_end' => date('Y-m-d H:i:s', $last_invoice->period->end),
            );
            Payment::insert($payment);
            // send only in the email
            if ($event_json->data->object->total < 0) {
                $payment['payment_message'] = "You're account has been successfully downgraded. Your payments and subscription plan information is following.";
            } else {
                $payment['payment_message'] = "You're account has been successfully upgraded. Your payments and subscription plan information is following.";
            }
            $payment['subscription_start'] = date('F d,Y H:i A', $last_invoice->period->start);
            $payment['subscription_end'] = date('F d,Y H:i A', $last_invoice->period->end);
            $payment['amount_due'] = ($event_json->data->object->amount_due) / 100;
            $payment['pay_name'] = $user->first_name . ' ' . $user->last_name;
            //code is passed to route which is then passed back to this controller and getActivate method
            Mail::send('auth.emails.payment', $payment, function($message) use ($user) {
                $message->from('test4rvtech@gmail.com', " Welcome To Redpaint");
                $message->to($user->email, $user->first_name)->subject('Subscription payment for redpaint');
            });
        } else if ($event_json->type == 'invoice.payment_failed' && $subscription) {
            $end_at = date('Y-m-d H:i:s', $last_invoice->period->end);
            $subscription->fill(array('ends_at', $end_at))->save();
        }
    }

}
