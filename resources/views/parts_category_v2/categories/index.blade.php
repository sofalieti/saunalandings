@php
    $brand = request()->get('brand');
    $state = request()->get('state');
@endphp
@extends('layouts.'.request()->get('layout'))
@section('content')

<header class="au-page-hero">
    <div class="au-shell">
        <nav class="au-crumbs">
            <a href="/">Home</a>
            <span>/</span>
            <span>{{ $category->name }}</span>
        </nav>
        <span class="au-label au-head__note">Catalog</span>
        <h1 class="au-h1">{{ rt("!brand!") }} {{ $category->name }}</h1>
        @if($category->text)
            <div class="au-prose au-hero__lead">{!! $category->text !!}</div>
        @endif
    </div>
</header>

@include('parts_category_v2.partials.goods-grid', [
    'category' => $category,
    'products' => $products,
    'heading' => false,
])

<section class="au-section">
    <div class="au-shell">
        <div class="au-split">
            <div class="au-split__aside">
                <span class="au-label">Shipping</span>
            </div>
            <div class="au-grid au-grid--3">
                <div>
                    <p class="au-label">Delivery to {{ $state->name }}</p>
                    <p class="au-muted">Around 5 days for in-stock parts, tracked door to door.</p>
                </div>
                <div>
                    <p class="au-label">Free over $300</p>
                    <p class="au-muted">Flat-rate shipping below that, across the USA and Canada.</p>
                </div>
                <div>
                    <p class="au-label">Fitment first</p>
                    <p class="au-muted">Nothing ships until a specialist has matched the part to your cabin.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@include('parts_category_v2.partials.quote', [
    'formId' => 2,
    'label' => 'Fitment check',
    'title' => 'Not sure this is your part?',
])
@include('parts_category_v2.partials.related-links')
@include('parts_category_v2.partials.cta')

@endsection
