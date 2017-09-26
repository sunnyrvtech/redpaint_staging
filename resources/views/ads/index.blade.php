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
                            <h3>Ads</h3>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right">
                        @if(!$ads)
                            <a href="{{ route('ads.create') }}" class="btn btn-primary" type="button">Create Ads</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="content-middle">

                @if($ads)
                <div class="row">
                    <div class="col-md-12">
                            <div class="thumbnail">
                                <img src="{{ URL::asset('/ads_images').'/'.$ads->banner }}" alt="{{ $ads->name }}">
                                <div class="caption">
                                    <h3>{{ $ads->name }}</h3>
                                    <a href="{{ route('ads.show', $ads->id) }}" class="label label-primary" data-toggle="tooltip" title="View Event">View</a>
                                    <a data-href="{{ route('ads.destroy', $ads->id) }}" data-title="Delete Ad Permanently" data-msg="Are you sure you want to delete this ad !" data-method="delete" class="label label-danger confirmationStatus" data-toggle="tooltip" title="Delete">Delete</a>
                                </div>
                            </div>
                    </div>
                </div><!-- End row -->
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
