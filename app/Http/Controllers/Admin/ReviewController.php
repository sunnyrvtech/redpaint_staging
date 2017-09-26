<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Review;
use Session;
use Redirect;
use Yajra\Datatables\Facades\Datatables;

class ReviewController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Reviews';
        if ($request->ajax()) {
            $reviews = Review::with(['getUserDetails', 'getEventDetails'])->get();
            foreach ($reviews as $key => $value) {
                $reviews[$key]['comment'] = str_limit($value->comment, $limit = 15, $end = '....');
                $reviews[$key]['user_name'] = $value->getUserDetails->first_name . ' ' . $value->getUserDetails->last_name;
                $reviews[$key]['event_name'] = $value->getEventDetails->name;
                if ($value->status == 1) {
                    $reviews[$key]['status'] = '<div class="btn-group status-toggle" data-id="' . $value->id . '" data-url="' . route('reviews-status') . '"><button class="btn active btn-primary" data-value="1">Active</button><button class="btn btn-default" data-value="0">Deactivate</button></div>';
                } else {
                    $reviews[$key]['status'] = '<div class="btn-group status-toggle" data-id="' . $value->id . '" data-url="' . route('reviews-status') . '"><button class="btn btn-default" data-value="1">Active</button><button class="btn active btn-primary" data-value="0">Deactivate</button></div>';
                }
                $reviews[$key]['action'] = '<a href="' . route('reviews.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('reviews.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($reviews)->make(true);
        }
        return View::make('admin.reviews.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
//    public function create() {
//        
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
//    public function store(Request $request) {
//
//    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Review | update';
        $reviews = Review::where('id', $id)->first();
        return View::make('admin.reviews.edit', compact('title', 'reviews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $data = $request->all();
        $this->validate($request, [
            'rate' => 'required',
            'comment' => 'required|max:1000',
        ]);

        $reviews = Review::Where('id', $id)->first();

        if ($reviews) {
            $reviews->fill($data)->save();
            return redirect()->route('reviews.index')
                            ->with('success-message', 'Review updated successfully!');
        }
        return redirect()->route('reviews.index')
                        ->with('error-message', 'Something went wrong .Please try again later!');
    }

    /**
     * function to update review status
     *
     * @param  int  $id
     * @return Response
     */
    public function reviewStatus(Request $request) {
        $id = $request->get('id');
        $status = $request->get('status');

        $reviews = Review::find($id);

        if (!$reviews) {
            return response()->json(array('error' => 'Something went wrong.Please try again later!'), 401);
        } else {
            $reviews->fill(array('status' => $status))->save();
            return response()->json(['success' => true, 'messages' => "Review updated successfully!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $reviews = Review::find($id);
        if (!$reviews) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $reviews->delete();
            Session::flash('success-message', 'Deleted successfully !');
        }
        return 'true';
    }

}
