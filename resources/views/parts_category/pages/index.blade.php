@extends('layouts.'.request()->get('layout'))

@section('content')
@php
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
@endphp

<section class="pc-hero">
    <div class="pc-hero-media" aria-hidden="true"></div>
    <div class="pc-hero-glow" aria-hidden="true"></div>
    <div class="pc-hero-inner">
        <p class="pc-hero-brand">{{ request()->get('brand')->name }}</p>
        <h1 class="pc-hero-title">Replacement fans that keep infrared cabins cool, quiet, and even.</h1>
        <p class="pc-hero-lead">Axial motors, exhaust blowers, and cabin circulation fans matched to your sauna electronics and airflow needs.</p>
        <div class="pc-hero-actions">
            <a class="pc-btn pc-btn-primary" href="#goods">Browse fans</a>
            <a class="pc-btn pc-btn-ghost" href="#" data-toggle="modal" data-target="#question">Get a free consult</a>
        </div>
    </div>
</section>

<section class="pc-intro">
    <div class="pc-shell pc-intro-grid">
        <div>
            <div class="pc-kicker">Infrared sauna parts</div>
            <h2>The right fan for the right heat path</h2>
            <div class="pc-copy">
                {!! text_block('main_page_text_block') !!}
            </div>
        </div>
        <div class="pc-form-panel">
            @include('forms.form', ['form_id' => 2])
        </div>
    </div>
</section>

@foreach($goodsCategories as $goodsCategory)
    @php
        $goodsProducts = $goodsCategory->active_products()->orderBy('position')->orderBy('name')->get();
    @endphp
    @if(count($goodsProducts))
        <section class="pc-goods" id="goods">
            <div class="pc-shell">
                <div class="pc-goods-head">
                    <div>
                        <div class="pc-kicker">In stock for this domain</div>
                        <h2>{{ $goodsCategory->name }}</h2>
                    </div>
                    <p>{{ $goodsCategory->text_short ?: $goodsCategory->text }}</p>
                </div>
                @include('parts_category.partials.goods-grid', [
                    'category' => $goodsCategory,
                    'products' => $goodsProducts,
                ])
            </div>
        </section>
    @endif
@endforeach

<section class="pc-consult">
    <div class="pc-shell">
        <h2>Have questions about fitment?</h2>
        <p>Send a photo of the broken fan or control bay and we’ll match a replacement.</p>
        <a class="pc-btn pc-btn-primary" href="#" data-toggle="modal" data-target="#question">Submit a quote</a>
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
