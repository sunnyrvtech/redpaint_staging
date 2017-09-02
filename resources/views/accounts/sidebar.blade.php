<div class="sidebar-profile">
    <div class="titled-nav-header_content">
        <h3>{{ Auth::user()->first_name.' '.Auth::user()->last_name }} Account Settings</h3>
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
            <li><a href="{{ route('account-ads_setting') }}" class="@if(Request::path() == 'account/ads_setting')active @endif">Ads Plan Settings</a></li>
            <li><a href="{{ route('account-ads_setting') }}" class="">Reviews</a></li>
            <!--<li><a href="{{ route('account-ads') }}">Add Ads</a></li>-->
            <li><a href="{{ route('account-events') }}" class="@if(Request::path() == 'account/events')active @endif">Events</a></li>
            <li><a href="{{ route('account-events') }}" class="">Order History</a></li>

            @endif
            <!--        <li><a href="javascript:void(0);">Privacy Setting</a></li>
                    <li><a href="javascript:void(0);">External Applications</a></li>-->
        </ul>
    </div>
</div>