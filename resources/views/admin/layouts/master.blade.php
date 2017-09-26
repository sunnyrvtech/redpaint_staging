<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token()}}">

        <title>{{ $title}}</title>

        <!-- Bootstrap Core CSS -->
        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="{{ URL::asset('/css/sb-admin.css') }}" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">-->
        <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.css" rel="stylesheet">   
        <link href="//cdn.datatables.net/1.10.13/css/dataTables.semanticui.min.css" rel="stylesheet">   

    </head>

    <body>
        <div id="loaderOverlay" style="display: none;">
            <div class="loader">
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
                <div class="side"></div>
            </div>
        </div>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/')}}">Redpaint Admin</a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->first_name }}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0);"><i class="fa fa-fw fa-gear"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ url('/logout')}}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="@if(Request::segment(2) == 'admin')active @endif">
                            <a href="{{ url('admin')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li class="@if(Request::segment(2) == 'users')active @endif">
                            <a href="{{ route('users.index')}}"><i class="fa fa-fw fa-user "></i> Users</a>
                        </li>
                        <li class="@if(Request::segment(2) == 'categories' || Request::segment(2) == 'subcategories')active @endif">
                            <a href="{{ route('categories.index')}}"><i class="fa fa-fw fa-tags"></i> Categories</a>
                        </li>
                        <li class="@if(Request::segment(2) == 'packages')active @endif">
                            <a href="{{ route('packages.index')}}"><i class="fa fa-fw fa-credit-card"></i>Packages</a>
                        </li>
                        <li class="@if(Request::segment(2) == 'ads_list')active @endif">
                            <a href="{{ route('ads_list.index')}}"><i class="fa fa-fw fa-credit-card"></i>Ads</a>
                        </li>
                        <!--                        <li class="">
                                                    <a href=""><i class="fa fa-fw fa-files-o"></i>Pages</a>
                                                </li>-->
                        <!--                        <li class="">
                                                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#vehicle-menu"><i class="fa fa-fw fa-car"></i> Vehicles<i class="fa fa-fw fa-caret-down"></i></a>
                                                    <ul id="vehicle-menu" class="collapse" >
                                                        <li class="">
                                                            <a href="">Vehicle Models</a>
                                                        </li>
                                                        <li class="">
                                                            <a href="">Vehicle Companies</a>
                                                        </li>
                                                    </ul>
                                                </li>-->
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <div id="page-wrapper">
                @if(Session::has('success-message') || Session::has('error-message'))
                <div id="redirect_alert" class="alert @if(Session::has('success-message')) alert-success @elseif(Session::has('error-message')) alert-danger @endif fade in alert-dismissable">
                    <a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>
                    <strong>@if(Session::has('success-message')) Success! @elseif(Session::has('error-message')) Error! @endif </strong>@if(Session::has('success-message')) {{ Session::pull('success-message') }} @elseif(Session::has('error-message')) {{ Session::pull('error-message') }} @endif
                </div>
                @endif
                @yield('content')
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Record Permanantly</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default deleteRowRecord">Yes</button>
                        <button type="button" class="btn btn-default" onclick="$('#deleteModal').modal('hide');">No</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- jQuery -->
        <script src="{{ URL::asset('js/jquery.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/dataTables.semanticui.min.js"></script>
        <!--<script src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.js "></script>-->
        <script type="text/javascript">
                            $(document).ready(function () {
                                $("body").tooltip({selector: '[data-toggle=tooltip]', trigger: 'hover'});
                                //initialize ckeditor        
//                                $('textarea').ckeditor({
//                                    enterMode: CKEDITOR.ENTER_DIV,
//                                    allowedContent: true
//                                });
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $(document).on('click', '.deleteRow', function (e) {
                                    e.preventDefault(); // does not go through with the link.
                                    var $this = $(this);
                                    $("#deleteModal").modal('show');
                                    $(".deleteRowRecord").attr('data-method', $this.data('method'));
                                    $(".deleteRowRecord").attr('data-href', $this.attr('href'));
                                });
                                $(document).on('click', '.deleteRowRecord', function (e) {

                                    e.preventDefault(); // does not go through with the link.
                                    var $this = $(this);
                                    $this.attr('disabled', 'disabled');
                                    $.post({
                                        type: $this.data('method'),
                                        url: $this.data('href')
                                    }).done(function (data) {
                                        window.location.reload();
                                    });
                                });

                                $(document).on('click', '.status-toggle', function (e) {
                                    e.preventDefault(); // does not go through with the link.
                                    $(".alert-danger").remove();
                                    $(".alert-success").remove();
                                    var $this = $(this);
                                    $this.find('.btn').toggleClass('active');

                                    if ($this.find('.btn-primary').size() > 0) {
                                        $this.find('.btn').toggleClass('btn-primary');
                                    }
                                    if ($this.find('.btn-default').size() > 0) {
                                        $this.find('.btn').toggleClass('btn-default');
                                    }

                                    $.post({
                                        data: {'id': $this.data('id'), 'status': $this.find('.active').data('value')},
                                        url: $this.data('url')
                                    }).done(function (data) {
                                        var HTML = '<div class="alert alert-success fade in">';
                                        HTML += '<a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>';
                                        HTML += '<strong>Success! </strong>' + data.messages + '</div>';
                                        $("#page-wrapper .container-fluid").before(HTML);
                                        $(window).scrollTop(0);
                                    }).fail(function (data) {
                                        var HTML = '<div class="alert alert-danger fade in">';
                                        HTML += '<a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>';
                                        HTML += '<strong>Error! </strong>' + data.responseJSON.error + '</div>';
                                        $("#page-wrapper .container-fluid").before(HTML);
                                        $(window).scrollTop(0);
                                    });
                                });
                                $(document).on('click', '.browse', function () {
                                    var file = $("#file_type");
                                    file.trigger('click');
                                });
                                $(".file").change(function () {
                                    readURL(this);
                                });

                                function readURL(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();
                                        reader.onload = function (event) {
                                            $('#blah').show();
                                            $('#blah').attr('src', event.target.result);
                                        }
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                            });
        </script>
        <!-- App scripts -->
        @stack('scripts')
    </body>
</html>
