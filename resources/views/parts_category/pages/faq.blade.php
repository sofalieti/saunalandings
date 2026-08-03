@extends('layouts.'.request()->get('layout'))
@section('content')
@php
    $faqItems = request()->get('brand')->faq_items()->where('active', true)->orderBy('position')->get();
@endphp
<div class="container pc-page">
    <h1>{!! text_block('faq_text_block_header') ?: (request()->get('brand')->name.' FAQ') !!}</h1>
    <div class="pc-section-body">{!! text_block('faq_text_block') !!}</div>
    @include('parts_category.partials.faq-list', ['faqItems' => $faqItems])
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="right-form">
                @include('forms.form', ['form_id' => 2])
            </div>
        </div>
    </div>
</div>
@include('parts_category.partials.related-links')
@endsection
