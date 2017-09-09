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
                            <h3>Profile</h3>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right">
                        <!--<a href="" class="btn btn-primary" type="button">Create Event</a>-->
                    </div>
                </div>
            </div>
            <div class="content-middle">

                <form action="{{ route('profile-update') }}" enctype="multipart/form-data" method="post">
                    {{ csrf_field()}}
                    <div class="form-row">
                        <div class="form-group col-md-6 {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-form-label">First Name</label>
                            <input type="text" required="" class="form-control" name="first_name" value="{{ $users->first_name }}" placeholder="First Name">
                            @if($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 {{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-form-label">Last Name</label>
                            <input type="text" required="" class="form-control" name="last_name" value="{{ $users->last_name }}" placeholder="Last Name">
                            @if($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address" class="col-form-label">Address</label>
                        <input type="text" required="" class="form-control" name="address" value="{{ $users->address }}" placeholder="Address">
                        @if($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 {{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="col-form-label">City</label>
                            <input type="text" required="" class="form-control" name="city" value="{{ $users->city }}" placeholder="City">
                            @if($errors->has('city'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 {{ $errors->has('state') ? ' has-error' : '' }}">
                            <label for="state" class="col-form-label">State</label>
                            <input type="text" required="" class="form-control" value="{{ $users->state }}" name="state" placeholder="State">
                            @if($errors->has('state'))
                            <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 {{ $errors->has('zip') ? ' has-error' : '' }}">
                            <label for="zip" class="col-form-label">Zip</label>
                            <input type="text" required="" class="form-control" name="zip" value="{{ $users->zip }}" placeholder="Zip">
                            @if($errors->has('zip'))
                            <span class="help-block">
                                <strong>{{ $errors->first('zip') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 {{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label for="country" class="col-form-label">Country</label>
                            <select name="country_id" required="" class="form-control">
                                <option value="">Select Country</option>
                                @foreach($countries as $val)
                                <option @if($users->country_id == $val->id) selected @endif value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('country_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('country_id') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="pro-browse">
                                <button class="btn btn-success browse" type="button">Browse Files</button>
                            </div>
                            <input style="display: none;" id="file_type" name="profile_image" class="profile_file" type="file">
                            <span class="label label-info" id="upload-file-info"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group text-center" id="previewImage">
                                @if(!empty($users->user_image))
                                <img width="100%" src="{{ URL::asset('/user_images').'/'.$users->user_image }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(".profile_file").change(function () {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    HTML = '<div class="thumbnail"><img width="100%" src="' + event.target.result + '"></div>';
                    $("#previewImage").html(HTML);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>
@endpush
