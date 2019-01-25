@extends('admin/layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row form-group">
        <div class="col-lg-12">
            <h1 class="page-header">
                Update Review
            </h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <form role="form" class="form-horizontal" action="{{ route('reviews.update',$reviews->id)}}" method="post">
                <input name="_method" value="PUT" type="hidden">
                {{ csrf_field()}}
                <div class="row">
                    <div class="col-lg-8">
                        <!--                    <div class="form-group {{ $errors->has('rate') ? ' has-error' : '' }}">
                                                <label for="rate" class="col-sm-3 col-md-3 control-label">Rating</label>
                                                <div class="col-sm-9 col-md-9">
                                                    <select class="form-control" name="rate">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                                        <option @if($reviews->rate == $i) selected @endif value="{{$i}}">{{$i}}</option>
                        <?php } ?>
                                                    </select>
                                                    @if ($errors->has('rate'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('rate') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>-->
                        <div class="form-group {{ $errors->has('comment') ? ' has-error' : '' }}">
                            <label for="comment" class="col-sm-3 col-md-3 control-label">Comment</label>
                            <div class="col-sm-9 col-md-9">
                                <textarea class="form-control" required="" rows="10" maxlength="1000" name="comment">{{ $reviews->comment }}</textarea> 
                                @if ($errors->has('comment'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('comment') }}</strong>
                                </span>
                                @endif
                            </div>       
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
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection