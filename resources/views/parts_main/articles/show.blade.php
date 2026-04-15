@extends('layouts.'.request()->get('layout'))
@section('content')  
<div class='container leftheader article-detail'>
    <div class="thin-line"></div>
    <h1>{{$article->name}}</h1>
    <div class="description">
        {!! $article->description !!}
    </div>
</div>
@endsection

