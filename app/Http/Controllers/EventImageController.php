<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventImage;
use Auth;
use View;

class EventImageController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        
    }

    /**
     * function to get all event images based on event id.
     *
     * @return Response
     */
    public function getAllEventImages(Request $request, $slug) {
        $events = Event::Where('event_slug', $slug)->first();
        $view = View::make('events.all_images', compact('events'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $slug) {
        die('helo');
        $events = Event::Where('event_slug', $slug)->first();
        if ($events) {
            $event_images = array();
            //if ($events->user_id == Auth::id()) {  // this is used to check if event is related to owner
            $event_images = EventImage::Where(['user_id' => Auth::id(), 'event_id' => $events->id])->get();
            //}
//            else {
//                $event_images = EventImage::Where(['user_id' => Auth::id(), 'event_id' => $events->id])->get();
//            }
            $view = View::make('events.upload', compact('events', 'event_images'));
            if ($request->wantsJson()) {
                $sections = $view->renderSections();
                return $sections['content'];
            }
            return $view;
        }
        return redirect()->route('events.index')
                        ->with('error-message', 'No Event found!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $slug) {
        $data = $request->all();
        $this->validate($request, [
            'event_images' => 'required'
        ]);

        $events = Event::Where('event_slug', $slug)->first();

        if ($events) {
            if ($request->file('event_images')) {
                if ($request->hasFile('event_images')) {
                    $image = $request->file('event_images');
                    $imageArray = array();
                    $path = base_path('public/event_images/');
                    foreach ($image as $key => $image_val) {
                        $type = $image_val->getClientMimeType();
                        if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                            $filename = str_random(15) . '.' . $image_val->getClientOriginalExtension();
                            $image_val->move($path, $filename);
                            $imageArray[$key] = $filename;
                        }
                    }
                    $data['event_images'] = json_encode($imageArray);
                }
            }
            $data['user_id'] = Auth::id();
            $data['event_id'] = $events->id;
            $event_images = EventImage::Where(['event_id' => $events->id, 'user_id' => Auth::id()])->first();
            if ($event_images) {
                $eventimageArray = array_merge(json_decode($event_images->event_images), $imageArray);
                $event_images->fill(array('event_images' => json_encode($eventimageArray)))->save();
            } else {
                EventImage::create($data);
            }
            return redirect()->back()
                            ->with('success-message', 'Photo added successfully!');
        }
        return redirect()->back()
                        ->with('error-message', 'No Event found!');
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
            $regrex = '"([^"]*)' . $request->get('id') . '([^"]*)"';
            $event_images = EventImage::Where('event_id', $id)->whereRaw("event_images REGEXP '" . $regrex . "'")->first();
            if ($event_images) {
                $eventimageArray = json_decode($event_images->event_images);
                $key = array_search($request->get('id'), $eventimageArray);
                unset($eventimageArray[$key]);
                $eventimageArray = array_values($eventimageArray);
                if (!empty($eventimageArray))
                    $event_images->fill(array('event_images' => json_encode($eventimageArray)))->save();
                else
                    $event_images->delete();
                @unlink(base_path('public/event_images/') . $request->get('id'));
            }
            return response()->json(['success' => true, 'html' => $this->getAllEventImages($request, $events->event_slug), 'messages' => "Event image deleted successfully!"]);
        }
        return 'true';
    }

}
