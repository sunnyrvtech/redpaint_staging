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
<body>
 <header class="header">
<div class="top_header">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-8">
                <div class="logo"><a href="#"><img src="{{ URL::asset('images/logo.png') }}"></a></div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <button class="menu_mobile"><i class="fa fa-bars" aria-hidden="true"></i></button>
                <div class="header_menu">
                    <ul>
                        <li><a href="#">Write a Review</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Talk</a></li>
                        <li><a href="#">Login</a></li>
                        <li class="Register"><a href="#">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="slider_content">
    <h1>Fresh, fast, Tasty</h1>
</div>

<div class="search_form">
    <div class="container">
        <div class="row">
            <div class="form_main">
                <div class="Logo_f"><img src="{{ URL::asset('images/black-logo.png') }}"></div>
                <ul class="search_Category">
                    <li><a href="#"><i class="icofont icofont-fork-and-knife"></i> Restaurants</a></li>
                    <li><a href="#"><i class="fa fa-glass" aria-hidden="true"></i> Nightlife</a></li>
                    <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i> Home Services</a></li>
                    <li><a href="#"><i class="icofont icofont-fast-delivery"></i> Delivery</a></li>
                </ul>
                <form class="seacrg_city">
                    <div class="col-md-5 col-sm-5 col-xs-12 custom_column">
                        <div class="input-group">
                            <div class="input-group-addon">Find</div>
                            <input type="text" class="form-control" placeholder="dinner, Max’s">
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12 custom_column">
                        <div class="input-group">
                            <div class="input-group-addon">Near</div>
                            <input type="text" class="form-control" placeholder="address, neighborhood, city, state or zip">
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12 custom_column">
                         <button type="submit" class="btn btn-primary search_city_btn"><i class="icofont icofont-search-alt-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- slider -->
<div id="maximage">
      <img src="{{ URL::asset('images/Header-background.jpg') }}" alt="" width="1400" height="1050" />
      <img src="{{ URL::asset('images/slider-2.png') }}" alt="Coalesse" width="1400" height="1050" />
      <img src="{{ URL::asset('images/slider-3.png') }}" alt="Coalesse" width="1400" height="1050" />
</div>

</header><!-- end header -->

<section>
    @yield('content')
</section><!-- end section -->

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
                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 info-Link">
            <h2>info Link</h2>
            <ul>
                <li><a href="#">About Yelp</a></li>
                <li><a href="#">Order Food on Eat24</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Press</a></li>
                <li><a href="#">Investor Relations</a></li>
                <li><a href="#">Content Guidelines</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Ad Choices</a></li>
            </ul>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 instagram_gallery">
            <h2>instagram</h2>
                <ul>
                <li><a href="#"><img src="{{ URL::asset('images/image-1.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-2.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-3.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-1.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-2.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-3.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-1.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-2.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-3.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-1.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-2.png') }}"></a></li>
                <li><a href="#"><img src="{{ URL::asset('images/image-3.png') }}"></a></li>
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
<!-- Latest compiled and minified JavaScript -->
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
@stack('scripts')
<script type="text/javascript">
</script>
</body>
</html>
