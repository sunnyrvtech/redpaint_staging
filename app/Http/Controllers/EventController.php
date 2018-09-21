<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Event;
use App\Ad;
use App\Review;
use App\EventLike;
use App\Country;
use App\EventImage;
use Image;
use App\Http\Controllers\Admin\SubCategoryController;
use Auth;
use View;
use DB;
use Carbon\Carbon;

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
    public function store(Request $request, SubCategoryController $sub_cat_controller) {
        $data = $request->all();
        //$data['start_date'] = $data['start_date'] != null ? Carbon::parse($data['start_date'])->format('Y-m-d H:i:s') : null;
        //$data['end_date'] = $data['end_date'] != null ? Carbon::parse($data['end_date'])->format('Y-m-d H:i:s') : null;

        $this->validate($request, [
            'name' => 'required|max:100',
            'category_id' => 'required',
//            'sub_category' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'country_id' => 'required',
            'price_to' => 'required|numeric',
            'price_from' => 'required|numeric',
            'event_image' => 'required|image|mimes:jpeg,png,jpg',
        ]);
        if ($request->get('sub_category') != null) {
            if (!$sub_category = SubCategory::Where('name', 'like', trim($request->get('sub_category')))->first()) {
                $data['slug'] = $sub_cat_controller->createSlug($data['sub_category']);
                $sub_data = $data;
                $sub_data['name'] = $sub_data['sub_category'];
                $sub_category = SubCategory::create($sub_data);
            }
            $data['sub_category_id'] = $sub_category->id;
        } else {
            $data['sub_category_id'] = null;
        }
        $lat_long = $this->getLatLong($data['country_id'], $data['state'], $data['city'], $data['address'], $data['zip']);

        $data['formatted_address'] = $data['address'] . ',' . $data['city'] . ',' . $data['state'];
        $data['latitude'] = $lat_long['latitude'];
        $data['longitude'] = $lat_long['longitude'];

        $operation_hour = array();
        $brunch_hour = array();
        $happy_hour = array();
        $daily_deal = array();
        $brunch_time_from = false;
        $happy_time_from = false;
        foreach ($data['day'] as $key => $val) {
            $operation_hour[$key] = array(
                'day' => $val,
                'time_from' => $data['time_from'][$key],
                'time_to' => $data['time_to'][$key]
            );
            if (isset($data['status' . $key])) {
                $operation_hour[$key]['time_from'] = null;
                $operation_hour[$key]['time_to'] = null;
            }
            if (!empty($operation_hour[$key]['time_from']) && !empty($operation_hour[$key]['time_to'])) {
                $operation_hour[$key]['status'] = 1;
            } else {
                $operation_hour[$key]['status'] = 0;
            }
            if ($data['brunch_time_from'][$key]) {
                $brunch_time_from = true;
            }
            $brunch_hour[$key] = array(
                'day' => $val,
                'time_from' => $data['brunch_time_from'][$key],
                'time_to' => $data['brunch_time_to'][$key],
            );
            if ($data['happy_time_from'][$key]) {
                $happy_time_from = true;
            }
            $happy_hour[$key] = array(
                'day' => $val,
                'time_from' => $data['happy_time_from'][$key],
                'time_to' => $data['happy_time_to'][$key],
            );
            $daily_deal[$val] = $data['deal_name'][$key] != null ? $data['deal_name'][$key] : 'null';
        }

        $data['operation_hour'] = json_encode($operation_hour);
        if ($brunch_time_from)
            $data['brunch_hour'] = json_encode($brunch_hour);
        else
            $data['brunch_hour'] = null;
        if ($happy_time_from)
            $data['happy_hour'] = json_encode($happy_hour);
        else
            $data['happy_hour'] = null;
        $data['daily_deal'] = json_encode($daily_deal);
        if ($request->get('parking') != null) {
            $data['parking'] = json_encode($data['parking']);
        }
//        unset($data['day']);
//        unset($data['time_from']);
//        unset($data['time_to']);
//        unset($data['status']);
        $data['user_id'] = Auth::id();
        $data['event_slug'] = $this->createSlug($data['name']);

        $filename = null;
        if ($request->file('event_image')) {
            if ($request->hasFile('event_image')) {
                $image = $request->file('event_image');
                $path = base_path('public/event_images/');
                $type = $image->getClientMimeType();
                if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                    $filename = str_random(15) . '.' . $image->getClientOriginalExtension();
                    $image = Image::make($image)->orientate();
                    $image->save($path . '/' . $filename);
                }
            }
        }

        if ($filename != null && $event = Event::create($data)) {
            $event_images = EventImage::Where(['event_id' => $event->id, 'user_id' => Auth::id()])->first();
            if ($event_images) {
                $event_images->fill(array('event_images' => json_encode(array($filename))))->save();
            } else {
                $data['event_id'] = $event->id;
                $data['event_images'] = json_encode(array($filename));
                EventImage::create($data);
            }
        } else {
            return redirect()->back()
                            ->with('error-message', 'Business not saved, something is wrong please try again later!');
        }



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

        $data['events'] = $events;
        $data['categories'] = $categories;
        $data['countries'] = $countries;

        if (!$events) {
            return redirect()->route('events.index')
                            ->with('error-message', 'Event not found!');
        }
        return View::make('events.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id, SubCategoryController $sub_cat_controller) {
        $data = $request->all();
        //$data['start_date'] = $data['start_date'] != null ? Carbon::parse($data['start_date'])->format('Y-m-d H:i:s') : null;
        //$data['end_date'] = $data['end_date'] != null ? Carbon::parse($data['end_date'])->format('Y-m-d H:i:s') : null;

        $this->validate($request, [
            'name' => 'required|max:100',
            'category_id' => 'required',
//            'sub_category' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'country_id' => 'required',
            'price_to' => 'required|numeric',
            'price_from' => 'required|numeric',
        ]);

        if ($request->get('sub_category') != null) {
            if (!$sub_category = SubCategory::Where('name', 'like', trim($request->get('sub_category')))->first()) {
                $data['slug'] = $sub_cat_controller->createSlug($data['sub_category']);
                $sub_data = $data;
                $sub_data['name'] = $sub_data['sub_category'];
                $sub_category = SubCategory::create($sub_data);
            }
            $data['sub_category_id'] = $sub_category->id;
        } else {
            $data['sub_category_id'] = null;
        }

        $lat_long = $this->getLatLong($data['country_id'], $data['state'], $data['city'], $data['address'], $data['zip']);

        $data['formatted_address'] = $data['address'] . ',' . $data['city'] . ',' . $data['state'];
        $data['latitude'] = $lat_long['latitude'];
        $data['longitude'] = $lat_long['longitude'];

        $operation_hour = array();
        $brunch_hour = array();
        $happy_hour = array();
        $daily_deal = array();
        $brunch_time_from = false;
        $happy_time_from = false;
        foreach ($data['day'] as $key => $val) {
            $operation_hour[$key] = array(
                'day' => $val,
                'time_from' => $data['time_from'][$key],
                'time_to' => $data['time_to'][$key]
            );
            if (isset($data['status' . $key])) {
                $operation_hour[$key]['time_from'] = null;
                $operation_hour[$key]['time_to'] = null;
            }
            if (!empty($operation_hour[$key]['time_from']) && !empty($operation_hour[$key]['time_to'])) {
                $operation_hour[$key]['status'] = 1;
            } else {
                $operation_hour[$key]['status'] = 0;
            }

            if ($data['brunch_time_from'][$key]) {
                $brunch_time_from = true;
            }
            $brunch_hour[$key] = array(
                'day' => $val,
                'time_from' => $data['brunch_time_from'][$key],
                'time_to' => $data['brunch_time_to'][$key],
            );
            if ($data['happy_time_from'][$key]) {
                $happy_time_from = true;
            }
            $happy_hour[$key] = array(
                'day' => $val,
                'time_from' => $data['happy_time_from'][$key],
                'time_to' => $data['happy_time_to'][$key],
            );
            $daily_deal[$val] = $data['deal_name'][$key] != null ? $data['deal_name'][$key] : 'null';
        }

        $data['operation_hour'] = json_encode($operation_hour);
        if ($brunch_time_from)
            $data['brunch_hour'] = json_encode($brunch_hour);
        else
            $data['brunch_hour'] = null;
        if ($happy_time_from)
            $data['happy_hour'] = json_encode($happy_hour);
        else
            $data['happy_hour'] = null;
        $data['daily_deal'] = json_encode($daily_deal);
        if ($request->get('parking') != null) {
            $data['parking'] = json_encode($data['parking']);
        } else {
            $data['parking'] = null;
        }
        $events = Event::Where(['id' => $id, 'user_id' => Auth::id()])->first();

        if ($events) {
            if ($request->file('event_image')) {
                if ($request->hasFile('event_image')) {
                    $image = $request->file('event_image');
                    $path = base_path('public/event_images/');
                    $type = $image->getClientMimeType();
                    if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                        $filename = str_random(15) . '.' . $image->getClientOriginalExtension();
                        $image = Image::make($image)->orientate();
                        $image->save($path . '/' . $filename);
                    }
                }

                $event_images = EventImage::Where(['event_id' => $events->id, 'user_id' => Auth::id()])->first();
                $eventimageArray = array_merge(array($filename), json_decode($event_images->event_images));
                $event_images->fill(array('event_images' => json_encode($eventimageArray)))->save();
            }
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
        $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyDZGTC412EEKYBmKXxH9VFnE97fKNsu0zQ&address=$address&sensor=false";
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
        $data['events'] = Event::Where('event_slug', $slug)->first();
        $data['event_by_cat'] = Event::Where(['status' => 1, 'category_id' => $data['events']->category_id])->Where('id', '!=', $data['events']->id)->orderby('created_at', 'DESC')->take(5)->get();
        $data['ads'] = Ad::get();
        $data['checkUserReviewStatus'] = 0; //set as false
        if ($data['events']) {
            $checkUserReviewStatus = Review::Where(['user_id' => Auth::id(), 'event_id' => $data['events']->id])->first(array('status'));
        }
        $data['check_count'] = EventLike::Where([['user_id', '=', Auth::id()], ['event_id', '=', $data['events']->id]])->count();
        $view = View::make('events.view', $data);
        return $view;
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
//            'rate' => 'required',
            'comment' => 'required|max:1000',
        ]);

        $data = array(
            'user_id' => Auth::id(),
            'event_id' => $id,
//            'rate' => $request->get('rate'),
            'comment' => $request->get('comment'),
            'status' => 1,
        );
        if (Review::Where(['event_id' => $id, 'user_id' => Auth::id()])->count() == 0) {
            Review::create($data);
            return redirect()->back()
                            ->with('success-message', 'Your review has been submitted successfully !');
        }
        return redirect()->back()
                        ->with('error-message', 'You have already submit your review for this event!');
    }

    /**
     * function to add & remove event likes 
     *
     * @param  int  $id
     * @return Response
     */
    public function addEventLikes(Request $request) {
        $data = $request->all();
        $events = EventLike::Where([['user_id', '=', Auth::id()], ['event_id', '=', $data['event_id']]])->first();
        $like_class = false;
        $like_txt = 'Like';
        $like_title = 'Like';
        if (!$events) {
            $data['user_id'] = Auth::id();
            EventLike::create($data);
            $like_txt = 'Liked';
            $like_title = 'Unlike';
            $like_class = true;
        } else {
            $events->delete();
        }

        $like_count = EventLike::Where('event_id', '=', $data['event_id'])->count();
        return response()->json(['success' => true, 'like_count' => $like_count, 'like_txt' => $like_txt, 'like_class' => $like_class, 'like_title' => $like_title]);
    }

    /**
     * function to search events
     *
     * @param  int  $id
     * @return Response
     */
    public function searchEvent(Request $request) {

        $miles = 20;
        $lat = $request->session()->get('latitude');
        $lng = $request->session()->get('longitude');

        $distant_array['lat_dist_minus'] = $lat - ($miles * 0.018);
        $distant_array['lat_dist_plus'] = $lat + ($miles * 0.018);
        $distant_array['lng_dist_minus'] = $lng - ($miles * 0.018);
        $distant_array['lng_dist_plus'] = $lng + ($miles * 0.018);

        $keyword = $request->get('keyword');
        $address = $request->get('address');
        $days = $request->get('day');

        $happy_keywords = array('happy', 'happy hour');
        $brunch_keywords = array('brunch', 'brunch hour');
        $hour_check = false;
        if (in_array($keyword, $happy_keywords)) {
            $hour_check = 'happy_hour';
        } else if (in_array($keyword, $brunch_keywords)) {
            $hour_check = 'brunch_hour';
        }

        if ($hour_check) {
            $events = Event::Where('status', 1)->Where(function($query) use ($distant_array, $hour_check) {
                        $query->whereNotNull($hour_check)
                                ->WhereBetween('latitude', [$distant_array['lat_dist_minus'], $distant_array['lat_dist_plus']])
                                ->WhereBetween('longitude', [$distant_array['lng_dist_minus'], $distant_array['lng_dist_plus']]);
                    })->paginate(20);
        } else {
            if ($keyword != null && $keyword != 'recent_events' && $keyword != 'daily_deals') {
                $events = Event::Where('status', 1)->Where(function($query) use ($keyword, $address, $distant_array) {
                            if ($address != null) {
                                $query->Where('events.name', 'LIKE', '%' . $keyword . '%')
                                        ->orWhere('events.formatted_address', 'LIKE', '%' . $address . '%');
                            } else {
                                $query->Where('events.name', 'LIKE', '%' . $keyword . '%');
                            }
                        })->orwhereHas('getCategory', function($query) use($keyword, $distant_array) {
                            if ($keyword != null) {
                                $query->Where('categories.name', 'LIKE', '%' . $keyword . '%')
                                        ->WhereBetween('latitude', [$distant_array['lat_dist_minus'], $distant_array['lat_dist_plus']])
                                        ->WhereBetween('longitude', [$distant_array['lng_dist_minus'], $distant_array['lng_dist_plus']]);
                            }
                        })->orwhereHas('getSubCategory', function($query) use($keyword, $distant_array) {
                            if ($keyword != null) {
                                $query->Where('sub_categories.name', 'LIKE', '%' . $keyword . '%')
                                        ->WhereBetween('latitude', [$distant_array['lat_dist_minus'], $distant_array['lat_dist_plus']])
                                        ->WhereBetween('longitude', [$distant_array['lng_dist_minus'], $distant_array['lng_dist_plus']]);
                            }
                        })->paginate(20);
            } elseif ($address != null) {
                $events = Event::Where('status', 1)->Where(function($query) use ($address) {
                            if ($address != null) {
                                $query->Where('events.formatted_address', 'LIKE', '%' . $address . '%');
                            }
                        })->orWhere(function($query) use ($distant_array) {
                            $query->WhereBetween('latitude', [$distant_array['lat_dist_minus'], $distant_array['lat_dist_plus']])
                                    ->WhereBetween('longitude', [$distant_array['lng_dist_minus'], $distant_array['lng_dist_plus']]);
                        })->paginate(20);
            } elseif ($keyword == 'recent_events') {
                $events = Event::Where('status', 1)->Where(function($query) use ($distant_array) {
                            $query->WhereBetween('latitude', [$distant_array['lat_dist_minus'], $distant_array['lat_dist_plus']])
                                    ->WhereBetween('longitude', [$distant_array['lng_dist_minus'], $distant_array['lng_dist_plus']]);
                        })->orderby('created_at', 'DESC')->paginate(20);
            } elseif ($keyword == 'daily_deals') {
                if ($days == null) {
                    $days = date('D');
                }
                $regrex = '"' . $days . '"' . ':"[^"]*[[:<:]]null[[:>:]]';
                $events = Event::Where('status', 1)->whereRaw("daily_deal NOT REGEXP '" . $regrex . "'")->Where(function($query) use ($distant_array) {
                            $query->WhereBetween('latitude', [$distant_array['lat_dist_minus'], $distant_array['lat_dist_plus']])
                                    ->WhereBetween('longitude', [$distant_array['lng_dist_minus'], $distant_array['lng_dist_plus']]);
                        })->paginate(20);
            } else {

                $events = Event::Where('status', 1)->Where(function($query) use ($distant_array) {
                            $query->WhereBetween('latitude', [$distant_array['lat_dist_minus'], $distant_array['lat_dist_plus']])
                                    ->WhereBetween('longitude', [$distant_array['lng_dist_minus'], $distant_array['lng_dist_plus']]);
                        })->paginate(20);
            }
        }
        $view = View::make('events.search', compact('events'));
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return response()->json(['success' => true, 'html' => $sections['content']]);
        }
        return $view;
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
            $event_images = EventImage::Where('event_id', $id)->first();
            if ($event_images) {
                $eventimageArray = json_decode($event_images->event_images);
                foreach ($eventimageArray as $val) {
                    @unlink(base_path('public/event_images/') . $val);
                }
            }
            $events->delete();
            return response()->json(['success' => true, 'html' => $this->index($request), 'messages' => "Event deleted successfully !"]);
        }
        return 'true';
    }

    /**
     * functon to get sub category using ajax.
     *
     * @param  int  $id
     * @return Response
     */
    public function getSubCategory(Request $request) {
        $id = $request->get('id');
        if ($id) {
            return SubCategory::Where('category_id', $id)->pluck('name')->toArray();
        } else {
            return array();
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
        return Event::select('event_slug')->where('event_slug', 'like', $slug . '%')
                        ->get();
    }

    /**
     * funtion to get category by autosearch .
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryAutosearch(Request $request) {
        $categories = Category::Where('name', 'LIKE', '%' . $request->get('query') . '%')->Where('status', 1)->pluck('name')->toArray();
        $sub_categories = SubCategory::Where('name', 'LIKE', '%' . $request->get('query') . '%')->pluck('name')->toArray();
        $events = Event::Where('name', 'LIKE', '%' . $request->get('query') . '%')->Where('status', 1)->pluck('name')->toArray();


        return array_merge($categories, $events, $sub_categories);
    }

    /**
     * funtion to get address by autosearch .
     *
     * @return \Illuminate\Http\Response
     */
    public function addressAutosearch(Request $request) {
        $address = $request->get('query');
        return $events = Event::Where(function($query) use ($address) {
                    $query->Where('address', 'LIKE', '%' . $address . '%')
                            ->orWhere('city', 'LIKE', '%' . $address . '%')
                            ->orWhere('state', 'LIKE', '%' . $address . '%');
                })->pluck('formatted_address');
    }

}
