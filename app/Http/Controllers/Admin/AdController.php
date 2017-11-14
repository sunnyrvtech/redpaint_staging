<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Redirect;
use App\Ad;
use Session;
use URL;
use Yajra\Datatables\Facades\Datatables;

class AdController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Ads';
        if ($request->ajax()) {
            $ads = Ad::with(['getUserDetails'])->get();
            foreach ($ads as $key => $value) {
                $ads[$key]['user_name'] = $value->getUserDetails->first_name . ' ' . $value->getUserDetails->last_name;
                $ads[$key]['banner'] = '<img width="200px" id="blah" src="' . URL::asset('/ads_images') . '/' . $value->banner . '">';
                $ads[$key]['action'] = '<a href="' . route('ads_list.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('ads_list.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($ads)->make(true);
        }
        return View::make('admin.ads.index', compact('title'));
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
        $title = 'Ads | update';
        $ads = Ad::where('id', $id)->first();
        return View::make('admin.ads.edit', compact('title', 'ads'));
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
            'name' => 'required|max:100',
            'link' => 'required',
            'banner' => 'dimensions:max_width=780,max_height=90,min_width=500,min_height=60'
        ], ['banner.dimensions' => 'Banner dimention should be following max_width=780,max_height=90,min_width=500,min_height=60']);

        $ads = Ad::Where('id', $id)->first();

        if ($ads) {
            if ($request->hasFile('banner')) {
                $image = $request->file('banner');
                $type = $image->getClientMimeType();
                if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $path = base_path('public/ads_images/');
                    @unlink($path . $ads->banner);
                    $image->move($path, $filename);
                    $data['banner'] = $filename;
                }
            }
            $ads->fill($data)->save();
            return redirect()->route('ads_list.index')
                            ->with('success-message', 'Ad updated successfully!');
        }
        return redirect()->route('ads.index')
                        ->with('error-message', 'Something went wrong .Please try again later!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $ads = Ad::find($id);
        if (!$ads) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            @unlink(base_path('public/ads_images/') . $ads->banner);
            $ads->delete();
            Session::flash('success-message', 'Ad deleted successfully !');
        }
        return 'true';
    }

}
