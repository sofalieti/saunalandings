<section class="pc2-goods">
    <div class="container">
    @if(isset($heading) && $heading)
        <div class="pc2-goods-head">
            <div>
                <span class="pc-section-kicker">Goods</span>
                <h2>{{ $heading }}</h2>
            </div>
        </div>
    @endif

    @if(count($products))
        <div class="pc2-goods-grid">
            @foreach($products as $product)
                <a class="pc2-goods-item" href="{{ route('product', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}">
                    <div class="pc2-goods-media">
                        @if($product->image)
                            <img src="{{ $product->image_thumb ?: ('/uploads/'.ltrim($product->image, '/')) }}" alt="{{ $product->name }}">
                        @endif
                    </div>
                    <div class="pc2-goods-body">
                        <span class="name">{{ $product->name }}</span>
                        @if($product->description)
                            <span class="desc">{!! str_limit(strip_tags($product->description), 110) !!}</span>
                        @endif
                        <span class="pc2-goods-cta">View part</span>
                    </div>
                </a>
            @endforeach
        </div>
        @if(method_exists($products, 'links'))
            <div class="pc-pagination">{{ $products->links() }}</div>
        @endif
    @else
        <div class="alert alert-info" role="alert">No goods in this category yet.</div>
    @endif
    </div>
</section>
