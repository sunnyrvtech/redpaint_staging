@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="row">
        <div class="profile-inner-content">
            <div class="row">
                <div class="col-md-8">
                    <div class="titled-nav-header_content">
                        <h3></h3>
                    </div>
                </div>
                <div class="col-md-2 pull-right">

                </div>
            </div>
            <div class="row">
                @forelse($ads as $val)
                <div class="col-md-6">
                    <div class="item">
                        <a target="_blank" href="{{ $val->link }}"><img src ="{{ URL::asset('/ads_images').'/'.$val->banner }}">
                    </div>
                </div>
                @empty
                <div class="row">No ads Founds!</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '.photo_file', function (e) {
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



