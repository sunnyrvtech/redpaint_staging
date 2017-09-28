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
                            <h3>Add Events</h3>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right">
                        <a href="{{ route('events.create') }}" class="btn btn-primary" type="button">Create Event</a>
                    </div>
                </div>
            </div>
            <div class="content-middle">
                <form action="{{ route('events.update',$events->id)}}" method="post">
                    <input name="_method" value="PUT" type="hidden">
                    {{ csrf_field()}}
                    <div class="form-row">
                        <div class="form-group col-md-6{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="event_name" class="col-form-label">Event Name</label>
                            <input type="text" required="" class="form-control" name="name" value="{{ $events->name }}" placeholder="Event Name">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-form-label">Category</label>
                            <select name="category_id" required="" class="form-control">
                                <option value="">Select category</option>
                                @foreach($categories as $value)
                                <option @if($events->category_id == $value->id)selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-form-label">What & Why</label>
                        <textarea class="form-control" name="description">{{ $events->description }}</textarea>
                        @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6{{ $errors->has('website_url') ? ' has-error' : '' }}">
                            <label for="website_url" class="col-form-label">Website Url</label>
                            <input type="text" class="form-control" name="website_url" value="{{ $events->website_url }}" placeholder="Website Url">
                            @if ($errors->has('website_url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('website_url') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6{{ $errors->has('zip') ? ' has-error' : '' }}">
                            <label for="zip" class="col-form-label">Zip</label>
                            <input type="text" required="" class="form-control zipCode" name="zip" value="{{ $events->zip }}" placeholder="Zip">
                            @if ($errors->has('zip'))
                            <span class="help-block">
                                <strong>{{ $errors->first('zip') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-form-label">Address</label>
                            <input type="text" required="" class="form-control" id="address" name="address" value="{{ $events->address }}" placeholder="Address">
                            @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="col-form-label">City</label>
                            <input type="text" required="" class="form-control" id="city" name="city" value="{{ $events->city }}" placeholder="City">
                            @if ($errors->has('city'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6{{ $errors->has('state') ? ' has-error' : '' }}">
                            <label for="state" class="col-form-label">State</label>
                            <input type="text" required="" class="form-control" id="state" name="state" value="{{ $events->state }}" placeholder="State">
                            @if ($errors->has('state'))
                            <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6{{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label for="country" class="col-form-label">Country</label>
                            <select name="country_id" id="country_id" required="" class="form-control">
                                <option value="">Select Country</option>
                                @foreach($countries as $val)
                                <option @if($events->country_id == $val->id) selected @endif value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('country_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('country_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6{{ $errors->has('price_to') ? ' has-error' : '' }}">
                            <label for="price_to" class="col-form-label">Price To</label>
                            <input type="text" class="form-control" required="" name="price_to" value="{{ $events->price_to }}" placeholder="Price To">
                            @if ($errors->has('price_to'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price_to') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6{{ $errors->has('price_from') ? ' has-error' : '' }}">
                            <label for="price_from" class="col-form-label">Price From</label>
                            <input type="text" class="form-control" required="" name="price_from" value="{{ $events->price_from }}" placeholder="Price From">
                            @if ($errors->has('price_from'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price_from') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <?php
                    $time_array = array('Mon', "Tue", 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
                    $operation_hour = json_decode($events->operation_hour);
                    ?>
                    <div class="form-row lock_hour_html">
                        @foreach($time_array as $key=>$val)
                        <div class="form-group col-md-4">
                            @if($key == 0)
                            <label for="day" class="col-form-label">Week Day</label>
                            @endif
                            <input type="text" class="form-control" name="day[]" value="{{ $val }}" readonly="">
                        </div>
                        <div class="form-group col-md-3">
                            @if($key == 0)
                            <label for="time_from" class="col-form-label">Time From</label>
                            @endif
                            <input type="text" class="form-control datetimepicker" name="time_from[]" value="{{ isset($operation_hour[$key]->time_from)?$operation_hour[$key]->time_from:'' }}">
                        </div>
                        <div class="form-group col-md-3">
                            @if($key == 0)
                            <label for="time_to" class="col-form-label">Time To</label>
                            @endif
                            <input type="text" class="form-control datetimepicker" name="time_to[]" value="{{ isset($operation_hour[$key]->time_to)?$operation_hour[$key]->time_to:'' }}">
                        </div>
                        <div class="form-group col-md-2">
                            @if($key == 0)
                            <label for="hour_status" class="col-form-label">Status</label>
                            @endif
                            <input type="hidden" name="status[]" value="1" />
                            <input type="checkbox" class="form-control" name="status[]" @if(isset($operation_hour[$key]->status) && $operation_hour[$key]->status == 0) checked @endif value="o">
                        </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
