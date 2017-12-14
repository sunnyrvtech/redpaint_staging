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
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
                7 => 'Sunday');
            ?>
            <select ng-model="day" ng-change="filterByDay()">
                <option value="">Choose...</option>
                @foreach($days as $key=>$val)
                <option @if(Request::get('day') == $val) selected @endif value="{{ $val }}">{{ $val }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="event-listing">
        <div class="col-sm-12" style="border-top: 1px solid #e6e6e6;">
            <div class="content-middle search-wrap">
                @forelse($events as $key=>$value)
                <?php
                $event_images = isset($value->getOwnerEventImages->event_images) ? json_decode($value->getOwnerEventImages->event_images) : array('default.jpg');
                if (empty($event_images)) {
                    $event_images = array('default.jpg');
                }
                if ($value->getReviews->count() > 0) {
                    $average = number_format(($value->getReviews->sum('rate') / $value->getReviews->count()), 0);
                } else {
                    $average = 0;
                }
                ?>
                @if($key%3 == 0)
                <div class="row">
                    @endif
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <a href="{{ route('events',$value->event_slug) }}"><img src="{{ URL::asset('/event_images').'/'.$event_images[0] }}" alt=""></a>
                            <div class="caption">
                                <span><a href="{{ route('events',$value->event_slug) }}">{{ $value->name }}</a></span>
                                <div class="biz-rating">
                                    <ul>
                                        <li class="@if($average >=1) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li class="@if($average >=2) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li class="@if($average >=3) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li class="@if($average >=4) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li class="@if($average >=5) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li class="cou-rate"><span>{{ $value->getReviews->count() }} reviews</span></li>
                                    </ul>
                                </div>
                                <span><i class="fa fa-map-marker"></i> {{ str_limit($value->formatted_address, $limit = 32, $end = '...') }}</span>
                                <span class="description-search">{{ str_limit($value->description, $limit = 32, $end = '...') }}</span>
                                <!--<p class="business-date-opened"><i class="fa fa-hourglass" aria-hidden="true"></i>Opened 3 weeks ago </p>-->
                            </div>
                        </div>
                    </div>
                    @if($key%2 == 0 && $key !=0)
                </div>
                @endif
                @empty
                <div class="notice notice-warning">
                    <strong>Notice:-</strong> No event founds in your location!
                </div>
                @endforelse
                <div class="row">
                    @if(!empty($events))
                    <div class="pagination_main_wrapper text-center">{{ $events->links() }}</div>
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
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var qs = getQueryStrings();
            var URL = $(this).attr('href');
            if (qs['keyword'] != undefined) {
                URL = URL + '&keyword=' + qs['keyword'];
            }
            if (qs['address'] != undefined) {
                URL = URL + '&address=' + qs['address'];
            }
            if (qs['day'] != undefined) {
                URL = URL + '&day=' + qs['day'];
            }
            window.location.href = URL;
        });

        function getQueryStrings() {
            var assoc = {};
            var decode = function (s) {
                return decodeURIComponent(s.replace(/\+/g, " "));
            };
            var queryString = location.search.substring(1);
            var keyValues = queryString.split('&');

            for (var i in keyValues) {
                var key = keyValues[i].split('=');
                if (key.length > 1) {
                    assoc[decode(key[0])] = decode(key[1]);
                }
            }
            return assoc;
        }
    });
</script>
@endpush
