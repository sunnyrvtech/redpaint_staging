<header class="header">
<div class="top_header">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-8">
                <div class="logo"><a href="#"><img src="{{ URL::asset('images/logo.png') }}"></a></div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <button class="menu_mobile"><i class="fa fa-bars" aria-hidden="true"></i></button>
                <div class="header_menu">
                    <ul>
                        <li><a href="#">Write a Review</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Talk</a></li>
                        <li><a href="#">Login</a></li>
                        <li class="Register"><a href="#">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="slider_content">
    <h1>Fresh, fast, Tasty</h1>
</div>

<div class="search_form">
    <div class="container">
        <div class="row">
            <div class="form_main">
                <div class="Logo_f"><img src="{{ URL::asset('images/black-logo.png') }}"></div>
                <ul class="search_Category">
                    <li><a href="#"><i class="icofont icofont-fork-and-knife"></i> Restaurants</a></li>
                    <li><a href="#"><i class="fa fa-glass" aria-hidden="true"></i> Nightlife</a></li>
                    <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i> Home Services</a></li>
                    <li><a href="#"><i class="icofont icofont-fast-delivery"></i> Delivery</a></li>
                </ul>
                <form class="seacrg_city">
                    <div class="col-md-5 col-sm-5 col-xs-12 custom_column">
                        <div class="input-group">
                            <div class="input-group-addon">Find</div>
                            <input type="text" class="form-control" placeholder="dinner, Max’s">
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12 custom_column">
                        <div class="input-group">
                            <div class="input-group-addon">Near</div>
                            <input type="text" class="form-control" placeholder="address, neighborhood, city, state or zip">
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12 custom_column">
                         <button type="submit" class="btn btn-primary search_city_btn"><i class="icofont icofont-search-alt-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- slider -->
<div id="maximage">
      <img src="{{ URL::asset('images/Header-background.jpg') }}" alt="" width="1400" height="1050" />
      <img src="{{ URL::asset('images/slider-2.png') }}" alt="Coalesse" width="1400" height="1050" />
      <img src="{{ URL::asset('images/slider-3.png') }}" alt="Coalesse" width="1400" height="1050" />
</div>
</header><!-- end header -->