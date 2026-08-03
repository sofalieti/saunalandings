@extends('layouts.'.request()->get('layout'))

@section('content')

<div class="container my-5">
    <div class="parent-category">
        @include('enlightensauna.partials.category-section', [
            'category' => $category,
            'products' => $products,
        ])
    </div>
</div>

@endsection
