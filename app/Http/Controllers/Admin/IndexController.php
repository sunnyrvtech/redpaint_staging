<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\User;
use Yajra\Datatables\Facades\Datatables;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $title = 'Redpaint | Dashboard';
        return View::make('admin.index',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
//    public function store() {
//        
//    }
//
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
//    public function destroy($id) {
//        
//    }
}
