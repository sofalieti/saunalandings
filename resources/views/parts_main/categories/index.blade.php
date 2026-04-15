@php
$dualbanner_content[0]['name'] = "Fix/Repair";
$dualbanner_content[0]['text'] = "Describe your problem. And our specialist will contact you soon!";
$dualbanner_content[0]['img_link'] = "/images/parts_main/fix-big.png";
$dualbanner_content[0]['link'] = page_template('repair');

$dualbanner_content[1]['name'] = "TROUBLESHOOT";
$dualbanner_content[1]['text'] = "Describe your problem. And our specialist will contact you soon!";
$dualbanner_content[1]['img_link'] = "/images/parts_main/trouble-top-big.png";
$dualbanner_content[1]['link'] = page_template('troubleshooting');

$dualbanner_content[0]['category'] = false;
$dualbanner_content[1]['category'] = "$category->slug";
@endphp


@extends('layouts.'.request()->get('layout'))
@section('content')  






<div class='container main-container leftheader'>
    <div class="row">
        <div class="d-block col-12 col-md-12 col-lg-7 col-xl-7">
            <div class="row">
                <div class="d-block  col-12 col-sm-12 col-md-6 col-lg-12">
                    <div class="thin-line"></div>
                    <h1>{{rt("!brand!") }} {{$category->type}} REPLACEMENT</h1>
             
                </div>
                <div class="d-none col-12 d-sm-none d-md-block d-lg-none col-sm-6 ">
                    <div class="thin-line"></div>
                    @if($banner = get_promo_banner())
                    <div class="discount-block">          
                        <span>{{$banner['percent']}}%</span><br>
                        Off for {!! strip_tags($banner['promotion_name']) !!}
                    </div>
                    @endif
                </div>
                <div class="col-12 col-md-6  col-lg-12 " >
                    <div class="thin-line-2"></div>
                    <div class="row">
                        <div class="col-12 col-sm-4 ">
                            <div class="category_image"><img src="/uploads/{!! $category->image !!}"></div>
                  
                        </div>
                        <div class="col-12 col-sm-8">
                            <div class="inside-block-margin">{!! $category->text !!}</div>
                        </div>
                    </div>    
                </div>
                <div class="d-block d-sm-block d-md-none d-lg-block col-sm-4 col-12">
                    <div class="thin-line "></div>
                    @if($banner = get_promo_banner())
                    <div class="discount-block">          
                        <span>{{$banner['percent']}}%</span><br>
                        Off for {!! strip_tags($banner['promotion_name']) !!}
                    </div>
                    @endif
                </div>
                <div class="col-sm-8 col-md-6 col-lg-8 col-12 "  >

                    <div class="thin-line-2  "></div>
                    <div class="inside-block-margin">    {!! str_limit(text_block('BRAND_TEXT'), 400) !!}</div>
                    <div class="d-none d-md-block d-lg-none ">
                        <div class="consult_simple_button">Free Consult</div>

                    </div>
                </div>


            </div>
        </div>
        <div class="d-block d-md-none d-lg-block col-12 col-md-6 col-lg-5 col-xl-5">
            <div class="right-form">
                @include('forms.form', ['form_id' => 2])                     
            </div>
        </div>
    </div>
</div>




 
{{--
<div class='container center category-block'>
    <h1> {{rt("!brand!") }} {{$category->type}} REPLACEMENT</h1>

    <div class="row category_page_paddings">
        @if(count($products))
        @foreach($products as $product)
        <div class="col-xl-3 col-md-4 col-sm-6">
            <a class="item" href="{{route('product', ['category_slug' => $category->slug, 'product_slug' => $product->slug])}}">
                <div class="item-img-block">
                    <img class="category-img" src="{{$product->image_thumb_crop}}"/>
                </div>
                <div class="item-description">
                    <span class="name">{{mb_strimwidth($product->name, 0, 50, "...")}}</span>
                    <span class="category-description">{!! str_limit(strip_tags($product->description), 100) !!}</span>
                </div>
            </a>
        </div>
        @endforeach
        {{ $products->links() }}
        @else
        <div class="alert alert-danger" role="alert">
            Empty
        </div>
        @endif
    </div>
</div>
--}}

@include('blocks.delivery')
@include('blocks.dualbanner', ['banners_content' => $dualbanner_content])




@endsection

