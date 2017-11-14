<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\StaticPage;
use Redirect;
use Session;
use Yajra\Datatables\Facades\Datatables;

class StaticPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {

        $title = 'Static Page';

        if ($request->ajax()) {
            $static_pages = StaticPage::get();
            foreach ($static_pages as $key => $value) {
                $static_pages[$key]['action'] = '<a href="' . route('static_page.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<!--<a href="' . route('static_page.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow">--></a>';
            }
            return Datatables::of($static_pages)->make(true);
        }
        return View::make('admin.static_page.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Page | Create';
        return View::make('admin.static_page.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'title' => 'required',
        ]);
         //set null value in the empty string
        foreach ($data as $key => $value) {
            $data[$key] = empty($value) ? null : $value;
        }
        $data['slug'] = $this->createSlug($data['title']);
        StaticPage::create($data);
        return redirect()->route('static_page.index')->with('success-message', 'Added successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show($id) {
        $title = 'Static Page';
        $static_pages = StaticPage::where('id', $id)->first();
        return View::make('admin.static_page.edit', compact('title', 'static_pages'));
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function update(Request $request, $id) {
        $data = $request->all();
        $this->validate($request, [
            'title' => 'required',
        ]);

        //set null value in the empty string
        foreach ($data as $key => $value) {
            $data[$key] = empty($value) ? null : $value;
        }

        $static_pages = StaticPage::find($id);

        if (!$static_pages) {
            return Redirect::back()
                            ->with('success-message', 'Something went wrong.Please try again later!');
        } else {
            $static_pages->fill($data)->save();
            return redirect()->route('static_page.index')
                            ->with('success-message', 'Updated successfully!');
        }
    }
    
     public function createSlug($title) {
        // Normalize the title
        $slug = str_slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug);
        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug) {
        return StaticPage::select('slug')->where('slug', 'like', $slug . '%')
                        ->get();
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    // public function destroy($id) {
    //     $static_pages = StaticPage::find($id);
    //     if (!$static_pages) {
    //         Session::flash('error-message', 'Something went wrong .Please try again later!');
    //     } else {
    //         $static_pages->delete();
    //         Session::flash('success-message', 'Deleted successfully !');
    //     }
    //     return 'true';
    // }
}
