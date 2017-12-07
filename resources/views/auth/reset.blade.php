@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h2>Reset Password<small></small></h2>
        <hr class="colorgraph">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" name="resetPasswordForm" role="form" action="javascript:void(0);" ng-submit="submitResetPassword(resetPasswordForm.$valid)" novalidate>
                        <input type='text' style="display:none;">
                        <input type='password' style="display:none;">
                        {{ csrf_field()}}
                        <input type="hidden" name="token" ng-model="reset.token" ng-init="reset.token='{{ $token }}'">
                        <div class="form-group" ng-class="{ 'has-error' : resetPasswordForm.email.$invalid && !resetPasswordForm.email.$pristine }">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" ng-model="reset.email" required autofocus>
                                <span ng-show="resetPasswordForm.email.$invalid && !resetPasswordForm.email.$pristine" class="help-block">
                                    <strong>Please enter valid email.</strong>
                                </span> 
                            </div>
                        </div>

                        <div class="form-group" ng-class="{ 'has-error' : resetPasswordForm.password.$invalid && !resetPasswordForm.password.$pristine }">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" ng-model="reset.password" required>
                                <span ng-show="resetPasswordForm.password.$invalid && !resetPasswordForm.password.$pristine" class="help-block">
                                    <strong>Please enter new password.</strong>
                                </span> 
                            </div>
                        </div>

                        <div class="form-group" ng-class="{ 'has-error' : resetPasswordForm.password_confirmation.$invalid && !resetPasswordForm.password_confirmation.$pristine || reset.password !== reset.password_confirmation }">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" ng-model="reset.password_confirmation" required>
                                <span ng-show="reset.password !== reset.password_confirmation" class="help-block">
                                    <strong>Password and confirm password should be same.</strong>
                                </span> 
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" ng-disabled="reset.password !== reset.password_confirmation" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
