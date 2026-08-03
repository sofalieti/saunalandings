@php
    $auGoodsHeading = isset($heading) ? $heading : false;
    $auShowCategoryLink = isset($showCategoryLink) ? $showCategoryLink : false;
@endphp
<section class="au-section au-reveal">
    <div class="au-shell">
        @if($auGoodsHeading)
            <div class="au-head">
                <span class="au-label">Catalog</span>
                <h2 class="au-title">{{ $auGoodsHeading }}</h2>
            </div>
        @endif

        @if(count($products))
            <div class="au-goods">
                @foreach($products as $product)
                    <a class="au-good" href="{{ route('product', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}">
                        <span class="au-good__media">
                            @if($product->image)
                                <img src="{{ $product->image_medium ?: ('/uploads/'.ltrim($product->image, '/')) }}" alt="{{ $product->name }}">
                            @endif
                        </span>
                        <span class="au-good__name">{{ $product->name }}</span>
                        @if($product->description)
                            <span class="au-good__desc">{{ \Illuminate\Support\Str::words(trim(strip_tags($product->description)), 16, '…') }}</span>
                        @endif
                        <span class="au-good__cta">View part</span>
                    </a>
                @endforeach
            </div>

            @if(method_exists($products, 'links'))
                <div class="au-pagination">{{ $products->links() }}</div>
            @endif

            @if($auShowCategoryLink)
                <p class="au-actions">
                    <a class="au-link au-link--icon" href="{{ route('category', ['slug' => $category->slug]) }}">All {{ strtolower($category->name) }}</a>
                </p>
            @endif
        @else
            <p class="au-empty au-muted">No parts published in this category yet — send a photo and we will source it.</p>
        @endif
    </div>
</section>
