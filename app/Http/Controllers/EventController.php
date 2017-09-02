<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class EventController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return View::make('events.index');
    }

}
