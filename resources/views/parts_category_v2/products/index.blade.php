@extends('layouts.'.request()->get('layout'))
@section('content')

@php
    $productImage = $product->image ? url('/uploads/'.ltrim($product->image, '/')) : null;
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": {{ json_encode($product->name) }},
  "description": {{ json_encode(trim(strip_tags($product->description))) }},
  "brand": {{ json_encode(request()->get('brand')->name) }}
  @if($productImage)
  ,"image": {{ json_encode($productImage) }}
  @endif
  ,"category": {{ json_encode($category->name) }}
}
</script>

<div class="pc2-product-wrap">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="pc2-product-media">
                    @if($product->image)
                        <img src="{{ $product->image_medium ?: ('/uploads/'.ltrim($product->image, '/')) }}" alt="{{ $product->name }}"/>
                    @endif
                </div>
            </div>
            <div class="col-xl-6">
                <div class="product-description pc2-product-copy">
                    <span class="pc-section-kicker">{{ $category->name }}</span>
                    <h1>{{ $product->name }}</h1>
                    <span class="produc-description-title">description</span>
                    <div class="produc-description-main">
                        {!! $product->description !!}
                    </div>
                    <span class="produc-description-title wasauna">{{ request()->get('brand')->name }}</span>
                    <div class="product-description-banner">
                        <div class="product-description-banner-leftromb">
                            <span class="leftromb-text">10% <span class="leftromb-text-white">off</span></span>
                        </div>
                        <div class="product-description-banner-rightromb">
                            <a class="rightromb-text" href="#" data-toggle="modal" data-target="#contact_us">contact us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('parts_category_v2.partials.related-links')

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
