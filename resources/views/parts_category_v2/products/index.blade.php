@php
    $brand = request()->get('brand');
    $productImage = $product->image ? url('/uploads/'.ltrim($product->image, '/')) : null;
@endphp
@extends('layouts.'.request()->get('layout'))
@section('content')

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": {{ json_encode($product->name) }},
  "description": {{ json_encode(trim(strip_tags($product->description))) }},
  "brand": {{ json_encode($brand->name) }}
  @if($productImage)
  ,"image": {{ json_encode($productImage) }}
  @endif
  ,"category": {{ json_encode($category->name) }}
}
</script>

<header class="au-page-hero">
    <div class="au-shell">
        <nav class="au-crumbs">
            <a href="/">Home</a>
            <span>/</span>
            <a href="{{ route('category', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
            <span>/</span>
            <span>{{ $product->name }}</span>
        </nav>

        <div class="au-product">
            <div class="au-product__media">
                @if($product->image)
                    <img src="{{ $product->image_big ?: ('/uploads/'.ltrim($product->image, '/')) }}" alt="{{ $product->name }}"/>
                @endif
            </div>
            <div class="au-product__copy">
                <span class="au-tag">{{ $category->name }}</span>
                <h1 class="au-h1">{{ $product->name }}</h1>

                @if($product->description)
                    <div class="au-prose au-prose--full au-product__prose">{!! $product->description !!}</div>
                @endif

                <dl class="au-specs">
                    <div class="au-specs__row">
                        <dt>Fits</dt>
                        <dd>Infrared sauna cabins — confirmed against your model from a photo.</dd>
                    </div>
                    <div class="au-specs__row">
                        <dt>Shipping</dt>
                        <dd>USA and Canada, free on orders above $300.</dd>
                    </div>
                    <div class="au-specs__row">
                        <dt>Support</dt>
                        <dd>{{ $brand->domain }} — parts specialists, not a general marketplace.</dd>
                    </div>
                </dl>

                <div class="au-product__offer">
                    <span class="au-tag">10% off your first order</span>
                    <a class="au-btn" href="#" data-toggle="modal" data-target="#contact_us">Contact us about this part</a>
                </div>
            </div>
        </div>
    </div>
</header>

@include('parts_category_v2.partials.related-links')
@include('parts_category_v2.partials.cta')

@endsection
@section('footer')
    <div class="modal" id="contact_us">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Contact us</h4>
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
