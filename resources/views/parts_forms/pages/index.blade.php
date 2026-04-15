@extends('layouts.'.request()->get('layout'))

@section('content')
<div class="container">
    <div class="header text-center">{!! text_block('header_text') !!}</div>
    @include('forms.form', ['form_id' => 6])
    <div class="footer text-center">{!! text_block('footer_text') !!}</div>
    <div class="warning-text text-center">The site is under reconstruction. Write us and we'll be sure to get back to you!</div>
</div>
@endsection
