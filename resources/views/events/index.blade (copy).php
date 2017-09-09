@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
        <div class="row">
            <div class="col-sm-3">
                @include('accounts.sidebar') 
            </div>
            <div class="col-sm-9">
                <div class="content-header">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="titled-nav-header_content">
                                <h3>Business Events</h3>
                            </div>
                        </div>
                        <div class="col-md-2 pull-right">
                            <a href="{{ route('events.create') }}" class="btn btn-primary" type="button">Create Event</a>
                        </div>
                    </div>
                </div>
                <div class="content-middle">
                    <div class="row">
                        <?php for ($i = 1; $i <= 9; $i++) { ?>
                            <div class="col-xs-18 col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="{{ URL::asset('images/image-1.png') }}" alt="">
                                    <div class="caption">
                                        <h4>Thumbnail label</h4>
                                        <span class="fa fa-calendar"> Today, Aug 31, 12:00 am</span>
                                        <span class="fa fa-map-marker"> test — San Francisco, CA </span>
                                        <p>Lorem ipsum dolor sit amet,</p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div><!-- End row -->
                </div>
            </div>
        </div>
</div>
@endsection
