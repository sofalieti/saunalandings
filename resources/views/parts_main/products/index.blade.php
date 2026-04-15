@extends('layouts.'.request()->get('layout'))
@section('content')  
<div class='container'>
    <h1>{{$product->name}}</h1>
    <div class='row'>
        <div class="col-xl-6">
            <div class='product-img'>
                <div class='product-main-img'>
                    <a href="{{$product->image_big}}" data-fancybox="gallery"><img src="{{$product->image_medium}}"/></a>
                </div>

                @foreach($product->image_thumbs as $image)
                <div class='product-small-img'><img src="{{$image}}"/></div>
                @endforeach
            </div>
        </div>
        <div class="col-xl-6">
            <div class='product-description'>
                <span class="produc-description-title">description</span>
                <div class="produc-description-main">
                    {!! $product->description !!}
                </div>
                <span class="produc-description-title wasauna">{{request()->get('brand')->name}}</span>
                <div class="produc-description-main"> 
                    {{ str_limit(strip_tags(text_block('main_page_text_block')), $limit = 300, $end = '...') }}
                </div>
                <div class="product-description-banner">
                    <div class="product-description-banner-leftromb">
                        <span class="leftromb-text">10% <span class="leftromb-text-white">off</span></span>
                    </div>
                    <div class="product-description-banner-rightromb">
                        <a class="rightromb-text"  href="#" data-toggle="modal" data-target="#contact_us">contact us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='romb-fon '>
    <div class='container'>
        <div class="rhombus-block">
            @if($repair = category_template('repair'))
            <div class="rhombus-block1">
                <a class="link-romb" href="{{route_with_state('category_template', ['category_slug' => $category->slug, 'var_name' => $repair->var_name])}}">CLICK FOR Details</a>
                <img src="/images/parts_main/leftimg.png">
                <div class="rhombus-in">
                    <a href="{{route_with_state('category_template', ['category_slug' => $category->slug, 'var_name' => $repair->var_name])}}">
                        <span class="title-romb">{{$category->name}} <span class="title-romb1">FIX/REPAIR</span></span>
                        <span class="main-romb">Describe your problem. And our specialist will contact you soon!</span>
                    </a>
                </div>
            </div>
            @endif
            @if($troubleshooting = category_template('troubleshooting'))
            <div class="rhombus-block2">
                <a class="link-romb" href="{{route('category_template', ['category_slug' => $category->slug, 'var_name' => $troubleshooting->var_name])}}">CLICK FOR Details</a>
                <img src="/images/parts_main/rightimg.png">
                <div class="rhombus-in">
                    <a href="{{route('category_template', ['category_slug' => $category->slug, 'var_name' => $troubleshooting->var_name])}}">
                        <span class="title-romb">{{$category->name}} <span class="title-romb1">TROUBLESHOOT</span></span>
                        <span class="main-romb">Just make a photo of broken detail, and we will solve your problem</span>
                    </a>
                </div>
            </div>
            @endif
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