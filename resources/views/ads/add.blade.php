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
                            <h3>Add Ads</h3>
                        </div>
                    </div>
                    <!--                    <div class="col-md-2 pull-right">
                                            <a href="" class="btn btn-primary" type="button">Create Event</a>
                                        </div>-->
                </div>
            </div>
            <div class="content-middle">
                <form action="{{ route('ads.store') }}" enctype="multipart/form-data" method="post">
                    {{ csrf_field()}}
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="event_name" class="col-form-label">Ads Name</label>
                        <input type="text" required="" class="form-control" name="name" value="{{ old('name') }}" placeholder="Ads Name">
                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('link') ? ' has-error' : '' }}">
                        <label for="category_id" class="col-form-label">Website Link</label>
                        <input type="text" required="" class="form-control" name="link" value="{{ old('link') }}" placeholder="Website Link">
                        @if ($errors->has('link'))
                        <span class="help-block">
                            <strong>{{ $errors->first('link') }}</strong>
                        </span>
                        @endif
                    </div>       
                    <div class="form-group {{ $errors->has('banner') ? ' has-error' : '' }}">
                        <label for="banner" class="col-form-label">Banner</label>
                        <div class="pro-browse">
                            <button class="btn btn-success browse" type="button">Browse Files</button>
                        </div>
                        <input style="display: none;" id="file_type" name="banner" class="file" type="file">
                        @if ($errors->has('banner'))
                        <span class="help-block">
                            <strong>{{ $errors->first('banner') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="form-group text-center">
                            <img style="display: none;" id="blah" src="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush
