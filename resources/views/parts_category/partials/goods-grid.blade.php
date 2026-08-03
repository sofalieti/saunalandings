<div class="pc-goods-grid">
    @foreach($products as $product)
        <a class="pc-goods-item" href="{{ route('product', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}">
            <div class="pc-goods-media">
                @if($product->image)
                    <img src="{{ $product->image_thumb_crop ?: ('/uploads/' . ltrim($product->image, '/')) }}" alt="{{ $product->name }}">
                @endif
            </div>
            <div class="pc-goods-body">
                <span class="name">{{ $product->name }}</span>
                @if($product->description)
                    <span class="desc">{!! str_limit(strip_tags($product->description), 110) !!}</span>
                @endif
                <span class="pc-goods-cta">View part</span>
            </div>
        </a>
    @endforeach
</div>
@if(method_exists($products, 'links'))
    <div class="pc-pagination">
        {{ $products->links() }}
    </div>
@endif
