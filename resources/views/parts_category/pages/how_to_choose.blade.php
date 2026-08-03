@extends('layouts.'.request()->get('layout'))
@section('content')
<div class="container pc-page">
    <h1>{!! text_block('how_to_choose_page_header') ?: text_block('how_to_choose_text_block_header') ?: ('How to choose '.request()->get('brand')->name) !!}</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="main-description">
                {!! text_block('how_to_choose_text_block') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="right-form">
                @include('forms.form', ['form_id' => 2])
            </div>
        </div>
    </div>
</div>
@include('parts_category.partials.related-links')
@endsection
