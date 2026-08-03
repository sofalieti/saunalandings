@extends('layouts.'.request()->get('layout'))

@section('content')
<div class="pc-page">
    <div class="pc-shell">
        <div class="pc-category-head">
            <div class="pc-kicker">Category</div>
            <h1>{{ $category->name }}</h1>
            @if($category->text)
                <p>{!! $category->text !!}</p>
            @endif
        </div>

        @include('parts_category.partials.goods-grid', [
            'category' => $category,
            'products' => $products,
        ])
    </div>
</div>
@endsection
