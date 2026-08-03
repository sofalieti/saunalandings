@extends('layouts.'.request()->get('layout'))
@section('content')

<div class="container">
    <h1>{{ $product->name }}</h1>
    <div class="row">
        <div class="col-xl-6">
            <div class="product-img">
                @if($product->image)
                    <div class="product-main-img">
                        <a href="{{ $product->image_big }}" data-fancybox="gallery"><img src="{{ $product->image_medium }}" alt="{{ $product->name }}"/></a>
                    </div>
                @endif
                @if(is_array($product->image_thumbs))
                    @foreach($product->image_thumbs as $image)
                        <div class="product-small-img"><img src="{{ $image }}" alt=""/></div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-xl-6">
            <div class="product-description">
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
