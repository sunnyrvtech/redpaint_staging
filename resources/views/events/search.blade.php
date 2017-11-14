@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="row">
        <div class="col-sm-12">
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
                    <div class="col-xs-18 col-sm-6 col-md-4">
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
                                <span><i class="fa fa-map-marker"></i> {{ $value->formatted_address }}</span>
                                <span class="description-search">{{ $value->description }}</span>
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
