<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
use App\Event;
use View;

class CategoryController extends Controller {

    public function getSubCategory(Request $request, $id) {
        $data['sub_category'] = SubCategory::Where('category_id', $id)->orderBy('name')->get();
        return View::make('category.index', $data);
    }

    public function getEventBySubCategory(Request $request, $id) {
        $data['events'] = Event::Where('status', 1)->whereHas('getSubCategory', function($query) use($id) {
                    if ($id != null) {
                        $query->Where('sub_categories.id', '=', $id);
                    }
                })->paginate(20);
        return View::make('events.search', $data);
    }

}
