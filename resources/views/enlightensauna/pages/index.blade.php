@extends('layouts.'.request()->get('layout'))

@section('content')

<div class="container my-5">
    <div class="parent-category">
        @php
            $linkedCategories = request()->get('brand')->categories()
                ->where('active', true)
                ->orderBy('position', 'ASC')
                ->orderBy('name', 'ASC')
                ->get();
            $variationCategories = collect();

            foreach ($linkedCategories as $linkedCategory) {
                $childVariations = $linkedCategory->childs;
                if ($childVariations && count($childVariations)) {
                    foreach ($childVariations as $child) {
                        $variationCategories->push($child);
                    }
                } else {
                    $variationCategories->push($linkedCategory);
                }
            }
        @endphp

        @forelse($variationCategories as $category)
            @include('enlightensauna.partials.category-section', ['category' => $category])
        @empty
            {{-- No landings category variations linked to this brand --}}
        @endforelse
    </div>
</div>

@endsection
