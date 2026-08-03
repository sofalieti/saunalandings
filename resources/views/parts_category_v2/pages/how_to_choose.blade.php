@extends('layouts.'.request()->get('layout'))
@section('content')
<div class="pc2-page-hero">
    <div class="container">
        <span class="pc-section-kicker">Fitment</span>
        <h1>{!! text_block('how_to_choose_page_header') ?: text_block('how_to_choose_text_block_header') ?: ('How to choose '.request()->get('brand')->name) !!}</h1>
    </div>
</div>
<div class="container pc-page">
    <div class="row">
        <div class="col-md-6">
            <div class="main-description pc2-choose-body pc-section-body">
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
@include('parts_category_v2.partials.related-links')
@endsection
