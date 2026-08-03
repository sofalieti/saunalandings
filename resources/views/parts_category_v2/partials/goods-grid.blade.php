<div class="container center category-block parts-category-goods">
    @if(isset($heading) && $heading)
        <h2 class="goods-heading">{{ $heading }}</h2>
    @endif
    <div class="row category_page_paddings">
        @if(count($products))
            @foreach($products as $product)
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <a class="item" href="{{ route('product', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}">
                        <div class="item-img-block">
                            @if($product->image)
                                <img class="category-img" src="{{ $product->image_thumb_crop }}" alt="{{ $product->name }}"/>
                            @endif
                        </div>
                        <div class="item-description">
                            <span class="name">{{ mb_strimwidth($product->name, 0, 50, "...") }}</span>
                            @if($product->description)
                                <span class="category-description">{!! str_limit(strip_tags($product->description), 100) !!}</span>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
            @if(method_exists($products, 'links'))
                {{ $products->links() }}
            @endif
        @else
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    No goods in this category yet.
                </div>
            </div>
        @endif
    </div>
</div>
