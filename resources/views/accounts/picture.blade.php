@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
        <div class="row">
            <div class="col-sm-3">
                @include('accounts.sidebar')
            </div>

            <div class="col-sm-9">
                <div class="profile-inner-content">
                    <div class="titled-nav-header_content">
                        <h3>Location</h3>
                    </div>


                    <form method="POST" action="#" enctype="multipart/form-data">
                        <!-- COMPONENT START -->
                        <div class="form-group">
                            <div class="input-group input-file" name="Fichier1">
                                <span class="input-group-btn">
                                    <button class="btn btn-default browse" style="padding: 10px;" type="button">Choose</button>
                                </span>
                                <input type="text" class="form-control" placeholder='Choose a file...' />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Submit</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    function bs_input_file() {
        $(".input-file").before(
                function () {
                    if (!$(this).prev().hasClass('input-ghost')) {
                        var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                        element.attr("name", $(this).attr("name"));
                        element.change(function () {
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                        });
                        $(this).find("button.btn-choose").click(function () {
                            element.click();
                        });
                       
                        $(this).find('input').css("cursor", "pointer");
                        $(this).find('input').mousedown(function () {
                            $(this).parents('.input-file').prev().click();
                            return false;
                        });
                        return element;
                    }
                }
        );
    }
    $(function () {
        bs_input_file();
    });
</script>
@endpush



