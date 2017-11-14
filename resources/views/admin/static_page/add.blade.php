@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Page
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('static_page.store')}}">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group {{ $errors->has('title') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="title">Title:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" name="title" class="form-control" placeholder="Title">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('content') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="content">Content:</label>
                        <div class="col-sm-9 col-md-9">
                            <textarea class="form-control" name="content" cols="50" rows="10"></textarea>
                            @if ($errors->has('content'))
                            <span class="help-block">
                                <strong>{{ $errors->first('content')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('custom_field1') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="custom_field1">Custom Field1:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" name="custom_field1"  class="form-control" placeholder="Custom Field1">
                            @if ($errors->has('custom_field1'))
                            <span class="help-block">
                                <strong>{{ $errors->first('custom_field1')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('custom_field2') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="custom_field2">Custom Field2:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" name="custom_field2"  class="form-control" placeholder="Custom Field2">
                            @if ($errors->has('custom_field2'))
                            <span class="help-block">
                                <strong>{{ $errors->first('custom_field2')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('custom_field3') ? ' has-error' : ''}}">
                        <label class="col-sm-3 col-md-3 control-label" for="custom_field3">Custom Field3:</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" name="custom_field3"  class="form-control" placeholder="Custom Field3">
                            @if ($errors->has('custom_field3'))
                            <span class="help-block">
                                <strong>{{ $errors->first('custom_field3')}}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 pull-right">
                    <button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection