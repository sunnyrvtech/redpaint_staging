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
                                            <h2>Sign Up For Redpaint</h2>
                                            <p class="subheading">Connect with great local businesses</p>
                                            <p class="legal-copy">
                                                By signing up, you agree to Redpaint <a class="legal-link" href="#">Terms of Service</a> and <a class="legal-link" href="#">Privacy Policy</a>.
                                            </p>
                                        </div>
                                        <div class="social-buttons">
                                            <a href="{{ url('/facebook/redirect')}}" class="btn btn-social btn-facebook">
                                                <i class="fa fa-facebook"></i>Facebook
                                            </a>
                                            <a href="{{ url('/google/redirect')}}" class="btn btn-social btn-google-plus">
                                                <i class="fa fa-google-plus"></i> Google 
                                            </a>
                                        </div>
                                        <fieldset class="hr-line">
                                            <legend align="center">OR</legend>
                                        </fieldset>
                                        <form name="registerForm" role="form" role="form" method="POST" action="javascript:void(0);" ng-submit="submitRegister(registerForm.$valid)" novalidate>
                                            <input type='text' style="display:none;">
                                            <input type='password' style="display:none;">
                                            {{ csrf_field()}}
                                            <div class="input-container">
                                                <div class="row1">
                                                    <div class="col-sm-6">
                                                        <div class="form-group" ng-class="{ 'has-error' : registerForm.first_name.$invalid && !registerForm.first_name.$pristine }">
                                                            <input type="text" name="first_name" required="" ng-model="register.first_name">
                                                            <label for="firstname">First Name</label>
                                                            <span ng-show="registerForm.first_name.$invalid && !registerForm.first_name.$pristine" class="help-block">
                                                                <strong>Please enter first name.</strong>
                                                            </span> 
                                                            <div class="bar"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group" ng-class="{ 'has-error' : registerForm.last_name.$invalid && !registerForm.last_name.$pristine }">
                                                            <input type="text" name="last_name" required="" ng-model="register.last_name">
                                                            <label for="lastname">Last Name</label>
                                                            <span ng-show="registerForm.last_name.$invalid && !registerForm.last_name.$pristine" class="help-block">
                                                                <strong>Please enter last name.</strong>
                                                            </span> 
                                                            <div class="bar"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-container">
                                                <div class="form-group" ng-class="{ 'has-error' : registerForm.email.$invalid && !registerForm.email.$pristine }">
                                                    <input type="email" name="email" required="" ng-model="register.email">
                                                    <label for="email">Email</label>
                                                    <span ng-show="registerForm.email.$invalid && !registerForm.email.$pristine" class="help-block">
                                                        <strong>Please enter valid email.</strong>
                                                    </span> 
                                                    <div class="bar"></div>
                                                </div>
                                            </div>
                                            <div class="input-container">
                                                <div class="form-group" ng-class="{ 'has-error' : registerForm.password.$invalid && !registerForm.password.$pristine }">
                                                    <input type="password" name="password" required="" ng-model="register.password">
                                                    <label for="Password">Password</label>
                                                    <span ng-show="registerForm.password.$invalid && !registerForm.password.$pristine" class="help-block">
                                                        <strong>Please enter password.</strong>
                                                    </span>
                                                    <div class="bar"></div>
                                                </div>
                                            </div>
                                            <div class="input-container">
                                                <div class="form-group" ng-class="{ 'has-error' : registerForm.password_confirmation.$invalid && !registerForm.password_confirmation.$pristine || register.password !== register.password_confirmation }">
                                                    <input type="password" name="password_confirmation" required="" ng-model="register.password_confirmation">
                                                    <label for="Password">Confirm Password</label>
                                                    <span ng-show="register.password !== register.password_confirmation" class="help-block">
                                                        <strong>Password and confirm password should be same.</strong>
                                                    </span> 
                                                    <div class="bar"></div>
                                                </div>
                                            </div>
                                            @if(request()->path() == 'register')
                                            <input type="hidden" name="type" ng-model="register.type" ng-init="register.type='normal'">
                                            @else
                                            <input type="hidden" name="type" ng-model="register.type" ng-init="register.type='business'">
                                            @endif
                                            <div class="sub-text-box">
                                                <small class="subtle-text">Already on Redpaint ? <a class="signup-link" href="{{ route('login')}}">Log in</a></small>
                                            </div>
                                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Sign Up">
                                        </form>
                                        @if (!Session::has('claim_business_slug'))
                                        <fieldset class="hr-line">
                                            <legend align="center">OR</legend>
                                        </fieldset>
                                        <div class="social-buttons">
                                            @if(request()->path() == 'register')
                                            <a href="{{ route('business.register')}}" class="btn btn-lg btn-default btn-block">Continue as a business</a>
                                            @else
                                            <a href="{{ route('register')}}" class="btn btn-lg btn-default btn-block">Continue as a normal user</a>
                                            @endif
                                        </div>
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
</section>
@endsection
