@php
    $brand = request()->get('brand');
    $chooseText = text_block('how_to_choose_text_block');
    $pageTitle = text_block('how_to_choose_page_header')
        ?: text_block('how_to_choose_text_block_header')
        ?: ('How to choose '.ucwords(strtolower(trim($brand->name))));
@endphp
@extends('layouts.'.request()->get('layout'))
@section('content')

<header class="au-page-hero">
    <div class="au-shell">
        <nav class="au-crumbs">
            <a href="/">Home</a>
            <span>/</span>
            <span>How to choose</span>
        </nav>
        <span class="au-label au-head__note">Fitment</span>
        <h1 class="au-h1">{!! $pageTitle !!}</h1>
    </div>
</header>

<section class="au-section au-section--tight">
    <div class="au-shell">
        <div class="au-split au-split--wide">
            <div class="au-card au-card--body">
                @if($chooseText)
                    <div class="au-prose au-prose--full au-prose--steps">{!! $chooseText !!}</div>
                @endif
            </div>
            <aside class="au-split__aside au-form-card">
                @include('forms.form', ['form_id' => 2])
            </aside>
        </div>
    </div>
</section>

@include('parts_category_v2.partials.related-links')
@include('parts_category_v2.partials.cta')

@endsection
