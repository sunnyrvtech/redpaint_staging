@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New User
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('users.store')}}">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('first_name') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="first_name">First Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="first_name" class="form-control" placeholder="First Name">
                            @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('last_name') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="last_name">Last Name:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="text"  name="last_name" class="form-control" placeholder="Last Name">
                            @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="email">Email:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="email" name="email"  class="form-control" placeholder="Email Address">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="email">Password:</label>
                        <div class="col-sm-9 col-md-9">
                            <input required="" type="password" name="password"  class="form-control" placeholder="Password">
                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('role_id') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="role_id">Role:</label>
                        <div class="col-sm-9 col-md-9">
                            <select required="" class="form-control" name="role_id">
                                <option value="2">Business User</option>
                                <option value="3">Normal User</option>
                            </select>
                            @if ($errors->has('role_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('role_id')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection