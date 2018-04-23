@extends('layouts.app')
@section('content')
<style type="text/css">
    .error-content p{ margin: 18px 0px 45px 0px; }
    .error-content p{ font-family: "Century Gothic";font-size:2em;color:#666;text-align:center; }
    .error-content p span{ color:#e54040; }
    .error-content{ text-align:center;padding:115px 0px 0px 0px; }
    .error-content a{ color:#fff;font-family: "Century Gothic";background: #666666; /* Old browsers */background: -moz-linear-gradient(top,  #666666 0%, #666666 100%); /* FF3.6+ */background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#666666), color-stop(100%,#666666)); /* Chrome,Safari4+ */background: -webkit-linear-gradient(top,  #666666 0%,#666666 100%); /* Chrome10+,Safari5.1+ */background: -o-linear-gradient(top,  #666666 0%,#666666 100%); /* Opera 11.10+ */background: -ms-linear-gradient(top,  #666666 0%,#666666 100%); /* IE10+ */background: linear-gradient(to bottom,  #666666 0%,#666666 100%); /* W3C */filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#666666', endColorstr='#666666',GradientType=0 ); /* IE6-9 */padding: 15px 20px;border-radius: 1em; }
    .error-content a:hover{ color:#e54040; }
    .error-content .error-btn { margin-bottom: 40px; }
    /*------responive-design--------*/
    @media screen and (max-width: 1366px) {
        .error-content { padding: 58px 0px 0px 0px; }
    }
    @media screen and (max-width:1280px)  {
        .error-content { padding: 58px 0px 0px 0px; }
    }
    @media screen and (max-width:1024px)  {
        .error-content { padding: 58px 0px 0px 0px; }
        .error-content p { font-size: 1.5em; }
        .copy-right p{ font-size:0.9em; }
    }
    @media screen and (max-width:640px) {
        .error-content { padding: 58px 0px 0px 0px; }
        .error-content p { font-size: 1.3em; }
        .copy-right p{ font-size:0.9em; }
    }
    @media screen and (max-width:460px) {
        .error-content { padding:20px 0px 0px 0px;margin:0px 12px;}
        .error-content p {font-size:0.9em;}
        .copy-right p{font-size:0.8em;}
        .error-img { width: 100%;}
    }
    @media screen and (max-width:320px) {
        .error-content {padding:30px 0px 0px 0px;margin:0px 12px;}
        .error-content a {padding:10px 15px;font-size:0.8em;}
        .error-content p {margin: 18px 0px 22px 0px;}
    }
</style>
<!--start-error-content------>
<div class="error-content">
    <img class="error-img" src="{{ URL::asset('/images/error.png') }}" title="error" />
    <p><span><label>O</label>hh.....</span>You Requested the page that is no longer There.</p>
    <div class='error-btn'><a href="{{ URL('/') }}">Back To Home</a></div>
</div>
<!--End-Cotent------>
@endsection

