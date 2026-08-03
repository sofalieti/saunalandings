@php
    $sectionProducts = $products ?? $category->active_products;
@endphp
@if($sectionProducts && count($sectionProducts))
<div id="{{$category->slug}}" class="section category-variation">
    <h1 class="title">{{$category->name}}</h1>
    <div class="products">
        @foreach($sectionProducts as $product)
            @include('enlightensauna.partials.product', ['product' => $product])
        @endforeach
    </div>
</div>
@endif
