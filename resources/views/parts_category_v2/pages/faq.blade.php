@extends('layouts.'.request()->get('layout'))
@section('content')
@php
    $faqItems = request()->get('brand')->faq_items()->where('active', true)->orderBy('position')->get()
        ->reject(function ($item) {
            return is_content_placeholder($item->question) || is_content_placeholder($item->answer);
        });
    $faqText = text_block('faq_text_block');
@endphp
<div class="pc2-page-hero">
    <div class="container">
        <span class="pc-section-kicker">FAQ</span>
        <h1>{!! text_block('faq_text_block_header') ?: (ucwords(strtolower(trim(request()->get('brand')->name))).' FAQ') !!}</h1>
        @if($faqText)
            <div class="pc-section-body">{!! $faqText !!}</div>
        @endif
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
