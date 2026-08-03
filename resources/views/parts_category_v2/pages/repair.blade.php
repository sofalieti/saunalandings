@php
    $brand = request()->get('brand');
    $repairText = text_block('repair_text_block');
    $mainPageExcerpt = trim(str_limit(strip_tags(text_block('main_page_text_block')), $limit = 300, $end = '...'));
    $pageTitle = text_block('repair_text_block_header') ?: (ucwords(strtolower(trim($brand->name))).' Repair');
@endphp
@extends('layouts.'.request()->get('layout'))
@section('content')

<header class="au-page-hero">
    <div class="au-shell">
        <nav class="au-crumbs">
            <a href="/">Home</a>
            <span>/</span>
            <span>Repair</span>
        </nav>
        <span class="au-label au-head__note">Repair</span>
        <h1 class="au-h1">{!! $pageTitle !!}</h1>
        @if($mainPageExcerpt)
            <p class="au-lead au-hero__lead">{{ $mainPageExcerpt }}</p>
        @endif
    </div>
</header>

<section class="au-section au-section--tight">
    <div class="au-shell">
        <div class="au-split au-split--wide">
            <div class="au-card au-card--body">
                @if($repairText)
                    <div class="au-prose au-prose--full">{!! $repairText !!}</div>
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
