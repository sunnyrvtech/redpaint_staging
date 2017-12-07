<header class="header account-header">
    <div class="top_header">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-8">
                    <div class="logo"><a href="{{ url('/') }}"><img src="{{ URL::asset('images/logo.png') }}"></a></div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="search_form">
                        <div class="form_main">
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
                                <div class="col-md-2 col-sm-1 col-xs-12 custom_column">
                                    <button type="submit" class="btn btn-primary search_city_btn"><i class="icofont icofont-search-alt-1"></i></button>
                                </div>
                            </form>
                        </div>	
                    </div>
                </div>
                <div class="col-sm-2 pull-right">
                    <div class="notification_wrp">
                        @if(Auth::check())
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
                                        <li><a href="{{ route('account-profile-overview') }}"><i class="fa fa-user" aria-hidden="true"></i><span>About Me</span></a></li>
                                        <li><a href="{{ route('account-profile') }}"><i class="fa fa-cog" aria-hidden="true"></i><span>Account Setting</span></a></li>
                                        <li><a href="{{ url('/logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="header_menu">
                            <ul>
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            </ul>
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
                        @foreach($categories as $value)
                        <li class="@if(!empty($value->getSubCategory->toArray())) dropdown @endif">
                            <a href="{{ route('search') }}?keyword={{ urlencode($value->name) }}"  @if(!empty($value->getSubCategory->toArray())) class="dropdown-toggle" data-toggle="dropdown" @endif><i class="{{ $value->class_name }}"></i> {{ $value->name }}
                                @if(!empty($value->getSubCategory->toArray())) 
                                <b class="caret"></b>
                                @endif
                            </a>
                            @if(!empty($value->getSubCategory->toArray()))
                            <ul class="dropdown-menu">
                                @foreach($value->getSubCategory->take(10) as $val)
                                <li><a href="{{ route('subcategory.search',$val->id) }}">{{ $val->name }}</a></li>
                                @endforeach
                                @if(count($value->getSubCategory) > 10)
                                <li><a href="{{ route('subcategory.all',$value->id) }}" class="more_sub_cat">More Sub Category</a></li>
                                @endif
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header><!-- end header -->