<header class="header">
    <div class="top_header">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-8">
                    <div class="logo"><a href="{{ url('/') }}"><img src="{{ URL::asset('images/logo.png') }}"></a></div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <button class="menu_mobile"><i class="fa fa-bars" aria-hidden="true"></i></button>
                    <div class="header_menu">
                        <ul>
                            <!--<li><a href="#">Write a Review</a></li>-->
                            <!--<li><a href="">Events</a></li>-->
                            <li><a href="{{ route('ads') }}">Ads</a></li>
                            <li><a href="{{ route('search') }}?keyword=daily_deals">Daily Deals</a></li>
                            @if(!Auth::check())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li class="Register"><a href="{{ route('register') }}">Register</a></li>
                            @else
                            <li>
                                <div class="drop-menu">
                                    <span class="user-account_avatar">
                                        <?php
                                        if (Auth::user()->user_image) {
                                            $user_image = Auth::user()->user_image;
                                        } else {
                                            $user_image = 'default.png';
                                        }
                                        ?>
                                        <img src="{{ URL::asset('/user_images').'/'.$user_image }}">
                                    </span>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <ul class="drop-menus-1">
                                                <li>
                                                    <div class="menu-drop">
                                                        <div class="per-img">
                                                            <img src="{{ URL::asset('/user_images').'/'.$user_image }}">
                                                        </div>
                                                        <div class="detail-per">
                                                            <h3> {{ Auth::user()->first_name.' '.str_limit(Auth::user()->last_name, $limit = 1, $end = '.') }}</h3>
                                                            <!--<p>Richmond, VA</p>-->
                                                        </div>	
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="drop-menus-2">
                                                @if(Auth::user()->role_id == 2)
                                                <li><a href="{{ route('events.create') }}"><i class="fa fa-user" aria-hidden="true"></i><span>About Me</span></a></li>
                                                @endif
                                                <li><a href="{{ route('account-profile') }}"><i class="fa fa-cog" aria-hidden="true"></i><span>Account Setting</span></a></li>
                                                <li><a href="{{ url('/logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="slider_content">
        <h1>Taste Your City</h1>
    </div>

    <div class="search_form">
        <div class="container">
            <div class="row">
                <div class="form_main">
                    <div class="Logo_f"><img src="{{ URL::asset('images/black-logo.png') }}"></div>
                    <ul class="search_Category">
                        <li><a href="{{ route('search') }}?keyword={{ urlencode('daily deals') }}"><i class="fa fa-dollar"></i><span>Daily Deals</span></a></li>
                        <li><a href="{{ route('search') }}?keyword={{ urlencode('happy') }}"><i class="fa fa-glass"></i><span>Happy Hour</span></a></li>
                        <li><a href="{{ route('search') }}?keyword={{ urlencode('brunch') }}"><i class="icofont icofont-egg-poached"></i><span>Brunch</span></a></li>
                        <li><a href="{{ route('search') }}"><i class="icofont icofont-fork-and-knife"></i><span>All</span></a></li>
                    </ul>
                    <form class="seacrg_city" action="{{ route('search') }}">
                        <div class="col-md-5 col-sm-5 col-xs-12 custom_column">
                            <div class="input-group">
                                <div class="input-group-addon">Find</div>
                                <input type="text" class="form-control typeahead" autocomplete="off" data-url="{{ route('events-autosearch') }}" name="keyword" placeholder="dinner, Max’s">
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12 custom_column">
                            <div class="input-group">
                                <div class="input-group-addon">Near</div>
                                <input type="text" class="form-control typeahead" autocomplete="off" data-url="{{ route('address-autosearch') }}" name="address" placeholder="address, city, state or zip">
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