@extends('layouts.'.request()->get('layout'))

@section('content')
<div class="pc-page">
    <div class="pc-shell pc-product-layout">
        <div class="pc-product-media">
            @if($product->image)
                <img src="{{ $product->image_medium ?: ('/uploads/' . ltrim($product->image, '/')) }}" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="pc-product-copy">
            <div class="pc-kicker">{{ $category->name }}</div>
            <h1>{{ $product->name }}</h1>
            <span class="label">Description</span>
            <div>{!! $product->description !!}</div>
            <span class="label">Brand domain</span>
            <div>{{ request()->get('brand')->name }}</div>
            <div class="pc-hero-actions">
                <a class="pc-btn pc-btn-primary" href="#" data-toggle="modal" data-target="#contact_us">Ask about this part</a>
                <a class="pc-btn pc-btn-ghost" href="{{ route('category', ['slug' => $category->slug]) }}">Back to category</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    <div class="modal" id="contact_us">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Contact Us</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    @include('forms.form', ['form_id' => 4])
                </div>
            </div>
        </div>
    </div>
    @parent
@stop
