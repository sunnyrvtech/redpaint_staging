@extends('layouts.app')
@push('stylesheet')
<link href="{{ URL::asset('/slick/slick.css') }}" rel="stylesheet">
<link href="{{ URL::asset('/slick/slick-theme.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('/fancybox/jquery.fancybox-1.3.4.css') }}" media="screen" />
@endpush
@section('content')
<style>
    #map { height: 200px; }
</style>
<div class="profile-outer-main">
    <div class="container">
        <div class="row">
            <div class="ads-container">
                @foreach($ads as $val)
                <div class="item">
                    <img src ="{{ URL::asset('/ads_images').'/'.$val->banner }}">
                </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="review-main">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="sidebar-map-wrap">
                            <h2>{{ ucfirst($events->name) }}</h2>
                            <div class="biz-main-info">
                                <div class="rating-detail">
                                    <div class="biz-rating">
                                        <?php
                                         if($events->getReviews->count() >0){
                                             $average = number_format(($events->getReviews->sum('rate') / $events->getReviews->count()), 0);
                                         }else{
                                             $average = 0;
                                         }
                                        ?>
                                        <ul>
                                            <li class="@if($average >=1) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li class="@if($average >=2) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li class="@if($average >=3) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li class="@if($average >=4) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li class="@if($average >=5) {{ 'rating'.$average }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                        </ul>
                                    </div>

                                    <!--                                {{ $events->getReviews->sum('rate') }}-->
                                    <span class="review-count">{{ $events->getReviews->count() }} reviews </span>
                                </div>
                                <div class="rating-details">
                                    <!--<a href="#"><i class="fa fa-paragraph" aria-hidden="true"></i>Details</a>-->
                                </div>
                            </div>
                            <div class="price-category">
                                <p><span>{{ $events->description }}</span></p>
                                @if($events->getSubCategory)
                                <span class="bullet-after">
                                    <span class="price-range">$$</span>
                                </span>
                                <span class="category-str-list">
                                    <!--<span>{{ str_replace('.00', '',number_format($events->price_to,2)).'-'.str_replace('.00', '',number_format($events->price_from,2)) }}</span>-->
                                    <a href="{{ route('subcategory.search',$events->getSubCategory->id) }}">{{ $events->getSubCategory->name }}</a>
                                </span>
                                @endif
                            </div>
                            <?php  
                                $daily_deal = json_decode($events->daily_deal); 
                                $day_key = date("D");
                            ?>
                            @if(isset($daily_deal->$day_key) && $daily_deal->$day_key !='null')
                            <div class="day_deal">
                                <p><i class="fa fa-clock-o" aria-hidden="true"></i> Deal of the day </p>
                                <span>{{ $daily_deal->$day_key }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="biz-page-actions">
                                <a @if(!Auth::check()) href="{{ route('login') }}" @endif class="review-btn">
                                    <i class="fa fa-star" aria-hidden="true"></i> Write a Review     
                                </a>
                                <span class="allbtn-group">
                                    <a href="{{ route('photo.show',$events->event_slug) }}" class="add-photo-button">
                                        <i class="fa fa-camera" aria-hidden="true"></i>Add Photo     
                                    </a>
<!--                                    <a href="#" class="share-icon">
                                        <i class="fa fa-share-square-o" aria-hidden="true"></i>Share     
                                    </a>-->
                                </span>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mapbox-container">
                                <div class="mapbox-map" id="map">


                                    <!--                                    <a href="#">
                                                                            <img src="http://192.168.1.72/redpaint_staging/public/images/staticmap.png">
                                                                        </a>-->
                                </div>
                                <div class="mapbox-text">
                                    <ul>
                                        <li>
                                            <!--<a href="#" class="link-more"><span>Edit</span></a>-->
                                            <div class="map-box-address">
                                                <strong class="street-address"><address>{{ ucfirst($events->address) }}<br>{{ ucfirst($events->address).','.ucfirst($events->state).' '.$events->zip }}</address> </strong>
                                                <!--<span class="cross-streets">b/t Fell St &amp; Hayes St </span>-->
                                                <!--<span class="neighborhood-str-list"> NoPa</span>-->
                                            </div>
                                        </li>
                                        <li class="direction">
                                            <div class="map-box-address">
                                                <a href="{{ route('maps',$events->id) }}" id="various3">Get Direction</a>
                                            </div>
                                        </li>
<!--                                                                            <li class="ph-call">
                                                                                <div class="map-box-address">
                                                                                    <div class="phone-call"> (415) 926-8065 </div>
                                                                                </div>
                                                                            </li>
                                                                            <li class="message-map">
                                                                                <div class="map-box-address">
                                                                                    <a href="#">Message</a>
                                                                                </div>
                                                                            </li>
                                                                            <li class="mob-call">
                                                                                <div class="map-box-address">
                                                                                    <a href="#"> Send to your Phone</a>
                                                                                </div>
                                                                            </li>-->
                                    </ul>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="biz-page-header-right">
                            
                            <!--//                            print_r($events->getEventImages->take(3)->toArray());-->

                            <?php
                            $event_images_array = array();
                            foreach ($events->getEventImages->take(3) as $value) {
                                $event_images_array = array_merge($event_images_array, json_decode($value->event_images));
                            }
                            ?>
                            <div class="lightbox-media-parent @if($event_images_array) slickSlider @endif">
                                 <?php $i = 1; ?>
                                @forelse($event_images_array as $key=>$val)
                                
                                @if($i % 4 == 0)
                                <?php $i=1; ?>
                                @endif
                                <div class="item">
                                    <div class="js-photo photo{{$i}}">
                                        <div class="showcase-photos">
                                            <div class="photo">
                                                <div class="showcase-photo-box">
                                                    <a href="#">
                                                        <img src="{{ URL::asset('/event_images').'/'.$val }}">
                                                    </a>
                                                    @if ($val == end($event_images_array))
                                                    <a class="view-more" href="{{ route('photo.view', $events->event_slug) }}">
                                                        <span><i class="fa fa-th-large" aria-hidden="true"></i></span>
                                                        <p> See all {{ count($event_images_array) }} photos </p>
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; ?>
                                @empty
                                <div class="js-photo">
                                    <div class="showcase-photos">
                                        <div class="photo">
                                            <div class="showcase-photo-box">
                                                <a href="#">
                                                    <img src="{{ URL::asset('/event_images/default.jpg') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforelse
                             </div>
                            </div>	
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-sm-7 col-xs-12">
                <div>
                    <div class="people-review">
                        @forelse($events->getReviews()->paginate(15) as $value)
                        <div>
                            <div class="review-inner">
                                <div class="person-detail">
                                    <div class="img-side">
                                        <?php
                                        if ($value->getUserDetails->user_image) {
                                            $user_image = $value->getUserDetails->user_image;
                                        } else {
                                            $user_image = 'default.png';
                                        }
                                        ?>
                                        
                                        <img width="60" height="60" src="{{ URL::asset('/user_images').'/'.$user_image }}">
                                    </div>	
                                    <div class="user-name">
                                        <h5>{{ ucfirst($value->getUserDetails->first_name).' '.str_limit(ucfirst($value->getUserDetails->last_name), $limit = 1, $end = '.') }}</h5>
                                        <p>{{ !empty($value->getUserDetails->city)?$value->getUserDetails->city.',':'' }}{{ $value->getUserDetails->state }}</p>
                                    </div>
                                </div>
                                <div class="review-by-people">
                                    <!--{{ $value->rate }}-->
                                    <div class="biz-rating">
                                        <ul>
                                            <li class="rating{{ $value->rate }}"><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li class="@if($value->rate >=2) {{ 'rating'.$value->rate }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li class="@if($value->rate >=3) {{ 'rating'.$value->rate }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li class="@if($value->rate >=4) {{ 'rating'.$value->rate }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li class="@if($value->rate >=5) {{ 'rating'.$value->rate }} @else rating @endif"><i class="fa fa-star" aria-hidden="true"></i></li>
                                        </ul>
                                    </div>
                                    <span class="rating-qualifier"> {{ date('m/d/Y',strtotime($value->created_at)) }} </span>
                                    <p>{{ $value->comment }}</p>
                                    <!--                            <div class="review-footer">
                                                                    <p class="voting-intro"> Was this review …?</p>
                                                                    <ul class="voting-buttons">
                                                                        <li><a href="#"><i class="fa fa-lightbulb-o" aria-hidden="true"></i>Useful</a></li>
                                                                        <li><a href="#"><i class="fa fa-smile-o" aria-hidden="true"></i>Funny</a></li>
                                                                        <li><a href="#"><i class="fa fa-smile-o" aria-hidden="true"></i>Cool</a></li>
                                                                    </ul>
                                                                </div>-->
                                </div>
                            </div>
                        </div>
                        @empty
                        <div>
                            <div class="notice notice-danger">
                                No Review Found !
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <div class="pagination_main_wrapper text-center">{{ $events->getReviews()->paginate(15)->links() }}</div>
                </div>    
                <div>
                    <div class="write-review">
                        @if(Auth::check() && !$checkUserReviewStatus)
                        <form action="{{ route('events-review',$events->id) }}" method="post">
                            {{ csrf_field()}}
                            <div>
                                <label>Your review</label>
                                <small class="pull-right"> <a class="guidelines" href="#">Read our review guidelines</a></small>
                            </div>
                            <div class="review-written">
                                <div class="rating-and-comment">
                                    <div class="biz-rating">
                                        <ul>
                                            <li class="rating"><label><input type="radio" data-msg="Eek! Methinks not." class="input_radio" required="" name="rate" value="1">
                                                    <i class="fa fa-star" aria-hidden="true"></i></label></li>
                                            <li class="rating"><label><input type="radio" data-msg="Meh. I've experienced better." class="input_radio" required="" name="rate" value="2">
                                                    <i class="fa fa-star" aria-hidden="true"></i></label></li>
                                            <li class="rating"><label><input type="radio" data-msg="A-OK." class="input_radio" required="" name="rate" value="3">
                                                    <i class="fa fa-star" aria-hidden="true"></i></label></li>
                                            <li class="rating"><label><input type="radio" data-msg="Yay! I'm a fan." class="input_radio" required="" name="rate" value="4">
                                                    <i class="fa fa-star" aria-hidden="true"></i></label></li>
                                            <li class="rating"><label><input type="radio" data-msg="Woohoo! As good as it gets." class="input_radio" required="" name="rate" value="5">
                                                    <i class="fa fa-star" aria-hidden="true"></i></label></li>
                                        </ul>
                                    </div>
                                    <p class="star-selector">Select your rating.</p>
                                    <div class="form-group {{ $errors->has('rate') ? ' has-error' : '' }}">
                                        @if ($errors->has('rate'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rate') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="review-widget">
                                    <div class="form-group {{ $errors->has('comment') ? ' has-error' : '' }}">
                                        <textarea class="review-textarea form-control" required="" maxlength="1000" id="review-text" name="comment"  placeholder="Your review helps others learn about great local businesses. Please don't review this business if you received a freebie for writing this review, or if you're connected in any way to the owner or employees.">{{ old('comment') }}</textarea> 
                                        @if ($errors->has('comment'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        @else
                        @if(!empty($checkUserReviewStatus))
                        <div class="notice notice-danger">
                            <strong>Notice:-</strong> You have already submit your review for <strong>{{ ucfirst($events->name) }}</strong>@if(!$checkUserReviewStatus->status) and deactivate by administrator.@else.@endif
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-5 col-xs-12">
                    <?php
                    $time_array = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
                    $operation_hour = json_decode($events->operation_hour);
                    ?>
                    <div>
                        <h4><b>Opening Hours</b></h4>
                        <table class="table table-simple hours-table">
                            <tbody>
                                @foreach($time_array as $key=>$val)
                                <tr>
                                    <th scope="row">{{ $val }}</th>
                                    <td>
                                        @if(isset($operation_hour[$key]->status) && $operation_hour[$key]->status == 1)
                                        <span class="nowrap">{{ $operation_hour[$key]->time_from }}</span> - <span class="nowrap">{{ $operation_hour[$key]->time_to }}</span>
                                        @endif
                                    </td>
                                    <td class="extra">
                                        <?php 
                                        $current_time = strtotime(date('h:i A'));
                                        $time_from = strtotime($operation_hour[$key]->time_from); 
                                        $time_to = strtotime($operation_hour[$key]->time_to); 
                                        ?>
                                        @if(isset($operation_hour[$key]->status) && $operation_hour[$key]->status == 0)
                                        <span class="nowrap clse">Closed</span>
                                        @elseif($current_time>=$time_from && $current_time<=$time_to &&  date("D") == $val)
                                        <span class="nowrap">Open now</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <?php
                        $happy_hour = json_decode($events->happy_hour);
                        $brunch_hour = json_decode($events->brunch_hour);
                       // $day_key = array_search(date("D"), $time_array); //   get the array key based on current day
                    ?>
                    <div>
                          <h4><b>Main Amenities </b></h4>
                          <ul class="amenities-list">
                              <?php $time_flag = true; ?>
                              @foreach($time_array as $val)
                              @if(isset($daily_deal->$val) && $daily_deal->$val != 'null')
                              @if($time_flag)          
                              <li><strong>Daily Deals</strong><span class="fa fa-plus-square hour_collapse"></span>
                                  <div class="hours_details">
                                      <?php $time_flag = false; ?>
                                      @endif
                                      <ul>
                                          <li><strong>{{ $val }}</strong><span style="float:right">{{ $daily_deal->$val }}</span></li>
                                      </ul>
                                      @if($val === end($time_array))
                                  </div>
                              </li>
                              @endif
                              @endif
                              @endforeach
                              <?php $time_flag = true; ?>
                              @foreach($happy_hour as $val)
                              @if($val->time_from && $val->time_to)
                              @if($time_flag)
                              <li><strong>Happy hours</strong><span class="fa fa-plus-square hour_collapse"></span>
                                  <div class="hours_details">
                                      <?php $time_flag = false; ?>
                                      @endif
                                      <ul>
                                          <li><strong>{{ $val->day }}</strong><span style="float:right">{{ $val->time_from.' - '.$val->time_to }}</span></li>
                                      </ul>
                                      <p>{{ $events->happy_hour_note }}</p>
                                      @if($val === end($happy_hour))      
                                  </div>
                              </li>
                              @endif
                              @endif
                              @endforeach
                              <?php $time_flag = true; ?>
                              @foreach($brunch_hour as $val)
                              @if($val->time_from && $val->time_to) 
                              @if($time_flag)
                              <li><strong>Brunch hours</strong><span class="fa fa-plus-square hour_collapse"></span>
                                  <div class="hours_details">
                                      <?php $time_flag = false; ?>
                                      @endif
                                      <ul>
                                          <li><strong>{{ $val->day }}</strong><span style="float:right">{{ $val->time_from.' - '.$val->time_to }}</span></li>
                                      </ul>
                                      <p>{{ $events->brunch_hour_note }}</p>
                                      @if($val === end($brunch_hour))       
                                  </div>
                              </li>
                              @endif
                              @endif
                              @endforeach
                              @if($events->vegan)
                              <li><strong>Vegan options</strong></li>
                              @endif
                              @if($events->vegetarian)
                              <li><strong>Vegetarian options</strong></li>
                              @endif
                              @if($events->gluten)
                              <li><strong>Gluten free options</strong></li>
                              @endif
                              @if($events->parking)
                              <?php $parking = json_decode($events->parking); ?>
                              <li><strong>Parking-</strong>
                                  @foreach($parking as $val)
                                  <span>
                                      {{ ucfirst($val) }}@if($val != end($parking)),@endif
                                  </span>
                                  @endforeach
                              </li>
                              @endif
                          </ul>
                      </div>
                <div>
                    <div class="heading"><h4><b>You may also consider</b></h4></div>
                    <div class="RecentLists">
                        <ul>
                            @forelse($event_by_cat as $key=>$value)
                            <?php
                            $event_images = isset($value->getOwnerEventImages->event_images) ? json_decode($value->getOwnerEventImages->event_images) : array('default.jpg');
                            ?>
                            <li><a href="{{ route('events',$value->event_slug) }}">
                                    <div class="image_r"><img src="{{ URL::asset('/event_images').'/'.$event_images[0] }}"></div>
                                    <div class="RecentL_contant">
                                        <h5>{{ $value->name }}</h5>
                                        <p>{{ str_limit($value->description, $limit = 15, $end = '...') }}</p>
                                    </div>
                                </a></li>
                            @empty
                            <li><span>No related events found !</span></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ URL::asset('/slick/slick.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZGTC412EEKYBmKXxH9VFnE97fKNsu0zQ&callback=initMap"
async defer></script>
<script type="text/javascript" src="{{ URL::asset('/fancybox/jquery.fancybox-1.3.4.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    if($("ul.amenities-list").has("li").length == 0){
        $("ul.amenities-list").parent().remove();
    }
    
    if($(window).width() <  900){
        $('.js-photo ').removeClass('photo2');
    }
    
    $(".review-btn").click(function () {
        $('#review-text').focus();
        $('html, body').animate({
            scrollTop: $(".write-review").offset().top
        }, 1000);
    });
    var default_rating;
    var default_rating_msg = 'Select your rating.';
    $(".rating-and-comment li i").hover(function () {
        var rating = $(this).parent().find('.input_radio').val();
        var rating_msg = $(this).parent().find('.input_radio').attr('data-msg');
        $('.star-selector').text(rating_msg);
        $(".rating-and-comment ul > li:lt(" + rating + ")").addClass('rating' + rating);
    }, function () {
        $(".rating-and-comment ul > li:lt(5)").removeClass().addClass('rating');
        $(".rating-and-comment ul > li:lt(" + default_rating + ")").addClass('rating' + default_rating);
        $('.star-selector').text(default_rating_msg);
    });
    $(".input_radio").click(function () {
        var rate = $(this).val();
        default_rating = rate;
        default_rating_msg = $(this).attr('data-msg');
        $('.star-selector').text(default_rating_msg);
        $(".rating-and-comment ul > li:lt(5)").removeClass().addClass('rating');
        $(".rating-and-comment ul > li:lt(" + rate + ")").addClass('rating' + default_rating);
    });
    $(document).on("click",".hour_collapse.fa-plus-square",function () {
        $('.hours_details').hide();
        $('.hour_collapse').removeClass('fa-minus-square').addClass('fa-plus-square');
        $(this).parent().find('.hours_details').show();
        $(this).removeClass('fa-plus-square').addClass('fa-minus-square');
    });
    $(document).on("click",".hour_collapse.fa-minus-square",function () {
        $(this).parent().find('.hours_details').hide();
        $(this).removeClass('fa-minus-square').addClass('fa-plus-square');
    });
    $(".slickSlider").slick({
        autoplay: true,
        slidesToShow: 3,
        infinite: false,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 450,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });
    $(".ads-container").slick({
        autoplay: true,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1
    });
    
    $("#various3").fancybox({
	'width'		: '100%',
	'height'	: '100%',
	'autoScale'	: false,
	'transitionIn'	: 'none',
	'transitionOut'	: 'none',
	'type'		: 'iframe',
        'onStart': function(){
            $("body").css({'overflow-y':'hidden'});
            $(window).scrollTop(0);
        },
        'onClosed': function(){
            $("body").css({'overflow-y':'visible'});
        }
    });
});
</script>
<script type="text/javascript">
var lat = {{ $events->latitude }};
var long = {{ $events->longitude }};
function initMap() {
    var myLatLng = {lat: lat, lng: long};
    var map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            zoom: 10,
            mapTypeControl: false
    });
    var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
    });
}
</script>
@endpush




