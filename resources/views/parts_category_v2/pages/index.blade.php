@php
    $h1 = trim(strip_tags(text_block('main_page_text_block_header')));
    if ($h1 === '') {
        $h1 = ucwords(strtolower(trim(request()->get('brand')->name))).' for Infrared Saunas';
    }

    $symptomsText = text_block('symptoms_text_block');
    $chooseText = text_block('how_to_choose_text_block');
    $faqText = text_block('faq_text_block');
    $trustText = text_block('trust_text_block');

    $dualbanner_content[0]['name'] = "Fix/Repair";
    $dualbanner_content[0]['text'] = "Describe your problem. And our specialist will contact you soon!";
    $dualbanner_content[0]['img_link'] = "/images/parts_main/fix-big.png";
    $dualbanner_content[0]['link'] = page_template('repair');
    $dualbanner_content[0]['category'] = false;

    $dualbanner_content[1]['name'] = "TROUBLESHOOT";
    $dualbanner_content[1]['text'] = "Describe your problem. And our specialist will contact you soon!";
    $dualbanner_content[1]['img_link'] = "/images/parts_main/trouble-top-big.png";
    $dualbanner_content[1]['link'] = page_template('troubleshooting');
    $dualbanner_content[1]['category'] = false;

    $goodsCategories = collect();
    foreach (request()->get('brand')->categories()->where('active', true)->orderBy('position')->orderBy('name')->get() as $linkedCategory) {
        $childCategories = $linkedCategory->childs;
        if ($childCategories && count($childCategories)) {
            foreach ($childCategories as $child) {
                $goodsCategories->push($child);
            }
        } else {
            $goodsCategories->push($linkedCategory);
        }
    }

    $faqItems = request()->get('brand')->faq_items()->where('active', true)->orderBy('position')->get()
        ->reject(function ($item) {
            return is_content_placeholder($item->question) || is_content_placeholder($item->answer);
        });
@endphp

@extends('layouts.'.request()->get('layout'))
@section('content')

@include('blocks.topbanner_category', ['banners_content' => $dualbanner_content])

<section class="pc2-intro">
    <div class="container">
        <span class="pc-section-kicker">{{ request()->get('brand')->domain }}</span>
        <h1>{{ $h1 }}</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="main-description">
                    {!! text_block('main_page_text_block') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="right-form">
                    @include('forms.form', ['form_id' => 2])
                </div>
            </div>
        </div>
    </div>
</section>

@if($symptomsText)
<section class="pc-section pc2-symptoms">
    <div class="container">
        <div class="pc-section-head">
            <span class="pc-section-kicker">Diagnostics</span>
            <h2>{!! text_block('symptoms_text_block_header') ?: 'Common symptoms' !!}</h2>
        </div>
        <div class="pc-section-body">
            {!! $symptomsText !!}
        </div>
    </div>
</section>
@endif

@if($chooseText)
<section class="pc-section pc2-choose">
    <div class="container">
        <div class="pc-section-head">
            <span class="pc-section-kicker">Fitment</span>
            <h2>{!! text_block('how_to_choose_text_block_header') ?: 'How to choose the right part' !!}</h2>
        </div>
        <div class="pc-section-body">
            {!! $chooseText !!}
        </div>
        @if(page_template('how_to_choose'))
            <p class="pc-section-link">
                <a href="{{ route('page_template_without_state', ['slug' => 'how_to_choose']) }}">Full how-to-choose guide</a>
            </p>
        @endif
    </div>
</section>
@endif

@foreach($goodsCategories as $goodsCategory)
    @php
        $goodsProducts = $goodsCategory->active_products()->orderBy('position')->orderBy('name')->get();
    @endphp
    @if(count($goodsProducts))
        @include('parts_category_v2.partials.goods-grid', [
            'category' => $goodsCategory,
            'products' => $goodsProducts,
            'heading' => $goodsCategory->name,
        ])
    @endif
@endforeach

@if(count($faqItems))
<section class="pc-section pc-section-alt" id="faq">
    <div class="container">
        <div class="pc-section-head">
            <span class="pc-section-kicker">Questions</span>
            <h2>{!! text_block('faq_text_block_header') ?: 'FAQ' !!}</h2>
        </div>
        @if($faqText)
            <div class="pc-section-body">{!! $faqText !!}</div>
        @endif
        @include('parts_category_v2.partials.faq-list', ['faqItems' => $faqItems])
        @if(page_template('faq'))
            <p class="pc-section-link">
                <a href="{{ route('page_template_without_state', ['slug' => 'faq']) }}">All FAQ</a>
            </p>
        @endif
    </div>
</section>
@endif

@include('parts_category_v2.partials.related-links')

@if($trustText)
<section class="pc-section pc-trust">
    <div class="container text-center">
        {!! $trustText !!}
    </div>
</section>
@endif

<section class="pc2-cta">
    <div class="container">
        <h2>Still not sure which part you need?</h2>
        <h3>Send a photo and a specialist confirms the fitment before you order.</h3>
        <a class="btn btn-lg btn-success" href="#" data-toggle="modal" data-target="#question">Request a free quote</a>
    </div>
</section>
@endsection
@section('footer')
    <div class="modal" id="question">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit a quote</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    @include('forms.form', ['form_id' => 3])
                </div>
            </div>
        </div>
    </div>
    @parent
@stop
