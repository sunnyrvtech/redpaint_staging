@extends('layouts.app')
@section('content')
<div class="static_page">
{!! $content->content or '' !!}
</div>
@endsection


