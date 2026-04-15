@extends('layouts.'.request()->get('layout'))

@section('content')

<div class="container my-5">
    <div class="parent-category">
        @php
        $category = request()->get('brand')->categories[0]->childs[0] ?? false
        @endphp
        @if($category)
        <div id="{{$category->slug}}" class="section">
            <h1 class="title">{{$category->name}}</h1>
            <div class="products">
                @foreach($category->products as $product)
                <div class="product">
                    <div class="row">
                        <div class="col-lg-4 image-block">
                            <img src="/uploads{{str_replace(".", "_400.", $product->image)}}" class="w-100"/>
                        </div>
                        <div class="col-lg-8">
                            <div class="name font-weight-bold mb-3">
                                {{$product->name}}
                            </div>
                            <ul class="nav nav-tabs nav-fill" id="productData{{$product->id}}Tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="description-tab{{$product->id}}" data-toggle="tab" href="#description{{$product->id}}" role="tab" aria-controls="description{{$product->id}}" aria-selected="true">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sizes-weight-tab{{$product->id}}" data-toggle="tab" href="#sizes_weight{{$product->id}}" role="tab" aria-controls="sizes_weight{{$product->id}}" aria-selected="false">Sizes/Weight</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="features-tab{{$product->id}}" data-toggle="tab" href="#features{{$product->id}}" role="tab" aria-controls="features{{$product->id}}" aria-selected="false">Features</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="power-tab{{$product->id}}" data-toggle="tab" href="#power{{$product->id}}" role="tab" aria-controls="power{{$product->id}}" aria-selected="false">Power</a>
                                </li>
                            </ul>
                            <div class="tab-content py-3" id="productData{{$product->id}}TabContent">
                                <div class="tab-pane fade show active" id="description{{$product->id}}" role="tabpanel" aria-labelledby="description-tab{{$product->id}}">{!!$product->description!!}</div>
                                <div class="tab-pane fade" id="sizes_weight{{$product->id}}" role="tabpanel" aria-labelledby="sizes-weight-tab{{$product->id}}">{!!$product->enlightensauna_size_weight_html!!}</div>
                                <div class="tab-pane fade" id="features{{$product->id}}" role="tabpanel" aria-labelledby="features-tab{{$product->id}}">{!!$product->enlightensauna_features_html!!}</div>
                                <div class="tab-pane fade" id="power{{$product->id}}" role="tabpanel" aria-labelledby="power-tab{{$product->id}}">{!!$product->enlightensauna_power_html!!}</div>
                            </div>
                            <div class="text-right">
                                <a href="{{$product->exim_link}}" target="_blank" class="btn btn-primary">More</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
