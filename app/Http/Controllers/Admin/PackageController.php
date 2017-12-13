<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Package;
use Stripe\Stripe;
use Stripe\Plan;
use Stripe\Error\InvalidRequest;
use Session;
use Redirect;
use Yajra\Datatables\Facades\Datatables;

class PackageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Packages';

        if ($request->ajax()) {
            $packages = Package::all();

            foreach ($packages as $key => $value) {
                $packages[$key]['action'] = '<a href="' . route('packages.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($packages)->make(true);
        }
        return View::make('admin.packages.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Packages | create';
        $interval = array(
            '' => 'Choose Duration',
            'day' => 'Day',
            'week' => 'Week',
            'month' => 'Month',
            'every 6 months' => 'Every 6 months',
            'year' => 'Year',
        );
        return View::make('admin.packages.add', compact('title', 'interval'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            Plan::create(array(
                "amount" => $data['price'] * 100,
                "interval" => $data['duration'],
                "name" => $data['name'],
                "currency" => "usd",
                "id" => $data['name'])
            );
        } catch (InvalidRequest $e) {
            return Redirect::back()
                            ->with('error-message', $e->getMessage());
        }
        $data['plan_id'] = $data['name'];
        Package::create($data);

        return redirect()->route('packages.index')
                        ->with('success-message', 'Subscription created successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
//    public function show($id) {
//       
//        
//    }
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function update($id) {
//        
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function destroy($id) {
        $package = Package::find($id);
        if (!$package) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            try {
                $plan = Plan::retrieve($package->plan_id);
                $plan->delete();   // delete plan at stripe end
                $package->delete();  /// delete from our database
                Session::flash('success-message', 'Deleted successfully !');
                return 'true';
            } catch (InvalidRequest $e) {
                Session::flash('error-message', $e->getMessage());
                return 'true';
            }
        }
        return 'true';
    }

}
