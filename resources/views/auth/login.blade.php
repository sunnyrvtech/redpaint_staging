@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" name="loginForm" role="form" action="javascript:void(0);" ng-submit="submitLogin(loginForm.$valid)" novalidate>
                        {{ csrf_field()}}
                        <div class="form-group" ng-class="{ 'has-error' : loginForm.email.$invalid && !loginForm.email.$pristine }">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" name="email" required="" ng-model="login.email" class="form-control input-lg" placeholder="Email Address" tabindex="3">
                                <span ng-show="loginForm.email.$invalid && !loginForm.email.$pristine" class="help-block">
                                    <strong>Please enter valid email.</strong>
                                </span> 
                            </div>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : loginForm.password.$invalid && !loginForm.password.$pristine }">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" name="password" required="" ng-model="login.password"  class="form-control input-lg" placeholder="Password" tabindex="4">
                                <span ng-show="loginForm.password.$invalid && !loginForm.password.$pristine" class="help-block">
                                    <strong>Please enter password.</strong>
                                </span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                                <a class="btn btn-link" ng-click="forgotPassword()" href="javascript:void(0);">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
