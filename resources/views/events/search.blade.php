@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="row text-center">
        <h3>Your First Review Awaits</h3>
        <div class="col-md-10">
            <p><b>Review your favorite businesses and share your experiences with our community. Need a little help getting started?</b></p>
            <form class="seacrg_city" action="{{ route('search') }}">
                <div class="col-md-5 col-sm-5 col-xs-12 custom_column">
                    <div class="input-group">
                        <div class="input-group-addon">Find</div>
                        <input type="text" class="form-control typeahead" autocomplete="off" data-url="{{ route('events-autosearch') }}" name="keyword" value="{{ Request::get('keyword') }}" placeholder="dinner, Max’s">
                    </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-12 custom_column">
                    <div class="input-group">
                        <div class="input-group-addon">Near</div>
                        <input type="text" class="form-control typeahead" autocomplete="off" data-url="{{ route('address-autosearch') }}" name="address" value="{{ Request::get('address') }}" placeholder="address, city, state or zip">
                    </div>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-12 custom_column">
                    <button type="submit" class="btn btn-primary search_city_btn"><i class="icofont icofont-search-alt-1"></i></button>
                </div>
            </form>
        </div>
        <div class="col-md-2">
            <p><b>Filter by day:-</b></p>
            <?php
            $days = array(
               'Mon' => 'Monday',
               'Tue' => 'Tuesday',
               'Wed' => 'Wednesday',
               'Thu' => 'Thursday',
               'Fri' => 'Friday',
               'Sat' => 'Saturday',
               'Sun' => 'Sunday');
            ?>
            <select name="day">
                <option value="">Choose...</option>
                @foreach($days as $key=>$val)
                <option @if(Request::get('day') == $key) selected @endif value="{{ $key }}">{{ $val }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="event-listing">
        <div class="col-sm-12" style="border-top: 1px solid #e6e6e6;">
            <div class="content-middle search-wrap">
                <?php $i=0; ?>
                @forelse($events as $key=>$value)
                <?php
                $event_images = isset($value->getOwnerEventImages->event_images) ? json_decode($value->getOwnerEventImages->event_images) : array('default.jpg');
                if (empty($event_images)) {
                    $event_images = array('default.jpg');
                }
                ?>
                @if($i%3 == 0)
                <div class="row">
                    @endif
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <a href="{{ route('events',$value->event_slug) }}"><img src="{{ URL::asset('/event_images').'/'.$event_images[0] }}" alt=""></a>
                            <div class="caption">
                                <span><a href="{{ route('events',$value->event_slug) }}">{{ $value->name }}</a></span>
                                <span><i class="fa fa-map-marker"></i> {{ ucfirst($value->address).','.ucfirst($value->city).','.ucfirst($value->state).' '.$value->zip }}</span>
                                <span class="description-search">{{ str_limit($value->description, $limit = 32, $end = '...') }}</span>
                                <?php
                                $daily_deal = json_decode($value->daily_deal);
                                if(Request::get('day') == null)
                                    $day_key = date("D");
                                else
                                    $day_key = Request::get('day');
                                ?>
                                @if(isset($daily_deal->$day_key) && $daily_deal->$day_key !='null')
                                <div class="day_deal">
                                    <p><i class="fa fa-clock-o" aria-hidden="true"></i>Deal of the day </p>
                                    <span>{{ $daily_deal->$day_key }}</span>
                                </div>
                                @endif
                                    <!--<p class="business-date-opened"><i class="fa fa-hourglass" aria-hidden="true"></i>Opened 3 weeks ago </p>-->

                            </div>
                        </div>
                    </div>
                    @if($i%2 == 0 && $i !=0)
                    <?php $i = 0; ?>
                </div>
                @else
                <?php $i++; ?>
                @endif
                @empty
                <div class="notice notice-warning">
                    <strong>Notice:-</strong> No event founds in your location!
                </div>
                @endforelse
                <div class="row">
                    @if(!empty($events))
                    <div class="pagination_main_wrapper text-center">{{ $events->appends($_GET)->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', 'select[name="day"]', function (e) {
           angular.element(this).scope().filterByDay($(this).val());
        });
    });
</script>
@endpush
