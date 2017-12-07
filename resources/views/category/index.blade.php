@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="row">
        <div class="col-sm-12">
            <div class="list_subcat">
                <div class="row">
                    <h3 class="onea-page-header">{{ $sub_category[0]->getCategory->name }}:-</h3>
                </div>
                <div class="row">
                    @foreach($sub_category as $value)
                    <div class="cols col-xs-6 col-sm-3 col-md-3">
                        <span aria-hidden="true" class="glyphicon glyphicon-menu-right"></span>
                        <a href="{{ route('subcategory.search',$value->id) }}">{{ $value->name }}</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
