@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Update Sub Category
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(array('route' => ['subcategories.update',$sub_categories->id],'method'=>'PUT', 'class' => 'form-horizontal','enctype'=>'multipart/form-data')) }}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                        <label class="col-sm-3 col-md-3 control-label" for="category_id">Category Name:</label>
                        <div class="col-sm-9 col-md-9">  
                            {{ Form::select('category_id', $categories,$sub_categories->category_id,['class' => 'form-control']) }}
                            @if ($errors->has('category_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-sm-3 col-md-3 control-label" for="name">Sub Category Name:</label>
                        <div class="col-sm-9 col-md-9">  
                            <input class="form-control" name="name" value="{{ $sub_categories->name }}">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <!--                <div class="form-group {{ $errors->has('category_picture') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 col-md-3 control-label" for="category_picture">Category Image:</label>
                                        <div class="col-sm-9 col-md-9">  
                                            <input type="file" name="category_picture" class="preview-image">
                                            @if ($errors->has('category_picture'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('category_picture') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group text-center" id="previewImage">
                                            <span id="image_prev">
                                                @if(!empty($sub_categories->category_image))
                                                <img width="200px" src="{{ URL::asset('/category').'/'.$sub_categories->category_image }}">
                                                @endif
                                            </span>
                                        </div>
                                    </div>-->

                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 text-center">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Update</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection