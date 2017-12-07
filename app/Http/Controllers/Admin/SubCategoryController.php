<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Redirect;
use App\Category;
use App\SubCategory;
use Session;
use Yajra\Datatables\Facades\Datatables;
use DB;

class SubCategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {

        $category_id = $request->get('category_id');

        if ($request->ajax()) {

            $sub_cat_result = DB::table('sub_categories as sc')
                    ->join('categories as c', 'c.id', '=', 'sc.category_id')
                    ->where('sc.category_id', $category_id)
                    ->get(['sc.*', 'c.name as category_name']);
            foreach ($sub_cat_result as $key => $value) {
//                $sub_cat_result[$key]->action = '<a href="' . route('subsubcategories-show', $value->id) . '" data-toggle="tooltip" title="View Sub Sub Category" class="glyphicon glyphicon-eye-open"></a>&nbsp;&nbsp;<a href="' . route('subcategories.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('subcategories.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
                $sub_cat_result[$key]->action = '<a href="' . route('subcategories.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('subcategories.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($sub_cat_result)->make(true);
        }
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Sub-Categories | create';
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $categories->prepend('Select Category', '');
        //$vehicles = VehicleCompany::pluck('name', 'id');
        //$vehicles->prepend('Select Vehicle Make', '');
        return View::make('admin.sub_categories.add', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'category_id' => 'required',
//            'vehicle_company_id' => 'required',
            'name' => 'required|unique:sub_categories|max:100'
//            'category_picture' => 'required'
        ]);

        $data['slug'] = $this->createSlug($data['name']);

//        if ($request->file('category_picture')) {
//            if ($request->hasFile('category_picture')) {
//                $image = $request->file('category_picture');
//                $type = $image->getClientMimeType();
//                if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
//                    $filename = time() . '.' . $image->getClientOriginalExtension();
//                    $path = base_path('public/category/');
//                    $image->move($path, $filename);
//                    $data['category_image'] = $filename;
//                }
//            }
//        }

        $sub_category = SubCategory::create($data);
        return Redirect::route('subcategories-show', $request->get('category_id'))
                        ->with('success-message', 'Sub category inserted successfully!');
    }

    /**
     * show sub category function.
     *
     * @return Response
     */
    public function showSubCategory($id) {
        $category_id = $id;
        $title = 'Sub-Categories';
        $ajaxURL = route('subcategories.index') . '?category_id=' . $category_id;
        return View::make('admin.sub_categories.index', compact('title', 'ajaxURL'));
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show($id) {
        $title = 'Sub-Categories';
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $sub_categories = SubCategory::where('id', $id)->first();
        return View::make('admin.sub_categories.edit', compact('title', 'categories', 'sub_categories'));
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
            'category_id' => 'required',
//            'vehicle_company_id' => 'required',
            'name' => 'required|max:100|unique:sub_categories,name,' . $id
//            'category_picture' => 'required'
        ]);

//        if ($request->file('category_picture')) {
//            if ($request->hasFile('category_picture')) {
//                $image = $request->file('category_picture');
//                $type = $image->getClientMimeType();
//                if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
//                    $filename = time() . '.' . $image->getClientOriginalExtension();
//                    $path = base_path('public/category/');
//                    $image->move($path, $filename);
//                    $data['category_image'] = $filename;
//                }
//            }
//        }


        $sub_categories = SubCategory::find($id);

        if (!$sub_categories) {
            return Redirect::route('subcategories-show', $request->get('category_id'))
                            ->with('success-message', 'Something went wrong.Please try again later!');
        } else {
            $sub_categories->fill($data)->save();
            return Redirect::route('subcategories-show', $request->get('category_id'))
                            ->with('success-message', 'Sub category updated successfully!');
        }
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function destroy($id) {
        $sub_categories = SubCategory::find($id);

        if (!$sub_categories) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $sub_categories->delete();
            Session::flash('success-message', 'Sub category deleted successfully !');
        }
        return 'true';
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
        return SubCategory::select('slug')->where('slug', 'like', $slug . '%')
                        ->get();
    }

}
