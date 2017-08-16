@extends('layouts.app')
@push('stylesheet')
@endpush
@section('content')
 <div class="Browse-Category">
        <div class="container">
            <div class="heading"><h2>Browse Businesses by Category</h2></div>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. <br/>Lorem Ipsum has been the industry</p>

            <ul class="Category_listing">
                <li><a href="#"><i class="icofont icofont-restaurant"></i> <span>Restaurants</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <span>Shopping</span></a></li>
                <li><a href="#"><i class="fa fa-glass" aria-hidden="true"></i> <span>Nightlife</span></a></li>
                <li><a href="#"><i class="icofont icofont-football"></i> <span>Active Life</span></a></li>
                <li><a href="#"><i class="fa fa-scissors" aria-hidden="true"></i> <span>Beauty & Spas</span></a></li>
                <li><a href="#"><i class="icofont icofont-car-alt-4"></i> <span>Automotive</span></a></li>
                <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i> <span>Home Services</span></a></li>
                <li class="More_Categories"><a href="#"><div class="three_dots"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i></div> <span>More Categories</span></a></li>
            </ul>
        </div>
    </div><!-- end Browse-Category -->

    <div class="New_arrival">
        <div class="container">
            <div class="heading_m">
                <h2>new Arrivals</h2>
                <div class="find_cities">
                    <div class="dots"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i> </div>
                    <span>Cities</span>

                    <div class="city_list">
                        sdkfhsdkfh
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div id="ca-container" class="ca-container">
                <div class="ca-wrapper">
                    <div class="ca-item ca-item-1">
                        <div class="item_l">
                            <div class="image"><img src="{{ URL::asset('images/image-1.png') }}"></div>
                            <div class="item_content">
                                <h3><a href="#">Khamsa</a></h3>
                                <h4>$$  Chinese, Bubble Tea<br/> Inner Richmond</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <span>Opened 2 weeks ago</span>
                                <div class="ratting_star">
                                    <span>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                    </span>
                                    11 reviews
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ca-item ca-item-2">
                        <div class="item_l">
                            <div class="image"><img src="{{ URL::asset('images/image-2.png') }}"></div>
                            <div class="item_content">
                                <h3><a href="#">Khamsa</a></h3>
                                <h4>$$  Chinese, Bubble Tea<br/> Inner Richmond</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <span>Opened 2 weeks ago</span>
                                <div class="ratting_star">
                                    <span>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                    </span>
                                    11 reviews
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ca-item ca-item-3">
                        <div class="item_l">
                            <div class="image"><img src="{{ URL::asset('images/image-3.png') }}"></div>
                            <div class="item_content">
                                <h3><a href="#">Khamsa</a></h3>
                                <h4>$$  Chinese, Bubble Tea<br/> Inner Richmond</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <span>Opened 2 weeks ago</span>
                                <div class="ratting_star">
                                    <span>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                    </span>
                                    11 reviews
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ca-item ca-item-4">
                        <div class="item_l">
                            <div class="image"><img src="{{ URL::asset('images/image-1.png') }}"></div>
                            <div class="item_content">
                                <h3><a href="#">Khamsa</a></h3>
                                <h4>$$  Chinese, Bubble Tea<br/> Inner Richmond</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <span>Opened 2 weeks ago</span>
                                <div class="ratting_star">
                                    <span>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                    </span>
                                    11 reviews
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ca-item ca-item-5">
                        <div class="item_l">
                            <div class="image"><img src="{{ URL::asset('images/image-1.png') }}"></div>
                            <div class="item_content">
                                <h3><a href="#">Khamsa</a></h3>
                                <h4>$$  Chinese, Bubble Tea<br/> Inner Richmond</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <span>Opened 2 weeks ago</span>
                                <div class="ratting_star">
                                    <span>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star yallow"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                    </span>
                                    11 reviews
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <div class="Rimg"><img src="{{ URL::asset('images/image-1.png') }}"></div>
                        <div class="Review_name">
                            <h4>Vira P.</h4>
                            <h5>Write a review for <span>Good luck</span></h5>
                        </div>
                        <div class="content">
                            <p>The best place to get a lot of food on a tight budget. The first time I came here, I only had $8 in my wallet, and was able to get 3 shrimp dumplings, a steamed bbq pork bun, and a sesame ball. The second time around, I had $20, and I went to town! I got all the things I wanted for myself, my vegetarian sister, and my parents, and it only came up to $12. As far as take-out dim sum, this place is good and has a decent...</p>
                        </div>
                        <div class="review_footer">
                            <div class="ratting_star">
                                <span>
                                    <i class="icofont icofont-star yallow"></i>
                                    <i class="icofont icofont-star yallow"></i>
                                    <i class="icofont icofont-star yallow"></i>
                                    <i class="icofont icofont-star"></i>
                                    <i class="icofont icofont-star"></i>
                                </span>
                                3/8/2017
                            </div>
                            <div class="Continue-reading"><a href="#">Continue reading</a></div>
                        </div>
                    </div>


                </div>
                <div class="col-md-4 col-sm-5 col-xs-12">
                    <div class="heading"><h2>Recent Lists</h2></div>
                    <div class="RecentLists">
                        <ul>
                            <li><a href="#">
                                <div class="image_r"><img src="{{ URL::asset('images/image-1.png') }}"></div>
                                <div class="RecentL_contant">
                                    <h5>2017 100+ Yelp Challenge</h5>
                                    <p>The best place to get a lot of food on a tight budget. The first time I came here...</p>
                                </div>
                            </a></li>
                            <li><a href="#">
                                <div class="image_r"><img src="{{ URL::asset('images/image-1.png') }}"></div>
                                <div class="RecentL_contant">
                                    <h5>2017 100+ Yelp Challenge</h5>
                                    <p>The best place to get a lot of food on a tight budget. The first time I came here...</p>
                                </div>
                            </a></li>
                            <li><a href="#">
                                <div class="image_r"><img src="{{ URL::asset('images/image-1.png') }}"></div>
                                <div class="RecentL_contant">
                                    <h5>2017 100+ Yelp Challenge</h5>
                                    <p>The best place to get a lot of food on a tight budget. The first time I came here...</p>
                                </div>
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end Review_of_the_Day_main -->

    <div class="news_letter">
        <div class="container">
            <h2>SIGN UP FOR NEWSLETTER</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry</p>
            <form>
                <div class="news_letter_input">
                    <input type="text" name="" placeholder="Put your email address here">
                    <button class="Subscribe_btn">Subscribe</button>
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

        $(".find_cities span").click(function(){
            $('.find_cities').toggleClass("open");
        });

        $(".menu_mobile").click(function(){
            $('.header_menu').toggleClass("open");
        });
});
</script>
@endpush
