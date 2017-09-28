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

                @forelse($events as $value)
                <?php 
                $event_images = isset($value->getOwnerEventImages->event_images)?json_decode($value->getOwnerEventImages->event_images):array('default.jpg'); 
                if(empty($event_images)){
                    $event_images = array('default.jpg');
                }
                ?>
                <div class="row">
                    <div class="col-md-12">
                       <div class="row">
                       <div class="business-event-wrap">
                        <div class="col-md-3">
                            <div class="thumbnail">
                                <a href="{{ route('events',$value->event_slug) }}"><img src="{{ URL::asset('/event_images').'/'.$event_images[0] }}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <a href="{{ route('events',$value->event_slug) }}"><h3>{{ $value->name }}</h3></a>
                                <span class="fa fa-calendar"> {{ date('M d, m:i A',strtotime($value->created_at)) }}</span>
                                <span class="fa fa-map-marker"> {{ $value->city.','.$value->state }} </span>
<!--                                <p>Lorem ipsum dolor sit amet,</p>-->
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <a href="{{ route('photo.view', $value->event_slug) }}" class="label label-primary" data-toggle="tooltip" title="All Images">All Images</a>
                                <a href="{{ route('events.show', $value->id) }}" class="label label-primary" data-toggle="tooltip" title="Update">Update</a>
                                <?php
                                if ($value->status == 1) {
                                    $status = 'Active';
                                    $status_title = 'Deactivate';
                                } else {
                                    $status = 'Deactive';
                                    $status_title = 'Activate';
                                }
                                ?>
                                <a data-href="{{ route('events-status', $value->id) }}" data-id="{{ $status_title }}" data-title="{{ $status_title }} Event" data-msg="Are you sure you want to {{ $status_title }} this event !" data-method="post" class="label label-success confirmationStatus" data-toggle="tooltip" title="{{ $status }}">{{ $status }}</a>
                                <a data-href="{{ route('events.destroy', $value->id) }}" data-title="Delete Event Permanently" data-msg="Are you sure you want to delete this event !" data-method="delete" class="label label-danger confirmationStatus" data-toggle="tooltip" title="Delete">Delete</a>
                                <a href="{{ route('photo.show',$value->event_slug) }}" class="label label-warning" data-toggle="tooltip" title="Add Photo">Add Photo</a>
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>
                </div><!-- End row -->
                @empty
                <div class="row">No Event Founds!</div>
                @endforelse
                 <div class="pagination_main_wrapper text-center">{{ $events->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
