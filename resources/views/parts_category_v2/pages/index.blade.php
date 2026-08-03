@php
    $brand = request()->get('brand');

    $h1 = trim(strip_tags(text_block('main_page_text_block_header')));
    if ($h1 === '') {
        $h1 = ucwords(strtolower(trim($brand->name))).' for Infrared Saunas';
    }

    $mainText = text_block('main_page_text_block');
    $heroLead = '';
    $overviewText = '';
    if ($mainText) {
        if (preg_match('~<p[^>]*>(.*?)</p>~is', $mainText, $matches)) {
            $heroLead = trim(strip_tags($matches[1]));
            $overviewText = trim(preg_replace('~<p[^>]*>.*?</p>~is', '', $mainText, 1));
        } else {
            $heroLead = trim(strip_tags($mainText));
        }
    }

    $symptomsText = text_block('symptoms_text_block');
    $chooseText = text_block('how_to_choose_text_block');
    $faqText = text_block('faq_text_block');
    $trustText = text_block('trust_text_block');

    $goodsCategories = collect();
    foreach ($brand->categories()->where('active', true)->orderBy('position')->orderBy('name')->get() as $linkedCategory) {
        $childCategories = $linkedCategory->childs;
        if ($childCategories && count($childCategories)) {
            foreach ($childCategories as $child) {
                $goodsCategories->push($child);
            }
        } else {
            $goodsCategories->push($linkedCategory);
        }
    }

    $heroImage = null;
    $heroCaption = null;
    foreach ($goodsCategories as $goodsCategory) {
        if ($goodsCategory->image) {
            $heroImage = $goodsCategory->image_medium ?: ('/uploads/'.ltrim($goodsCategory->image, '/'));
            $heroCaption = $goodsCategory->name;
            break;
        }
        $firstProduct = $goodsCategory->active_products()->orderBy('position')->orderBy('name')->first();
        if ($firstProduct && $firstProduct->image) {
            $heroImage = $firstProduct->image_medium ?: ('/uploads/'.ltrim($firstProduct->image, '/'));
            $heroCaption = $firstProduct->name;
            break;
        }
    }

    $faqItems = $brand->faq_items()->where('active', true)->orderBy('position')->get()
        ->reject(function ($item) {
            return is_content_placeholder($item->question) || is_content_placeholder($item->answer);
        });
@endphp

@extends('layouts.'.request()->get('layout'))
@section('content')

<header class="au-hero">
    <div class="au-shell">
        <div class="au-hero__grid">
            <div class="au-hero__copy">
                <span class="au-tag">{{ $brand->domain }}</span>
                <h1 class="au-h1">{{ $h1 }}</h1>
                @if($heroLead)
                    <p class="au-lead au-hero__lead">{{ $heroLead }}</p>
                @endif
                <div class="au-actions">
                    <a class="au-btn" href="#quote" data-toggle="modal" data-target="#question">Request a fitment check</a>
                    @if(count($goodsCategories))
                        <a class="au-link au-link--icon" href="#parts">See the parts we stock</a>
                    @endif
                </div>
                <div class="au-hero__meta">
                    <span class="au-tag au-tag--quiet">Photo-matched fitment</span>
                    <span class="au-tag au-tag--quiet">USA &amp; Canada shipping</span>
                    <span class="au-tag au-tag--quiet">Specialist answer, not a bot</span>
                </div>
            </div>
            @if($heroImage)
                <div class="au-hero__media">
                    <img src="{{ $heroImage }}" alt="{{ $heroCaption }}">
                    <span class="au-caption">{{ $heroCaption }}</span>
                </div>
            @endif
        </div>
    </div>
</header>

@if($overviewText)
<section class="au-section">
    <div class="au-shell">
        <div class="au-split">
            <div class="au-split__aside">
                <span class="au-label">Overview</span>
                <p class="au-caption au-head__note">One part family, described in detail — no generic catalog copy.</p>
            </div>
            <div class="au-card au-card--body">
                <div class="au-prose au-prose--full">{!! $overviewText !!}</div>
            </div>
        </div>
    </div>
</section>
@endif

@if($symptomsText)
<section class="au-section" id="symptoms">
    <div class="au-shell">
        <div class="au-head">
            <span class="au-label">Diagnostics</span>
            <h2 class="au-title">{!! text_block('symptoms_text_block_header') ?: 'Signs the part is failing' !!}</h2>
        </div>
        <div class="au-prose au-prose--full au-prose--rows au-head__note">{!! $symptomsText !!}</div>
    </div>
</section>
@endif

@if($chooseText)
<section class="au-section" id="fitment">
    <div class="au-shell">
        <div class="au-head">
            <span class="au-label">Fitment</span>
            <h2 class="au-title">{!! text_block('how_to_choose_text_block_header') ?: 'How to choose the right part' !!}</h2>
        </div>
        <div class="au-card au-card--body au-head__note">
            <div class="au-prose au-prose--full au-prose--steps">{!! $chooseText !!}</div>
            @if(page_template('how_to_choose'))
                <p class="au-actions">
                    <a class="au-link au-link--icon" href="{{ route('page_template_without_state', ['slug' => 'how_to_choose']) }}">Full how-to-choose guide</a>
                </p>
            @endif
        </div>
    </div>
</section>
@endif

<div id="parts"></div>
@foreach($goodsCategories as $goodsCategory)
    @php
        $goodsProducts = $goodsCategory->active_products()->orderBy('position')->orderBy('name')->get();
    @endphp
    @if(count($goodsProducts))
        @include('parts_category_v2.partials.goods-grid', [
            'category' => $goodsCategory,
            'products' => $goodsProducts,
            'heading' => $goodsCategory->name,
            'showCategoryLink' => true,
        ])
    @endif
@endforeach

@include('parts_category_v2.partials.quote', ['formId' => 2])

@if(count($faqItems))
<section class="au-section" id="faq">
    <div class="au-shell">
        <div class="au-head">
            <span class="au-label">Questions</span>
            <h2 class="au-title">{!! text_block('faq_text_block_header') ?: 'Frequently asked' !!}</h2>
            @if($faqText)
                <div class="au-prose au-head__note">{!! $faqText !!}</div>
            @endif
        </div>
        @include('parts_category_v2.partials.faq-list', ['faqItems' => $faqItems])
        @if(page_template('faq'))
            <p class="au-actions">
                <a class="au-link au-link--icon" href="{{ route('page_template_without_state', ['slug' => 'faq']) }}">All questions</a>
            </p>
        @endif
    </div>
</section>
@endif

@if($trustText)
<section class="au-section">
    <div class="au-shell">
        <div class="au-trust">
            <div>
                <span class="au-label">Why us</span>
            </div>
            <div class="au-prose au-prose--full">{!! $trustText !!}</div>
        </div>
    </div>
</section>
@endif

@include('parts_category_v2.partials.related-links')
@include('parts_category_v2.partials.cta')

@endsection
