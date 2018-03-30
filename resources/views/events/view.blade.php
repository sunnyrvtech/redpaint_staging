@extends('layouts.app')
@push('stylesheet')
<link href="{{ URL::asset('/slick/slick.css') }}" rel="stylesheet">
<link href="{{ URL::asset('/slick/slick-theme.css') }}" rel="stylesheet">
@endpush
@section('content')
<a href="{{ route('photo.show',$events->event_slug) }}" class="add-photo-button">
                                        <i class="fa fa-camera" aria-hidden="true"></i>Add Photo     
                                    </a>
@endpush




