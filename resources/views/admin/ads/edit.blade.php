@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Update Category
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <form role="form" class="form-horizontal" action="{{ route('ads_list.update',$ads->id)}}" method="post" enctype="multipart/form-data">
            <input name="_method" value="PUT" type="hidden">
            {{ csrf_field()}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="event_name" class="col-sm-3 col-md-3 control-label">Ads Name</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" class="form-control" name="name" value="{{ $ads->name }}" placeholder="Ads Name">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('link') ? ' has-error' : '' }}">
                        <label for="category_id" class="col-sm-3 col-md-3 control-label">Website Link</label>
                        <div class="col-sm-9 col-md-9">
                            <input type="text" required="" class="form-control" name="link" value="{{ $ads->link }}" placeholder="Website Link">
                            @if ($errors->has('link'))
                            <span class="help-block">
                                <strong>{{ $errors->first('link') }}</strong>
                            </span>
                            @endif
                        </div>       
                    </div>       
                    <div class="form-group {{ $errors->has('banner') ? ' has-error' : '' }}">
                        <label for="banner" class="col-sm-3 col-md-3 control-label">Banner</label>
                        <div class="col-sm-9 col-md-9">
                            <div class="pro-browse">
                                <button class="btn btn-success browse" type="button">Browse Files</button>
                            </div>
                            <input style="display: none;" id="file_type" name="banner" class="file" type="file">
                            @if ($errors->has('banner'))
                            <span class="help-block">
                                <strong>{{ $errors->first('banner') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <img width="100%" id="blah" src="{{ URL::asset('/ads_images').'/'.$ads->banner }}">
                    </div>
                       
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 text-center">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Update</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection