<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;
use Auth;
use View;

class AdController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $ads = Ad::Where('user_id', Auth::id())->first();
        $view = View::make('ads.index', compact('ads'));
         if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Ads | create';
        return View::make('ads.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $ads = Ad::Where('user_id', Auth::id())->first();
        if ($ads) {
            return redirect()->route('ads.index')
                            ->with('error-message', 'only one ad is allowed to add!');
        }

        $data = $request->all();
        $this->validate($request, [
            'name' => 'required|max:100',
            'link' => 'required',
            'banner' => 'required|dimensions:max_width=780,max_height=90,min_width=500,min_height=60'
        ], ['banner.dimensions' => 'Banner should meet the following dimention max_width=780,max_height=90,min_width=500,min_height=60']);

        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $type = $image->getClientMimeType();
            if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = base_path('public/ads_images/');
                $image->move($path, $filename);
                $data['banner'] = $filename;
            }
        }

        $data['user_id'] = Auth::id();

        Ad::create($data);
        return redirect()->route('ads.index')
                        ->with('success-message', 'Ad added successfully!');
    }
    
    /**
     * function to get all ads space
     *
     * @return Response
     */
    public function getAllAds(Request $request){
        $ads = Ad::paginate(20);
        $data['ads'] = $ads;
        return View::make('ads.all', $data);
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Ads | update';
        $ads = Ad::where(['id' => $id, 'user_id' => Auth::id()])->first();
        if (!$ads) {
            return redirect()->route('events.index')
                            ->with('error-message', 'Ad not found!');
        }
        return View::make('ads.edit', compact('ads'));
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
        ]);

        $ads = Ad::Where(['id' => $id, 'user_id' => Auth::id()])->first();


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
            return redirect()->route('ads.index')
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
    public function destroy(Request $request,$id) {
        $ads = Ad::Where(['id' => $id, 'user_id' => Auth::id()])->first();

        if (!$ads) {
            return response()->json(array('error' => 'Something went wrong .Please try again later!'), 401);
        } else {
            @unlink(base_path('public/ads_images/') . $ads->banner);
            $ads->delete();
            return response()->json(['success' => true, 'html' => $this->index($request), 'messages' => "Ad deleted successfully !"]);
        }
        return 'true';
    }

}
