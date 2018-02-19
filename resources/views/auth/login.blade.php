@extends('layouts.app')
@section('content')
<section class="login-wrp">
    <div class="login">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="outer-form">
                    <div class="col-wrp">
                        <div class="col-6 side-img text-center">
                            <img src="{{ URL::asset('images/logo.png') }}">
                        </div>
                        <div class="col-6">
                            <div class="col-sign">
                                <div class="card">
                                    <div class="signup-wrapper">
                                        <div class="header">
                                            <h2>Log In To Redpaint</h2>
                                            <p class="subheading">New To Redpaint? <a class="signup-link" href="{{ route('register')}}">Sign up</a></p>
                                            <p class="legal-copy">
                                                By logging in, you agree to Redpaint <a class="legal-link" href="javascript:void(0);">Terms of Service</a> and <a class="legal-link" href="javascript:void(0);">Privacy Policy</a>.
                                            </p>
                                        </div>
                                        <form name="loginForm" role="form" action="javascript:void(0);" ng-submit="submitLogin(loginForm.$valid)" novalidate>
                                            {{ csrf_field()}}
                                            <div class="input-container">
                                                <div class="form-group" ng-class="{ 'has-error' : loginForm.email.$invalid && !loginForm.email.$pristine }">
                                                    <input type="email" name="email" required="" ng-model="login.email">
                                                    <label for="email">yourmail@example.com</label>
                                                    <span ng-show="loginForm.email.$invalid && !loginForm.email.$pristine" class="help-block">
                                                        <strong>Please enter valid email.</strong>
                                                    </span> 
                                                    <div class="bar"></div>
                                                </div>
                                            </div>
                                            <div class="input-container">
                                                <div class="form-group" ng-class="{ 'has-error' : loginForm.password.$invalid && !loginForm.password.$pristine }">
                                                    <input type="password" name="password" required="" ng-model="login.password">
                                                    <label for="Password">Password</label>
                                                    <span ng-show="loginForm.password.$invalid && !loginForm.password.$pristine" class="help-block">
                                                        <strong>Please enter password.</strong>
                                                    </span>
                                                    <div class="bar"></div>
                                                </div>
                                            </div>
                                            <div class="forgot-password">
                                                <a href="{{ route('password.email')}}" class="forgot-link">Forgot password?</a>
                                            </div>
                                            @if(request()->path() == 'login')
                                            <input type="hidden" name="type" ng-model="login.type" ng-init="login.type='normal'">
                                            @else
                                            <input type="hidden" name="type" ng-model="login.type" ng-init="login.type='business'">
                                            @endif
                                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                                        </form>
                                        <fieldset class="hr-line">
                                            <legend align="center">OR</legend>
                                        </fieldset>
                                        <div class="social-buttons">
                                            <a href="{{ url('/facebook/redirect')}}" class="btn btn-social btn-facebook">
                                                <i class="fa fa-facebook"></i>Facebook
                                            </a>
                                            <a href="{{ url('/google/redirect')}}" class="btn btn-social btn-google-plus">
                                                <i class="fa fa-google-plus"></i> Google 
                                            </a>
                                        </div>
                                        <div class="sub-text-box">
                                            <small class="subtle-text">New to Redpaint? <a class="signup-link" href="{{ route('register')}}">Sign up</a></small>
                                        </div>
                                        <div class="bsn-btn">
                                            @if(request()->path() == 'login')
                                            <a href="{{ route('business.login')}}" class="btn btn-lg btn-default btn-block">Continue as a business</a>
                                            @else
                                            <a href="{{ route('login')}}" class="btn btn-lg btn-default btn-block">Continue as a normal user</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
