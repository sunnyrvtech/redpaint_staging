<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Event;
use App\EventImage;
use Auth;
use View;

class EventController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $events = Event::Where('user_id', Auth::id())->get();
        $view = View::make('events.index', compact('events'));
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
    public function create(Request $request) {
        $categories = Category::Where('status', 1)->get();
        return View::make('events.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required|max:100',
            'category_id' => 'required',
            'date' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'price_to' => 'required',
            'price_from' => 'required',
        ]);
        $data['user_id'] = Auth::id();
        $data['event_slug'] = $this->createSlug($data['name']);
        Event::create($data);
        return redirect()->route('events.index')
                        ->with('success-message', 'Event created successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $events = Event::where(['id' => $id, 'user_id' => Auth::id()])->first();
        $categories = Category::Where('status', 1)->get();
        if (!$events) {
            return redirect()->route('events.index')
                            ->with('error-message', 'Event not found!');
        }
        return View::make('events.edit', compact('events', 'categories'));
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
            'category_id' => 'required',
            'date' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'price_to' => 'required',
            'price_from' => 'required',
        ]);

        $events = Event::Where(['id' => $id, 'user_id' => Auth::id()])->first();


        if ($events) {
            $events->fill($data)->save();
            return redirect()->route('events.index')
                            ->with('success-message', 'Event updated successfully!');
        }
        return redirect()->route('events.index')
                        ->with('error-message', 'Something went wrong .Please try again later!');
    }

    /**
     * function to update event status
     *
     * @param  int  $id
     * @return Response
     */
    public function eventStatus(Request $request, $id) {
        $check_status = $request->get('id');

        if ($check_status == 'Activate') {
            $status = 1;
        } else {
            $status = 0;
        }

        $event = Event::Where(['id' => $id, 'user_id' => Auth::id()])->first();

        if (!$event) {
            return response()->json(array('error' => 'Something went wrong.Please try again later!'), 401);
        } else {
            $event->fill(array('status' => $status))->save();
            return response()->json(['success' => true, 'html' => $this->index($request), 'messages' => "Event " . $check_status . " successfully!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id) {
        $events = Event::Where(['id' => $id, 'user_id' => Auth::id()])->first();

        if (!$events) {
            return response()->json(array('error' => 'Something went wrong .Please try again later!'), 401);
        } else {
            $events->delete();
            return response()->json(['success' => true, 'html' => $this->index($request), 'messages' => "Event deleted successfully !"]);
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
        return Event::select('event_slug')->where('event_slug', 'like', $slug . '%')
                        ->get();
    }

}
