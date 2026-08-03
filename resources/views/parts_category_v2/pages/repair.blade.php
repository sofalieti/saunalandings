@php
    $repairText = text_block('repair_text_block');
    $mainPageExcerpt = trim(str_limit(strip_tags(text_block('main_page_text_block')), $limit = 300, $end = '...'));
@endphp
@extends('layouts.'.request()->get('layout'))
@section('content')
<div class="pc2-page-hero">
    <div class="container">
        <span class="pc-section-kicker">Repair</span>
        <h1>{!! text_block('repair_text_block_header') ?: (ucwords(strtolower(trim(request()->get('brand')->name))).' Repair') !!}</h1>
    </div>
</div>
<div class="container pc-page">
    <div class="row">
        <div class="col-md-6">
            @if($repairText)
            <div class="main-description pc-section-body">
                {!! $repairText !!}
            </div>
            @endif
            @if($mainPageExcerpt)
            <div class="description-from-main-page">
                {{ $mainPageExcerpt }}
            </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="right-form">
                @include('forms.form', ['form_id' => 2])
            </div>
        </div>
    </div>
</div>
@include('parts_category_v2.partials.related-links')
<section class="pc2-cta">
    <div class="container">
        <h2>HAVE QUESTIONS?</h2>
        <h3>CLICK HERE FOR A FREE CONSULTATION!</h3>
        <a class="btn btn-lg btn-success" href="#" data-toggle="modal" data-target="#question">Submit a quote</a>
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
