@extends('layouts.'.request()->get('layout'))
@section('content')
@php
    $faqItems = request()->get('brand')->faq_items()->where('active', true)->orderBy('position')->get();
@endphp
<div class="pc2-page-hero">
    <div class="container">
        <span class="pc-section-kicker">FAQ</span>
        <h1>{!! text_block('faq_text_block_header') ?: (request()->get('brand')->name.' FAQ') !!}</h1>
        <div class="pc-section-body">{!! text_block('faq_text_block') !!}</div>
    </div>
</div>
<div class="container pc-page">
    @include('parts_category_v2.partials.faq-list', ['faqItems' => $faqItems])
    <div class="row pc2-page-form">
        <div class="col-md-6">
            <div class="right-form">
                @include('forms.form', ['form_id' => 2])
            </div>
        </div>
    </div>
</div>
@include('parts_category_v2.partials.related-links')
@endsection
