<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Event;
use App\Ad;
use App\Review;
use App\Country;
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
        $events = Event::Where('user_id', Auth::id())->paginate(20);
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
        $countries = Country::get();
        return View::make('events.add', compact('categories', 'countries'));
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
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'country_id' => 'required',
            'price_to' => 'required',
            'price_from' => 'required',
        ]);


        $lat_long = $this->getLatLong($data['country_id'], $data['state'], $data['city'], $data['address'], $data['zip']);

        $data['formatted_address'] = $data['address'] . ',' . $data['city'] . ',' . $data['state'];
        $data['latitude'] = $lat_long['latitude'];
        $data['longitude'] = $lat_long['longitude'];
        
        $operation_hour = array();
        foreach ($data['day'] as $key => $val) {
            $hour_array = array(
                'day' => $val,
                'time_from' => $data['time_from'][$key],
                'time_to' => $data['time_to'][$key],
                'status' => $data['status'][$key]
            );
            $operation_hour[$key] = $hour_array;
        }

        $data['operation_hour'] = json_encode($operation_hour);
        unset($data['day']);
        unset($data['time_from']);
        unset($data['time_to']);
        unset($data['status']);
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
        $countries = Country::get();
        if (!$events) {
            return redirect()->route('events.index')
                            ->with('error-message', 'Event not found!');
        }
        return View::make('events.edit', compact('events', 'categories', 'countries'));
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
            'country_id' => 'required',
            'price_to' => 'required',
            'price_from' => 'required',
        ]);

        $lat_long = $this->getLatLong($data['country_id'], $data['state'], $data['city'], $data['address'], $data['zip']);

        $data['formatted_address'] = $data['address'] . ',' . $data['city'] . ',' . $data['state'];
        $data['latitude'] = $lat_long['latitude'];
        $data['longitude'] = $lat_long['longitude'];
        
        $operation_hour = array();
        foreach ($data['day'] as $key => $val) {
            $hour_array = array(
                'day' => $val,
                'time_from' => $data['time_from'][$key],
                'time_to' => $data['time_to'][$key],
                'status' => $data['status'][$key]
            );
            $operation_hour[$key] = $hour_array;
        }

        $data['operation_hour'] = json_encode($operation_hour);
        unset($data['day']);
        unset($data['time_from']);
        unset($data['time_to']);
        unset($data['status']);

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
     * function to get latitude and longitude.
     *
     * @return Response
     */
    public function getLatLong($country_id, $state, $city, $address, $zip) {
        $country = Country::where('id', $country_id)->first();
        $address = str_replace(" ", "+", $country->name) . "+" . str_replace(" ", "+", $state) . "+" . str_replace(" ", "+", $city) . "+" . str_replace(" ", "+", $address) . "+" . $zip;
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        if (isset($response_a->results[0]->geometry->location->lat)) {
            $result['latitude'] = $response_a->results[0]->geometry->location->lat;
            $result['longitude'] = $response_a->results[0]->geometry->location->lng;
        } else {
            $result['latitude'] = null;
            $result['longitude'] = null;
        }
        return $result;
    }

    /**
     * function to get event details by event slug
     *
     * @param  int  $id
     * @return Response
     */
    public function getEventByslug(Request $request, $slug) {
        $events = Event::Where('event_slug', $slug)->first();
        $ads = Ad::get();
        $checkUserReviewStatus = 0; //set as false
        if ($events) {
            $checkUserReviewStatus = Review::Where(['user_id' => Auth::id(), 'event_id' => $events->id])->first(array('status'));
        }
        return View::make('events.view', compact('events', 'checkUserReviewStatus','ads'));
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
     * function to add review
     *
     * @param  int  $id
     * @return Response
     */
    public function addReview(Request $request, $id) {
        $this->validate($request, [
            'rate' => 'required',
            'comment' => 'required|max:1000',
        ]);

        $data = array(
            'user_id' => Auth::id(),
            'event_id' => $id,
            'rate' => $request->get('rate'),
            'comment' => $request->get('comment')
        );
        if (Review::Where(['event_id' => $id, 'user_id' => Auth::id()])->count() == 0) {
            Review::create($data);
            return redirect()->back()
                            ->with('success-message', 'Your review has been submitted successfully and it will display after approved by administrator!');
        }
        return redirect()->back()
                        ->with('error-message', 'You have already submit your review for this event!');
    }

    /**
     * function to search events
     *
     * @param  int  $id
     * @return Response
     */
    public function searchEvent(Request $request) {
        $category = $request->get('category');
        $address = $request->get('address');

        $events = Event::Where('events.formatted_address', 'LIKE', '%' . $address . '%')
                        ->whereHas('getCategory', function($query) use($category) {
                            $query->Where('categories.name', 'LIKE', '%' . $category . '%');
                        })->get();

        return View::make('events.search', compact('events'));
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

    /**
     * funtion to get category by autosearch .
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryAutosearch(Request $request) {
        $categories = Category::Where('name', 'LIKE', '%' . $request->get('query') . '%')->pluck('name');
        return $categories;
    }

    /**
     * funtion to get address by autosearch .
     *
     * @return \Illuminate\Http\Response
     */
    public function addressAutosearch(Request $request) {
        $address = $request->get('query');
        $events = Event::Where(function($query) use ($address) {
                    $query->Where('address', 'LIKE', '%' . $address . '%')
                            ->orWhere('city', 'LIKE', '%' . $address . '%')
                            ->orWhere('state', 'LIKE', '%' . $address . '%');
                })->get();
    }

}
