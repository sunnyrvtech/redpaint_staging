<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta property="og:image" itemprop="image" content="{{ URL::asset('images/og-img.png') }}">
    <!-- Website font -->
    <link href="//fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <!-- Styles -->
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" >
    <!-- fonts icons -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/icofont.css') }}">  

    <!-- Main style css -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    @stack('stylesheet')
    
    @if(env('APP_ENV') == 'production')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131035815-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-131035815-1');
    </script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
	    google_ad_client: "ca-pub-6046138971260417",
	    enable_page_level_ads: true
	  });
	</script>
    @endif
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
            @if(Auth::check() && !Request::is('/') && (Request::segment(1)=='account' || Request::segment(1)=='business'))
                @if(Auth::user()->subscribed('ads_subscription') && Auth::user()->role_id != 3)
                <div class="notice notice-success">
                    <strong>Notice:</strong> Hi {{ Auth::user()->first_name }}! Your currently active plan is <strong>{{ Auth::user()->get_active_plan->stripe_plan }}</strong>.If you want to cancel,upgrade or downgrade plan ,please visit here <strong><a href="{{ route('subscription') }}">Change plan</a></strong>
                </div>
                @elseif(Auth::user()->get_active_plan && Auth::user()->subscription('ads_subscription')->cancelled() && Auth::user()->role_id != 3)
                <div class="notice notice-success">
                <strong>Notice:</strong> Hi {{ Auth::user()->first_name }}! You have cancelled your subscription,please visit here to resume your subscription <strong><a href="{{ route('subscription') }}">resume</a></strong>.
                </div>
                @elseif(Auth::user()->role_id == 3)
                <div class="notice notice-success">
                    <strong>Notice:</strong> Hi {{ Auth::user()->first_name }}! You are logged in as a normal user,if you want to upgrade your account as a business click here <strong><a href="{{ route('business.upgrade')}}">upgrade as business</a></strong>.
                </div>
                @else
                <div class="notice notice-success">
                    <strong>Notice:</strong> Hi {{ Auth::user()->first_name }}! You have not subscribed any ads plan yet,please subscribed ads plan to lists adspace.Please click here to <strong><a href="{{ route('subscription') }}">purchase</a></strong>
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
                <span>EMAIL:</span> contact@weareredpaint.com
                <br/>
                <span>PHONE: </span>(804) 269-6131
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
                <li><a href="{{ route('about-us') }}">About us</a></li>
                <li><a href="{{ route('advertise') }}">Advertise on Red Paint</a></li>
                <li><a href="{{ route('join-team') }}">Join Red Paint team</a></li>
                <li><a href="{{ route('merchandise') }}">Merchandise</a></li>
                <li><a href="{{ route('promotional-packages') }}">Promotional packages</a></li>
                <li><a href="{{ route('business-support') }}">Business support</a></li>
                <li><a href="{{ route('terms-and-agreement') }}">Terms and agreement</a></li>
            </ul>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 instagram_gallery">
            <h2>Instagram</h2>
                <ul>
<!--            <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-1.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-2.png') }}"></a></li>
                <li><a href="javascript:void(0);"><img src="{{ URL::asset('images/image-3.png') }}"></a></li>-->
                </ul>
        </div>
    </div>
<!--    <div class="modal fade" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center"><b>Share your Location with Redpaint</b></h3>
                </div>
                <form action="{{ route('user_location') }}" method="post">
                    {{ csrf_field()}}
                    <div class="modal-body">
                        <input type="text" name="user_location" id="txtPlaces" class="form-control" placeholder="Enter your address">
                        <input type="hidden" name="latitude">
                        <input type="hidden" name="longitude">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" disabled="" class="btn btn-primary">Share</button>
                    </div>
                </form>
            </div>
        </div>
    </div>-->
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
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
@stack('scripts')
<script type="text/javascript">
     var BaseUrl = "<?php echo url('/') ?>";
     setTimeout(function () {
        $("#redirect_alert").remove();
    }, 8000);
    $("body").tooltip({selector: '[data-toggle=tooltip]', trigger: 'hover'});
//    $.ajaxSetup({
//        headers: {
//            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//        }
//    });
    $(document).on('click', '.browse', function () {
        var file = $("#file_type");
        file.trigger('click');
    });
    $(document).ready(function () {
        $("#myModal").modal({ backdrop: 'static' });
        $(document).on('click', '.confirmationStatus', function (e) {
            e.preventDefault(); // does not go through with the link.
            var $this = $(this);
            $("#confirmationModal").find('.modal-title').html($this.data('title'));
            $("#confirmationModal").find('.modal-body').html('<p>' + $this.data('msg') + '</p>');
            $("#confirmationModal").modal('show');
            $(".confirmation-success").attr('data-id', $this.attr('data-id'));
            $(".confirmation-success").attr('data-method', $this.attr('data-method'));
            $(".confirmation-success").attr('data-href', $this.attr('data-href'));
            $.fancybox.close();
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
        
//        $(document).on('blur', '.zipCode', function (e) {
//           angular.element(this).scope().submitZipRegion($(this).val());
//        });
        $('input.typeahead').typeahead({
            source:  function (query, process) {
                var $url=this.$element.attr('data-url'); 
                return $.get($url, { query: query }, function (data) {
                    //console.log(data);
                    //data = $.parseJSON(data);
                    return process(data);
                });
            }
        });
        
//         $(".dropdown").hover(function() {
//                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
//                $(this).toggleClass('open');
//                $('b', this).toggleClass("caret caret-up");                
//            },function() {
//                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
//                $(this).toggleClass('open');
//                $('b', this).toggleClass("caret caret-up");                
//            });
var sdsd = "{{ Session::get('latitude') }}";
alert(sdsd);
        @if(!Session::has('latitude') && !Session::has('longitude'))    
            getGeoLocation();
            function getGeoLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition,error);
                } else { 
                    alert("Geolocation is not supported by this browser.");
                }
            }

            function showPosition(position) {
                console.log(position.coords.latitude);
                console.log(position.coords.longitude);
                
              angular.element(document.body).scope().submitUserLocation("{{ route('user_location') }}",37.660360,-77.383070);
            }
            function error(msg) {
//                alert('Please follow this link to enable geolocation in your browser "https://support.mozilla.org/en-US/questions/1104359" ');
            }
        @endif
        
        var token = "{{ env('INSTA_TOKEN') }}",
        userid = {{ env('INSTA_USER_ID') }},
        num_photos = 12; 
 
        $.ajax({
                url: 'https://api.instagram.com/v1/users/' + userid + '/media/recent', // or /users/self/media/recent for Sandbox
                dataType: 'jsonp',
                type: 'GET',
                data: {access_token: token, count: num_photos},
                success: function(data){
                        for( x in data.data ){
                                $('.instagram_gallery ul').append('<li><a target="_blank" href="'+data.data[x].link+'"><img src="'+data.data[x].images.low_resolution.url+'"></a></li>'); // data.data[x].images.low_resolution.url - URL of image, 306х306
                                // data.data[x].images.thumbnail.url - URL of image 150х150
                                // data.data[x].images.standard_resolution.url - URL of image 612х612
                                // data.data[x].link - Instagram post URL 
                        }
                },
                error: function(data){
                        console.log(data); // send the error notifications to console
                }
        });
        
    });
    
</script>
 <script src="{{ URL::asset('/js/angular/front.js') }}"></script>
</body>
</html>
