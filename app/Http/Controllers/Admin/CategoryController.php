<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Redirect;
use App\Category;
use Session;
use Yajra\Datatables\Facades\Datatables;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Categories';
        if ($request->ajax()) {
            $categories = Category::get();
            foreach ($categories as $key => $value) {
                $categories[$key]['action'] = '<a href="' . route('subcategories-show', $value->id) . '" data-toggle="tooltip" title="View Sub Category" class="glyphicon glyphicon-eye-open"></a>&nbsp;&nbsp;<a href="' . route('categories.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('categories.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
                if ($value->status == 1) {
                    $categories[$key]['status'] = '<div class="btn-group status-toggle" data-id="' . $value->id . '" data-url="' . route('categories-status') . '"><button class="btn active btn-primary" data-value="1">ON</button><button class="btn btn-default" data-value="0">OFF</button></div>';
                } else {
                    $categories[$key]['status'] = '<div class="btn-group status-toggle" data-id="' . $value->id . '" data-url="' . route('categories-status') . '"><button class="btn btn-default" data-value="1">ON</button><button class="btn active btn-primary" data-value="0">OFF</button></div>';
                }
            }
            return Datatables::of($categories)->make(true);
        }
        return View::make('admin.categories.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Categories | create';
        return View::make('admin.categories.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required|unique:categories|max:100'
//            'class_name' => 'required'
        ]);

        Category::create($data);
        return redirect()->route('categories.index')
                        ->with('success-message', 'Category inserted successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Categories | update';
        $categories = Category::where('id', $id)->first();
        return View::make('admin.categories.edit', compact('title', 'categories'));
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
            'name' => 'required|max:100|unique:categories,name,' . $id
//            'class_name' => 'required'
        ]);

        $categories = Category::findOrFail($id);
        $categories->fill($data)->save();
        return redirect()->route('categories.index')
                        ->with('success-message', 'Category updated successfully!');
    }

    /**
     * function to update category status
     *
     * @param  int  $id
     * @return Response
     */
    public function categoryStatus(Request $request) {
        $id = $request->get('id');
        $status = $request->get('status');

        $categories = Category::find($id);

        if (!$categories) {
            return response()->json(array('error' => 'Something went wrong.Please try again later!'), 401);
        } else {
            $categories->fill(array('status' => $status))->save();
            return response()->json(['success' => true, 'messages' => "Status updated successfully!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $categories = Category::find($id);

        if (!$categories) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $categories->delete();
            Session::flash('success-message', 'Category deleted successfully !');
        }
        return 'true';
    }

}
