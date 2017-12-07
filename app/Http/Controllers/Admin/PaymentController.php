<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use View;
use Yajra\Datatables\Facades\Datatables;

class PaymentController extends Controller {

    /**
     * get order history function.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Payment | History';
        if ($request->ajax()) {
            $payments = Payment::get();
            foreach ($payments as $key => $value) {
                $payments[$key]['user_name'] = $value->getUserDetails->first_name . ' ' . $value->getUserDetails->last_name;
                $payments[$key]['email'] = $value->getUserDetails->email;
//                $payments[$key]['action'] = '';
            }
            return Datatables::of($payments)->make(true);
        }
        return View::make('admin.payments.index', compact('title'));
    }

}
