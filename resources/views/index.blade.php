@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
<div class="Browse-Category">
    <div class="container">
        <div class="heading"><h2>Browse Businesses by Category</h2></div>
        <p>A new better way to search for local food.</p>

        <ul class="Category_listing">
            @foreach($categories->take(4) as $key=>$val)
            <!--            @if($key < 7)-->
            <li><a href="{{ route('search') }}?keyword={{ urlencode($val->name) }}"><i class="{{ $val->class_name }}"></i> <span>{{ $val->name }}</span></a></li>
            <!--@endif-->
            @endforeach
            <!--<li class="show_more_cat"><a href="javascript:void(0);"><div class="three_dots"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i></div> <span>More Categories</span></a></li>-->
        </ul>
        <!--        <div class="more_category">
                    <div class="col-md-3 cat_child">
                        <a href=""><i class=""></i> <span></span></a>
                    </div>
                </div>-->

    </div>
</div><!-- end Browse-Category -->

<div class="New_arrival">
    <div class="container">
        <div class="heading_m">
            <h2>new Arrivals</h2>
            <!--            <div class="find_cities">
                            <div class="dots"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i> </div>
                            <span>Cities</span>
            
                            <div class="city_list">
                                sdkfhsdkfh
                            </div>
                        </div>-->
        </div>
    </div>
    <div class="container">
        <div id="ca-container" class="ca-container">
            <div class="ca-wrapper">
                @forelse($events as $key=>$value)
                <?php
                if ($value->getReviews->count() > 0) {
                    $average = number_format(($value->getReviews->sum('rate') / $value->getReviews->count()), 0);
                } else {
                    $average = 0;
                }
                $event_images = isset($value->getOwnerEventImages->event_images) ? json_decode($value->getOwnerEventImages->event_images) : array();
                if (empty($event_images))
                    $event_images[0] = 'default.jpg';
                ?>
                <div class="ca-item ca-item-{{ $key }}">
                    <div class="item_l">
                        <div class="image"><a href="{{ route('events',$value->event_slug) }}"><img src="{{ URL::asset('/event_images').'/'.$event_images[0] }}"></a></div>
                        <div class="item_content">
                            <h3><a href="{{ route('events',$value->event_slug) }}">{{ $value->name }}</a></h3>
                            <h4><i class="fa fa-map-marker"></i> {{ str_limit($value->formatted_address, $limit = 37, $end = '...') }}</h4>
                            <p>{{ str_limit($value->description, $limit = 37, $end = '...') }}</p>
                            <?php $current_date = date('Y-m-d H:i:s'); ?>
                            @if(($current_date >= $value->start_date && $current_date <= $value->end_date) || empty($value->end_date))
                            <!--<span>Opened Today</span>-->
                            @elseif($current_date < $value->end_date)
                            <span>Opened <?php //$value->start_date ?></span>
                            @else
                            <?php
                            $dDiff = Carbon\Carbon::parse($value->end_date);
                            ?>
                            <!--<span>Opened <?php //$dDiff->diffForHumans() ?></span>-->
                            @endif
                            <div class="ratting_star">
                                <span>
                                    <i class="icofont icofont-star @if($average >= 1) yallow @endif"></i>
                                    <i class="icofont icofont-star @if($average >= 2) yallow @endif"></i>
                                    <i class="icofont icofont-star @if($average >= 3) yallow @endif"></i>
                                    <i class="icofont icofont-star @if($average >= 4) yallow @endif"></i>
                                    <i class="icofont icofont-star @if($average >= 5) yallow @endif"></i>
                                </span>
                                {{ $value->getReviews->count() }} reviews
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p>No event found !</p>
                @endforelse

            </div>
        </div>
    </div>
</div><!-- end New arrival -->

