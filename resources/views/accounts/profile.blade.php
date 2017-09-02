@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('accounts.sidebar')
            </div>

            <div class="col-sm-9">
                <div class="profile-inner-content">
                    <div class="titled-nav-header_content">
                        <h3>Profile</h3>
                    </div>
                    <form method="post" action="{{ url('stripe/webhook') }}">

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
