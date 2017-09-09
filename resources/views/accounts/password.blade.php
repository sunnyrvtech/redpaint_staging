@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="row">
        <div class="col-sm-3">
            @include('accounts.sidebar')
        </div>
        <div class="col-sm-9">
            <div class="content-header">
                <div class="row">
                    <div class="col-md-8">
                        <div class="titled-nav-header_content">
                            <h3>Change Password</h3>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right">
                        <!--<a href="" class="btn btn-primary" type="button">Create Event</a>-->
                    </div>
                </div>
            </div>
            <div class="content-middle">
                <form class="form-horizontal" name="passwordForm" role="form" method="POST" action="javascript:void(0);" ng-submit="submitChangePassword(passwordForm.$valid)" novalidate>
                    <input type='text' style="display:none;">
                    <input type='password' style="display:none;">
                    {{ csrf_field()}}
                    <div class="form-group" ng-class="{ 'has-error' : passwordForm.current_password.$invalid && !passwordForm.current_password.$pristine }">
                        <label class="col-form-label" for="currentPassword">Current Password:</label>
                        <input type="password" name="current_password" required="" ng-model="password.current_password" class="form-control" placeholder="Current Password">
                        <span ng-show="passwordForm.current_password.$invalid && !passwordForm.current_password.$pristine" class="help-block">
                            <strong>Please enter current password.</strong>
                        </span> 
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : passwordForm.password.$invalid && !passwordForm.password.$pristine }">
                        <label class="col-form-label" for="password">New Password:</label>
                        <input type="password" name="password" required="" ng-model="password.password" class="form-control" placeholder="New Password">
                        <span ng-show="passwordForm.password.$invalid && !passwordForm.password.$pristine" class="help-block">
                            <strong>Please enter new password.</strong>
                        </span> 
                    </div>
                    <div class="form-group" ng-class="{ 'has-error' : passwordForm.confirm_password.$invalid && !passwordForm.confirm_password.$pristine || password.password !== password.confirm_password }">
                        <label class="col-form-label" for="confirm_password">Confirm Password:</label>
                        <input type="password" name="confirm_password" required="" ng-model="password.confirm_password" class="form-control" placeholder="Confirm Password">
                        <span ng-show="password.password !== password.confirm_password" class="help-block">
                            <strong>Password and confirm password should be same.</strong>
                        </span> 
                    </div>
                    <button type="submit" ng-disabled="password.password !== password.confirm_password" class="btn btn-primary">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
