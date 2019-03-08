@extends('layouts.app')
@push('stylesheet')
<link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}" />
<style>
    .container { padding-right: 0;padding-left: 0; }
    .row { margin-right: 0px;margin-left: 0px; }
    .col-md-3{ padding-right: 0;padding-left: 0; }
    .thumbnail { margin-bottom: 0; }
</style>
@endpush
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
                    <a href="jaascript:void(0);" onclick="javascript:history.go(-1);return false;" class="btn btn-primary" type="button">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="renderPreviewImage clearfix">
                    <?php $i = 1; ?>
                    @foreach($events->getEventImages as $key=>$value)
                    <?php $photos = json_decode($value->event_images); ?>
                    @foreach($photos as $val)
                    <div class="@if($i%3 == 0) col-md-3 col-xs-12 col-sm-12 @else col-xs-6 col-sm-6 col-md-3 @endif">
                        <a href="{{ URL::asset('/event_images').'/'.$val }}" data-fancybox data-caption="<p><span>Uploaded By:-</span> {{ $value->getUserByEventImageUserId->first_name.' '.$value->getUserByEventImageUserId->last_name }}</p>@if($events->user_id == Auth::id())<a data-href={{ route('photo.destroy', $value->event_id) }} data-id='{{ $val }}' data-title='Delete event image' data-msg='Are you sure you want to delete this event image!' data-method='delete' class='label label-danger confirmationStatus' data-toggle='tooltip' title='Delete event image'>Delete</a> @endif">
                        <div class="thumbnail">
                            <img src="{{ URL::asset('/event_images').'/'.$val }}">
                        </div>
                    </a>
                    </div>
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
 <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
<script type="text/javascript">
</script>
@endpush
