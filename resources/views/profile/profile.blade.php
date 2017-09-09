@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
        <div class="row">
            <div class="col-sm-3">
                @include('accounts.sidebar')
            </div>
            <div class="col-sm-9">
                <div class="profile-inner-content">
                    <div class="titled-nav-header_content">
                        <h3>Profile Overview</h3>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
