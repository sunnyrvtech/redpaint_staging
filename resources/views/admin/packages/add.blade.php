@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Subscription/Package
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('packages.store')}}">
                {{ csrf_field()}}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : ''}}">
                            <label class="col-sm-3 col-md-3 control-label" for="name">Name:</label>
                            <div class="col-sm-9 col-md-9">
                                <input type="text" required="" name="name" class="form-control" placeholder="Name">
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('price') ? ' has-error' : ''}}">
                            <label class="col-sm-3 col-md-3 control-label" for="price">Price:</label>
                            <div class="col-sm-9 col-md-9">
                                <input required="" type="text"  name="price" class="form-control" placeholder="Price">
                                @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('status') ? ' has-error' : ''}}">
                            <label class="col-sm-3 col-md-3 control-label" for="email">Duration:</label>
                            <div class="col-sm-9 col-md-9">
                                {{ Form::select('duration', $interval, null, ['class' => 'form-control']) }}
                                @if ($errors->has('status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status')}}</strong>
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