<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClaimBusiness;
use App\Event;
use View;
use Yajra\Datatables\Facades\Datatables;

class ClaimBusinessController extends Controller {

    /**
     * listing index function
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title = 'Claim Business';
        if ($request->ajax()) {
            $claim_requests = ClaimBusiness::get();

            foreach ($claim_requests as $key => $value) {
                $claim_requests[$key]['no'] = $key + 1;
                $claim_requests[$key]['event_name'] = $value->eventInfo->name;
                $claim_requests[$key]['request_by'] = $value->useInfo->first_name . ' ' . $value->useInfo->last_name;
                $claim_requests[$key]['email'] = $value->useInfo->email;
                if ($value->useInfo->status)
                    $status = 'Active';
                else
                    $status = 'Not active';
                $claim_requests[$key]['status'] = $status;
                $claim_requests[$key]['action'] = '<a href="' . route('claim.approve', $value->id) . '" data-toggle="tooltip" title="Approved">Approved</a>';
            }


            return Datatables::of($claim_requests)->make(true);
        }
        return View::make('admin.claim_business.index', compact('title'));
    }

    /**
     * Approved function
     *
     * @return \Illuminate\Http\Response
     */
    public function claimApproved($id) {

        if ($claim_business = ClaimBusiness::find($id)) {
            if ($event = Event::find($claim_business->event_id)) {
                $event->user_id = $claim_business->user_id;
                $event->save();
                ClaimBusiness::where('event_id', $claim_business->event_id)->delete();
                return redirect()->back()
                                ->with('success-message', 'Successfully Approved !');
            }
        }
        return redirect()->back()
                        ->with('error-message', 'Something went wrong .Please try again later!');
    }

}
