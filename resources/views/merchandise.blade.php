@extends('layouts.app')
@section('content')

<div class="container">
        {!! $content->content or '' !!}
</div>
@endsection


