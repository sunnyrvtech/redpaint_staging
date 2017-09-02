<header class="header account-header">
    <div class="top_header">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-8">
                    <div class="logo"><a href="{{ url('/') }}"><img src="{{ URL::asset('images/logo.png') }}"></a></div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="search_form">
                        <div class="form_main">
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
                <div class="col-sm-1 pull-right">
                    <div class="notification_wrp">
                        @if(Auth::check())
                        <div class="drop-menu">
                            <span class="user-account_avatar">
                                <img src="{{ URL::asset('images/user_medium_square.png') }}">
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
                                                    <img src="{{ URL::asset('images/user_medium_square.png') }}">
                                                </div>
                                                <div class="detail-per">
                                                    <h3> Red P. </h3>
                                                    <!--<p>Richmond, VA</p>-->
                                                </div>	
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="drop-menus-2">
                                        <li><a href="{{ route('account-profile-overview') }}"><i class="fa fa-user" aria-hidden="true"></i><span>About Me</span></a></li>
                                        <li><a href="{{ route('account-profile') }}"><i class="fa fa-cog" aria-hidden="true"></i><span>Account Setting</span></a></li>
                                        <li><a href="{{ url('/logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search_form menus-wrp">
        <div class="container">
            <div class="row">
                <div class="form_main">
                    <ul class="search_Category">
                        <li><a href="javascript:void(0);"><i class="icofont icofont-fork-and-knife"></i> Restaurants</a></li>
                        <li><a href="javascript:void(0);"><i class="fa fa-glass" aria-hidden="true"></i> Nightlife</a></li>
                        <li><a href="javascript:void(0);"><i class="fa fa-wrench" aria-hidden="true"></i> Home Services</a></li>
                        <li><a href="javascript:void(0);"><i class="icofont icofont-fast-delivery"></i> Delivery</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header><!-- end header -->