<div class="Review_of_the_Day_main">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-7 col-xs-12">
                <div class="heading"><h2>Review of the Day</h2></div>
                <div class="ROTD">
                    @if($review_of_day)
                    <?php
                    $user_image = isset($review_of_day->getUserDetails->user_image) ? $review_of_day->getUserDetails->user_image : 'default.png';
                    ?>
                    <div class="Rimg"><img src="{{ URL::asset('/user_images').'/'.$user_image }}"></div>
                    <div class="Review_name">
                        <h4>{{ $review_of_day->getUserDetails->first_name.' '.$review_of_day->getUserDetails->last_name }}.</h4>
                        <h5>Write a review for <span><a href="{{ route('events',$review_of_day->getEventDetails->event_slug) }}">{{ $review_of_day->getEventDetails->name }}</a></span></h5>
                    </div>
                    <div class="content">
                        <p>{{ str_limit($review_of_day->comment, $limit = 150, $end = '...') }}</p>
                    </div>
                    <div class="review_footer">
                        <div class="ratting_star">
                            <span>
                                <i class="icofont icofont-star @if($review_of_day->rate >=1) yallow @endif"></i>
                                <i class="icofont icofont-star @if($review_of_day->rate >=2) yallow @endif"></i>
                                <i class="icofont icofont-star @if($review_of_day->rate >=3) yallow @endif"></i>
                                <i class="icofont icofont-star @if($review_of_day->rate >=4) yallow @endif"></i>
                                <i class="icofont icofont-star @if($review_of_day->rate >=5) yallow @endif"></i>
                            </span>
                            {{ date('m/d/Y',strtotime($review_of_day->getEventDetails->created_at)) }}
                        </div>
                        <div class="Continue-reading"><a href="{{ route('events',$review_of_day->getEventDetails->event_slug) }}">Continue reading</a></div>
                    </div>
                    @else
                    <div class="notice notice-success">
                        <strong>Notice:-</strong> No review found !
                    </div>
                    @endif    
                </div>
            </div>
            <div class="col-md-4 col-sm-5 col-xs-12">
                <div class="heading"><h2>Recent Lists</h2></div>
                <div class="RecentLists">
                    <ul>
                        @forelse($events->take(3) as $key=>$value)
                        <?php
                        $event_images = isset($value->getOwnerEventImages->event_images) ? json_decode($value->getOwnerEventImages->event_images) : array();
                        if (empty($event_images))
                            $event_images[0] = 'default.jpg';
                        ?>
                        <li><a href="{{ route('events',$value->event_slug) }}">
                                <div class="image_r"><img src="{{ URL::asset('/event_images').'/'.$event_images[0] }}"></div>
                                <div class="RecentL_contant">
                                    <h5>{{ $value->name }}</h5>
                                    <p>{{ str_limit($value->description, $limit = 15, $end = '...') }}</p>
                                </div>
                            </a></li>
                        @empty
                        <li><span>No event found !</span></li>
                        @endforelse
                        @if($events->take(4)->count() > 3)
                        <li><p class="text-center"><a href="{{ route('search') }}?keyword=recent_events">Browse more lists</a></p></li>
                        @endif  
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div><!-- end Review_of_the_Day_main -->

<div class="news_letter">
    <div class="container">
        <h2>SIGN UP FOR NEWSLETTER</h2>
        <p>Stay up to date for everything Red Paint related, from new participating restaurants to new features and website updates. Get it here first!</p>
        <form>
            <div class="news_letter_input" ng-bind-html="news_msg">
            </div>
            <div class="news_letter_input">
                <input type="text" name="email" ng-model="news" placeholder="Put your email address here">
                <button class="Subscribe_btn" ng-disabled="isDisabled" ng-click="submitNewsletter()">Subscribe</button>
            </div>
        </form>
    </div>
</div><!-- end news_letter -->
@endsection
@push('scripts')
<script src="{{ URL::asset('js/jquery.cycle.all.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ URL::asset('js/jquery.maximage.js') }}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.easing.1.3.js') }}"></script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="{{ URL::asset('js/jquery.contentcarousel.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    // hide #back-top first
    $("#back-top").hide();
    $('#ca-container').contentcarousel();
    // fade in #back-top
    $(function () {
        // Trigger maximage
        jQuery('#maximage').maximage();

        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-top').fadeIn();
            } else {
                $('#back-top').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('#back-top a').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

    $(".find_cities span").click(function () {
        $('.find_cities').toggleClass("open");
    });

    $(".menu_mobile").click(function () {
        $('.header_menu').toggleClass("open");
    });
    $(".show_more_cat").click(function () {
        var me = $(this);
        $(".more_category").toggle('fast', function () {
            if ($(this).is(':visible')) {
                me.find("span").text('Fewer Categories');
            } else {
                me.find("span").text('More Categories');
            }
        });
    });
});
</script>
@endpush
