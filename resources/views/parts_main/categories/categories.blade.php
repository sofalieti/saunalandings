@extends('layouts.'.request()->get('layout'))
@section('content')
<div class='container'>
    <h1>Categories</h1>
    @foreach($categories as $category)
    <a href="{{route('category', $category->slug)}}">{{$category->name}}</a><br/>
    @endforeach
</div>
@endsection