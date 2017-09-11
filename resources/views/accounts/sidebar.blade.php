<div class="sidebar-profile">
    <div class="titled-nav-header_content">
        <h3>{{ Auth::user()->first_name.' '.str_limit(Auth::user()->last_name, $limit = 1, $end = '.') }} Account Settings</h3>
    </div>
    <div class="titled-nav_items">
        <ul>
            <?php
            $route_array = array('account-profile', 'account-password');
            ?>
            @if(in_array(Route::currentRouteName(),$route_array))
            <li><a href="{{ route('account-profile') }}" class="@if(Request::path() == 'account/profile')active @endif">Profile</a></li>
            <li><a href="{{ route('account-password') }}" class="@if(Request::path() == 'account/password')active @endif">Change Password</a></li>
            @else
            <li><a href="{{ route('account-profile-overview') }}" class="@if(Request::path() == 'account/profile/overview')active @endif">Profile Overview</a></li>
            <li><a href="{{ route('account-subscription') }}" class="@if(Request::path() == 'account/subscription')active @endif">Ads Plan Settings</a></li>
            <!--<li><a href="#" class="">Reviews</a></li>-->
            @if(Auth::user()->subscribed('ads_subscription'))
            <li><a href="javascript:void(0);">Add Ads</a></li>
            @endif
            <li><a href="{{ route('events.index') }}" class="@if(Request::path() == 'account/events')active @endif">Events</a></li>
            <!--<li><a href="{{ route('events.index') }}" class="">Order History</a></li>-->

            @endif
            <!--        <li><a href="javascript:void(0);">Privacy Setting</a></li>
                    <li><a href="javascript:void(0);">External Applications</a></li>-->
        </ul>
    </div>
</div>