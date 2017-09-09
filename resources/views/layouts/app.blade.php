<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Website font -->
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <!-- Styles -->
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" >
    <!-- fonts icons -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/icofont.css') }}">  

    <!-- Main style css -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    @stack('stylesheet')

</head>
<body ng-app="redPaintApp" ng-controller="redPaintController">
    <div id="loaderOverlay" ng-show="loading">
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
    @if(Request::is('/') || Request::path() == 'home')
        @include('layouts.index-header')
    @else
        @include('layouts.header')
    @endif
<section>
    <div class="alert-message">
            <div id="alert_loading" class="alert fade in alert-dismissable" ng-show="alert_loading" ng-class="alertClass" style="display: none;">
                <a href="javascript:void(0);" ng-click="alert_loading = false" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <strong><% alertLabel %> </strong><% alert_messages %>
            </div>
            @if(Session::has('success-message') || Session::has('error-message'))
            <div id="redirect_alert" class="alert @if(Session::has('success-message')) alert-success @elseif(Session::has('error-message')) alert-danger @endif fade in alert-dismissable">
                <a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <strong>@if(Session::has('success-message')) Success! @elseif(Session::has('error-message')) Error! @endif </strong>@if(Session::has('success-message')) {{ Session::pull('success-message') }} @elseif(Session::has('error-message')) {{ Session::pull('error-message') }} @endif
            </div>
            @endif
        </div>
        <div class="container">
            @if(Auth::check() && !Request::is('/'))
                @if(Auth::user()->subscribed('ads_subscription'))
                <div class="notice notice-success">
                    <strong>Notice:-</strong> Hi {{ Auth::user()->first_name }}! Your currently active plan is <strong>{{ Auth::user()->get_active_plan->stripe_plan }}</strong>.If you want to cancel,upgrade or downgrade plan ,please visit here <strong><a href="{{ route('account-subscription') }}">Change plan</a></strong>
                </div>
                @elseif(Auth::user()->get_active_plan && Auth::user()->subscription('ads_subscription')->cancelled())
                <div class="notice notice-success">
                <strong>Notice:-</strong> Hi {{ Auth::user()->first_name }}! You have cancelled your subscription,please visit here to resume your subscription <strong><a href="{{ route('account-subscription') }}">resume</a></strong>.
                </div>
                @else
                <div class="notice notice-success">
                    <strong>Notice:-</strong> Hi {{ Auth::user()->first_name }}! You have not subscribed any ads plan yet,please subscribed ads plan to lists adspace.Please click here to <strong><a href="{{ route('account-subscription') }}">purchase</a></strong>
                </div>
                @endif
            @endif
            <div id="content">
                @yield('content')
            </div>
        </div>
</section><!-- end section -->
<!-- Confirmation modal-->
    <div class="modal fade" id="confirmationModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><!-- title append in ajax --></h4>
                </div>
                <div class="modal-body">
                    <!-- body message append in ajax -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default confirmation-success">Yes</button>
                    <button type="button" class="btn btn-default" onclick="$('#confirmationModal').modal('hide');">No</button>
                </div>
            </div>
        </div>
    </div>
<footer>
    <div class="container">
        <div class="col-md-3 col-sm-3 col-xs-12 address">
            <h2>Get in touch</h2>
            <address>
                <span>ADDRESS:</span> 4578 Marmora Road,<br/> Glasgow D04 89GR
                <br/>
                <br/>
                <span>PHONE: </span>800-2345-6789
            </address>
            <ul class="footer_social">
                <li><a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 info-Link">
            <h2>info Link</h2>
            <ul>
                <li><a href="javascript:void(0);">About Yelp</a></li>
                <li><a href="javascript:void(0);">Order Food on Eat24</a></li>
                <li><a href="javascript:void(0);">Careers</a></li>
                <li><a href="javascript:void(0);">Press</a></li>
                <li><a href="javascript:void(0);">Investor Relations</a></li>
                <li><a href="javascript:void(0);">Content Guidelines</a></li>
                <li><a href="javascript:void(0);">Terms of Service</a></li>
                <li><a href="javascript:void(0);">Privacy Policy</a></li>
                <li><a href="javascript:void(0);">Ad Choices</a></li>
            </ul>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 instagram_gallery">
            <h2>instagram</h2>
                <ul>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-1.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-2.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-3.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-1.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-2.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-3.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-1.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-2.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-3.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-1.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-2.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-3.png') }}"></a></li>
            </ul>
        </div>
    </div>

<div class="bottom_footer">
    <div class="container">
        <div class="copyright">Site name © 2017 All Rights Reserved <strong>Terms of Use</strong> and <strong>Privacy Policy</strong></div>

        <p id="back-top">
            <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
        </p>
    </div>
</div>
</footer><!-- end footer -->
<!-- Scripts -->
<script src="{{ URL::asset('js/jquery.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.2/angular.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.2/angular-sanitize.min.js"></script>     
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
@stack('scripts')
<script type="text/javascript">
     var BaseUrl = "<?php echo url('/') ?>";
     setTimeout(function () {
        $("#redirect_alert").remove();
    }, 8000);
    $("body").tooltip({selector: '[data-toggle=tooltip]', trigger: 'hover'});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.browse', function () {
        var file = $("#file_type");
        file.trigger('click');
    });
    $(document).ready(function () {
        $(document).on('click', '.confirmationStatus', function (e) {
            e.preventDefault(); // does not go through with the link.
            var $this = $(this);
            $("#confirmationModal").find('.modal-title').html($this.data('title'));
            $("#confirmationModal").find('.modal-body').html('<p>' + $this.data('msg') + '</p>');
            $("#confirmationModal").modal('show');
            $(".confirmation-success").attr('data-id', $this.attr('data-id'));
            $(".confirmation-success").attr('data-method', $this.attr('data-method'));
            $(".confirmation-success").attr('data-href', $this.attr('data-href'));
        });
        $(document).on('click', '.confirmation-success', function (e) {
            e.preventDefault(); // does not go through with the link.
            var $this = $(this);
            var Url = $this.attr('data-href');
            var Id = $this.attr('data-id');
            var method = $this.attr('data-method');
            $this.attr('disabled', 'disabled');
            angular.element(this).scope().submitSubscriptionAjax(Url, Id,method);
        });
                            
    });
    
</script>
 <script src="{{ URL::asset('/js/angular/front.js') }}"></script>
</body>
</html>
