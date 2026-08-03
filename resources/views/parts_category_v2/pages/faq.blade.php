@php
    $brand = request()->get('brand');
    $faqItems = $brand->faq_items()->where('active', true)->orderBy('position')->get()
        ->reject(function ($item) {
            return is_content_placeholder($item->question) || is_content_placeholder($item->answer);
        });
    $faqText = text_block('faq_text_block');
    $pageTitle = text_block('faq_text_block_header') ?: (ucwords(strtolower(trim($brand->name))).' FAQ');
@endphp
@extends('layouts.'.request()->get('layout'))
@section('content')

<header class="au-page-hero">
    <div class="au-shell">
        <nav class="au-crumbs">
            <a href="/">Home</a>
            <span>/</span>
            <span>FAQ</span>
        </nav>
        <span class="au-label au-head__note">Questions</span>
        <h1 class="au-h1">{!! $pageTitle !!}</h1>
        @if($faqText)
            <div class="au-lead au-hero__lead">{!! $faqText !!}</div>
        @endif
    </div>
</header>

<section class="au-section au-section--tight">
    <div class="au-shell">
        @include('parts_category_v2.partials.faq-list', ['faqItems' => $faqItems])
    </div>
</section>

@include('parts_category_v2.partials.quote', [
    'formId' => 2,
    'label' => 'Still stuck',
    'title' => 'Ask about your own cabin',
])
@include('parts_category_v2.partials.related-links')
@include('parts_category_v2.partials.cta')

@endsection
