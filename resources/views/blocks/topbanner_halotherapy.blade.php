@if($banner = get_promo_banner())
<div class="main-banner">
    <div class="info">
        <div class="container">
            <div class="title">{{$banner['promotion_name']}}</div>
            <div class="promotion-text">
                <span class="percent">{{$banner['percent']}}% </span>
                <span class="sub-title">Off On All Items</span>
                <div class="text">
                    FREE FEDEX GROUND SHIPPING <br/> 
                    In USA And Canada Only <br/> 
                    (On All Orders Above $300)
                </div>
            </div>
            <div class="dates">
                <label>
                    Valid from:
                </label>
                <div class="value">
                    <span class="BannerValidDate">{{$banner['date_start']}}</span>
                </div>
                @if(empty($banner['date_extended']))
                <label>
                    Thru:
                </label>
                <div class="value">
                    <span class="BannerValidDate">{{$banner['date_end']}}</span>
                </div>
                @else
                <label>
                    Thru:
                </label>
                <div class="value">
                    <span class="BannerValidDate"><s>{{$banner['date_end']}}</s></span>
                </div>
                <label>
                    Extended:
                </label>
                <div class="value">
                    <span class="BannerValidDate">{{$banner['date_extended']}}</span>
                </div>
                @endif
            </div>
            <div class="mt-3">
                <a href="/pay" class="btn btn-primary text-uppercase px-5 py-3">Order now</a>
            </div>
        </div>
    </div>
</div>
@endif