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
                        <h3>{{ ucfirst($events->name) }}:-</h3>
                    </div>
                </div>
                <div class="col-md-2 pull-right">
                    @if(Auth::user()->role_id == 2)
                    <a href="{{ route('events.index') }}" class="btn btn-primary" type="button">Back To Listing</a>
                    @endif
                </div>
            </div>
            <div class="row">
                <form method="POST" id="imageForm" action="{{ route('photo.update',$events->event_slug) }}" enctype="multipart/form-data">
                    <input name="_method" value="PUT" type="hidden">
                    {{ csrf_field()}}
                    <div class="row">
                        <div class="form-group text-center{{ $errors->has('event_images') ? ' has-error' : '' }}">
                            <div class="browse-btn">
                                <button class="btn btn-primary browse" type="button">Browse Files</button>
                            </div>
                            <input style="display: none;" id="file_type" name="event_images[]" class="photo_file" multiple="" type="file">
                            @if($errors->has('event_images'))
                            <span class="help-block">
                                <strong>{{ $errors->first('event_images') }}</strong>
                            </span>
                            @endif
    <!--                        <span style="font-size: 0">
                                <button class="btn btn-default" type="submit">Add Photo</button>
                            </span>-->
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="renderPreviewImage clearfix">
                    <?php $i = 1; ?>
                    @foreach($event_images as $key=>$value)
                    <?php $photos = json_decode($value->event_images); ?>
                    @if($key == 0)
                    <h3>{{ ucfirst($events->name) }}'s images :-</h3>
                    @endif
                    @foreach($photos as $val)
                    <div class="@if($i%3 == 0) col-md-3 col-xs-12 col-sm-12 @else col-xs-6 col-sm-6 col-md-3 @endif">
                        <a href="{{ URL::asset('/event_images').'/'.$val }}" data-fancybox data-caption="">                        
                            <div class="thumbnail">
                                <img  style="height:200px;width:100%;" src="{{ URL::asset('/event_images').'/'.$val }}">
                                <!--<div class="caption">-->
                                    <!--<p><span>Submitted By:-</span> {{ $value->getUserByEventImageUserId->first_name.' '.$value->getUserByEventImageUserId->last_name }}</p>-->
                                @if($events->user_id == Auth::id()) 
                                <!--<a data-href="{{ route('photo.destroy', $value->event_id) }}" data-id="{{ $val }}" data-title="Delete event image" data-msg="Are you sure you want to delete this event image!" data-method="delete" class="label label-danger confirmationStatus" data-toggle="tooltip" title="Delete event image">Delete</a>-->
                                @endif
                                <!--</div>-->
                            </div>
                        </a>
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
<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    $(document).on('change', '.photo_file', function (e) {
        $("#loaderOverlay").removeClass('ng-hide');
        document.getElementById("imageForm").submit();
//            $(".renderPreviewImage").html('');
//            $.each(e.originalEvent.target.files, function (i, file) {
//                var reader = new FileReader();
//                reader.onloadend = function () {
//                    var HTML = '<div class="col-md-4">';
//                    HTML += '<div class="thumbnail"><img width="100%" src="' + reader.result + '"></div>';
//                    HTML += '</div>';
//                    $(".renderPreviewImage").append(HTML);
//                }
//                reader.readAsDataURL(file);
//            });
    });
});
</script>
@endpush



