@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <h2>Reset Password<small></small></h2>
        <hr class="colorgraph">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    <form class="form-horizontal" name="resetPasswordForm" role="form" action="javascript:void(0);" ng-submit="submitResetPasswordLink(resetPasswordForm.$valid)" novalidate>
                        {{ csrf_field()}}
                        <div class="form-group" ng-class="{ 'has-error' : resetPasswordForm.email.$invalid && !resetPasswordForm.email.$pristine }">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" name="email" required="" ng-model="reset.email" class="form-control" placeholder="Email Address" tabindex="4">
                                <span ng-show="resetPasswordForm.email.$invalid && !resetPasswordForm.email.$pristine" class="help-block">
                                    <strong>Please enter valid email.</strong>
                                </span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
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
