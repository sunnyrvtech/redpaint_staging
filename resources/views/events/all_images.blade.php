@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="row">
        <div class="profile-inner-content">
            <div class="row">
                <div class="col-md-8">
                    <div class="titled-nav-header_content">
                        <h3>{{ ucfirst($events->name) }}'s images: -</h3>
                    </div>
                </div>
                <div class="col-md-2 pull-right">
                    <a href="jaascript:void(0);" onclick="window.history.back();" class="btn btn-primary" type="button">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="renderPreviewImage clearfix">
                    <?php $i = 1; ?>
                    @foreach($events->getEventImages as $key=>$value)
                    <?php $photos = json_decode($value->event_images); ?>
                    @foreach($photos as $val)
                    <div class="col-md-3">
                        <div class="thumbnail">
                            <img style="min-height: 248px;max-height: 60px;" src="{{ URL::asset('/event_images').'/'.$val }}">
                            <div class="caption">
                                <p><span>Submitted By:-</span> {{ $value->getUserByEventImageUserId->first_name.' '.$value->getUserByEventImageUserId->last_name }}</p>
                                @if($events->user_id == Auth::id()) 
                                <a data-href="{{ route('photo.destroy', $value->event_id) }}" data-id="{{ $val }}" data-title="Delete event image" data-msg="Are you sure you want to delete this event image!" data-method="delete" class="label label-danger confirmationStatus" data-toggle="tooltip" title="Delete event image">Delete</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($i%4 == 0)
                    <div class="clearfix"></div>
                    @endif
                    <?php $i++; ?>
                    @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
</script>
@endpush



