@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Password Change
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="post" action="{{ route('users-password',$id)}}">
                {{ csrf_field()}}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : ''}}">
                            <label class="col-sm-3 col-md-3 control-label" for="password">Password:</label>
                            <div class="col-sm-9 col-md-9">
                                <input type="password" name="password"  class="form-control" placeholder="Password">
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : ''}}">
                            <label class="col-sm-3 col-md-3 control-label" for="password">Password confirmation:</label>
                            <div class="col-sm-9 col-md-9">
                                <input type="password" name="password_confirmation"  class="form-control" placeholder="Password Confirmation">
                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation')}}</strong>
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
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection