@extends('layouts.'.request()->get('layout'))
@section('content')

@php
    $dualbanner_content[0]['name'] = "Fix/Repair";
    $dualbanner_content[0]['text'] = "Describe your problem. And our specialist will contact you soon!";
    $dualbanner_content[0]['img_link'] = "/images/parts_main/fix-big.png";
    $dualbanner_content[0]['link'] = page_template('repair');
    $dualbanner_content[0]['category'] = $category->slug;

    $dualbanner_content[1]['name'] = "TROUBLESHOOT";
    $dualbanner_content[1]['text'] = "Describe your problem. And our specialist will contact you soon!";
    $dualbanner_content[1]['img_link'] = "/images/parts_main/trouble-top-big.png";
    $dualbanner_content[1]['link'] = page_template('troubleshooting');
    $dualbanner_content[1]['category'] = $category->slug;
@endphp

<div class="pc2-page-hero">
    <div class="container">
        <span class="pc-section-kicker">Goods</span>
        <h1>{{ rt("!brand!") }} {{ $category->name }}</h1>
        @if($category->text)
            <div class="pc-section-body">{!! $category->text !!}</div>
        @endif
    </div>
</div>

@include('parts_category_v2.partials.goods-grid', [
    'category' => $category,
    'products' => $products,
    'heading' => false,
])

@include('parts_category_v2.partials.related-links')

@include('blocks.delivery')
@include('blocks.dualbanner', ['banners_content' => $dualbanner_content])

@endsection
