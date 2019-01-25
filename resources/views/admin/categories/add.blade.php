@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Add New Category
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <form role="form" class="form-horizontal" action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field()}}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-md-3 control-label" for="name">Category Name:</label>
                            <div class="col-sm-9 col-md-9">
                                <input class="form-control" required="" name="name" placeholder="Category Name">
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('class_name') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-md-3 control-label" for="class_name">Icon Class Name:</label>
                            <div class="col-sm-9 col-md-9">
                                <input type="text" name="class_name" class="form-control" placeholder="Class Name">
                                @if ($errors->has('class_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('class_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 text-center">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection