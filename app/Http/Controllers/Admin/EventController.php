<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Event;
use App\EventImage;
use App\Category;
use App\Country;
use Session;
use Redirect;
use Yajra\Datatables\Facades\Datatables;

class EventController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Business Events';
        if ($request->ajax()) {
            $events = Event::with(['getUserDetails', 'getReviews'])->get();
            foreach ($events as $key => $value) {
                $events[$key]['user_name'] = $value->getUserDetails->first_name . ' ' . $value->getUserDetails->last_name;
                if ($value->getReviews->count() > 0) {
                    $events[$key]['rate'] = number_format(($value->getReviews->sum('rate') / $value->getReviews->count()), 0);
                } else {
                    $events[$key]['rate'] = 0;
                }
                $events[$key]['comment'] = $value->getReviews->count();
                if ($value->status == 1) {
                    $events[$key]['status'] = '<div class="btn-group status-toggle" data-id="' . $value->id . '" data-url="' . route('business-status') . '"><button class="btn active btn-primary" data-value="1">Active</button><button class="btn btn-default" data-value="0">Deactivate</button></div>';
                } else {
                    $events[$key]['status'] = '<div class="btn-group status-toggle" data-id="' . $value->id . '" data-url="' . route('business-status') . '"><button class="btn btn-default" data-value="1">Active</button><button class="btn active btn-primary" data-value="0">Deactivate</button></div>';
                }
                $events[$key]['view_review'] = '<a href="' . route('reviews.index', array('event_id' => $value->id)) . '" data-toggle="tooltip" title="View Reviews" class="glyphicon glyphicon-eye-open"></a>';
                $events[$key]['view_photo'] = '<a href="' . route('business-images', $value->id) . '" data-toggle="tooltip" title="View Event Images" class="glyphicon glyphicon-eye-open"></a>';
                $events[$key]['action'] = '<a href="' . route('business.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="' . route('business.destroy', $value->id) . '" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a>';
            }
            return Datatables::of($events)->make(true);
        }
        return View::make('admin.events.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
//    public function create() {
//        
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
//    public function store(Request $request) {
//
//    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Events | update';
        $events = Event::where('id', $id)->first();
        $categories = Category::Where('status', 1)->get();
        $countries = Country::get();
        return View::make('admin.events.edit', compact('title', 'events', 'categories', 'countries'));
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
//            'date' => 'required',
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
                'status' => isset($data['status' . $key]) ? $data['status' . $key] : 1
            );
            $operation_hour[$key] = $hour_array;
        }

        $data['operation_hour'] = json_encode($operation_hour);
        unset($data['day']);
        unset($data['time_from']);
        unset($data['time_to']);
        unset($data['status']);



        $events = Event::Where(['id' => $id])->first();

        if ($events) {
            $events->fill($data)->save();
            return redirect()->route('business.index')
                            ->with('success-message', 'Event updated successfully!');
        }
        return redirect()->route('business.index')
                        ->with('error-message', 'Something went wrong .Please try again later!');
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
     * function to update review status
     *
     * @param  int  $id
     * @return Response
     */
    public function eventStatus(Request $request) {
        $id = $request->get('id');
        $status = $request->get('status');

        $events = Event::find($id);

        if (!$events) {
            return response()->json(array('error' => 'Something went wrong.Please try again later!'), 401);
        } else {
            $events->fill(array('status' => $status))->save();
            return response()->json(['success' => true, 'messages' => "Event updated successfully!"]);
        }
    }

    /**
     * fubnction to get all event images.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEventImages(Request $request, $event_id) {
        $title = 'Business Events';
        $default_limit = 20;
        $page = $request->get('page') != null ? $request->get('page') : 1;
        $show_limit = $request->get('show_limit') != null ? $request->get('show_limit') : $default_limit;
        if ($show_limit == 0) {
            $show_limit = $default_limit;
        }
        $take = $default_limit * $page;
        $skip = $take - $default_limit;
        $event_images = EventImage::Where('event_id', $event_id)->skip($skip)->take($take)->get();
        $total_count = EventImage::Where('event_id', $event_id)->count();
        if ($total_count < $default_limit) {
            $page = 0;
        } else {
            $page = $page % $total_count;
        }


        $view = View::make('admin.events.photo', compact('title', 'event_images', 'page', 'show_limit', 'default_limit', 'total_count'));
        if ($request->ajax()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteEventImage(Request $request, $id) {
        $regrex = '"([^"]*)' . $request->get('name') . '([^"]*)"';
        $event_images = EventImage::Where('event_id', $id)->whereRaw("event_images REGEXP '" . $regrex . "'")->first();
        if ($event_images) {
            $eventimageArray = json_decode($event_images->event_images);
            $key = array_search($request->get('id'), $eventimageArray);
            unset($eventimageArray[$key]);
            $eventimageArray = array_values($eventimageArray);
            $event_images->fill(array('event_images' => json_encode($eventimageArray)))->save();
            @unlink(base_path('public/event_images/') . $request->get('id'));
            return response()->json(['success' => true, 'html' => $this->show($request, $events->event_slug), 'messages' => "Event image deleted successfully!"]);
        } else {
            return response()->json(array('error' => 'Something went wrong .Please try again later!'), 401);
        }

        return 'true';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $events = Event::find($id);
        if (!$events) {
            Session::flash('error-message', 'Something went wrong .Please try again later!');
        } else {
            $event_images = EventImage::Where('event_id', $id)->first();
            if ($event_images) {
                $eventimageArray = json_decode($event_images->event_images);
                foreach ($eventimageArray as $val) {
                    @unlink(base_path('public/event_images/') . $val);
                }
            }
            $events->delete();
            Session::flash('success-message', 'Deleted successfully !');
        }
        return 'true';
    }

}
