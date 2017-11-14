@extends('admin/layouts.master')
@push('stylesheet')
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Event Images
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div id="content">
            <?php $i = 1; ?>
            @foreach($event_images as $key=>$value)
            <?php $photos = json_decode($value->event_images); ?>
            @foreach($photos as $val)
            @if($i%5 == 0 || $i == 1)
            <div class="row">
                @endif
                <div class="col-md-3 @if($i > $show_limit) not_active @endif">
                    <div class="thumbnail">
                        <img style="min-height: 248px;" src="{{ URL::asset('/event_images').'/'.$val }}">
                        <div class="caption">
                            <p><span>Submitted By:-</span> {{ $value->getUserByEventImageUserId->first_name.' '.$value->getUserByEventImageUserId->last_name }}</p>
                            <a data-href="{{ route('business.image.delete', $value->event_id) }}" data-id="{{ $val }}" class="label label-danger deleteEventImage" data-toggle="tooltip" title="Delete event image">Delete</a>
                        </div>
                    </div>
                </div>
                @if($i%4 == 0)
            </div>
            @endif
            <?php $i++; ?>
            @endforeach
            @endforeach
        </div>
    </div>

    <div class="row text-center" id="load_more">
        @if(!empty($event_images->toArray()) && $total_count > count($event_images))
        <a href="javascript:void(0);" data-page="{{ $page }}" class="load_more btn btn-success">Load More</a>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deleteImageModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete event image</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this event image ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default deleteImageRow">Yes</button>
                    <button type="button" class="btn btn-default" onclick="$('#deleteImageModal').modal('hide');">No</button>
                </div>
            </div>

        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var default_limit = "{{ $default_limit }}";
        $(document).on("click", ".load_more", function () {
            var not_active = $('#content .not_active').length;
            var page = $(this).attr('data-page');
            if (page != 0) {
                if (not_active < default_limit) {
                    page = parseInt(page) + 1;
                    $(this).attr('data-page', page);
                    $.post({
                        type: 'get',
                        url: "{{ route('business-images', 2) }}",
                        data: 'page=' + page + '&show_limit=' + default_limit
                    }).done(function (data) {
                        var found = $(data).find("#content").html();
                        $("#content").append(found);
                        $("#load_more").html($(data).find("#load_more").html());
                    });
                } else {
                    $('#content').find('.not_active:lt(' + default_limit + ')').removeClass('not_active');
                }
            } else {
                $('#content').find('.not_active:lt(' + default_limit + ')').removeClass('not_active');
                $("#load_more").remove();
            }
        });

        $(document).on('click', '.deleteEventImage', function () {
            var $this = $(this);
            $("#deleteImageModal").modal('show');
            $(".deleteImageRow").attr('data-id', $this.attr('data-id'));
            $(".deleteImageRow").attr('data-href', $(this).attr('data-href'));
        });
        $(document).on('click', '.deleteImageRow', function (e) {

            e.preventDefault(); // does not go through with the link.
            var $this = $(this);
            $this.attr('disabled', 'disabled');
            $.post({
                type: 'post',
                url: $this.attr('data-href'),
                data: { name: $this.attr('data-id') }
            }).done(function (data) {
                //window.location.reload();
            });
        });







    });
</script>
@endpush