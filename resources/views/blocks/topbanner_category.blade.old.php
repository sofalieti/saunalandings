@if($banner = get_promo_banner())
<div class=' d-none d-md-block banner-fon'>
    <div class='container'>
        <div class="row align-items-center  ">
            <div class="col-3  d-none d-lg-block d-xl-block">
                <div class="mod-menu">
                    <div class="mod-menu_header">
                        <span class="mod-menu_title">Top Categories</span>
                    </div>

                    <ul class="mod-menu_ul">
                        <li class="mod-menu_li">
                            <a href="#">Top 20 Electronics Deals!</a>
                        </li>
                        <li class="mod-menu_li">
                            <a href="#">Today's Special Presales</a>
                        </li>
                        <li class="mod-menu_li">
                            <a href="#">5 Or More FlexPay!</a>
                        </li>
                        <li class="mod-menu_li">
                            <a href="#">Free S&amp;H on All Electronics!</a>
                        </li>
                        <li class="mod-menu_li">
                            <a href="#">Electronics on Sale!</a>
                        </li>
                        <li class="mod-menu_li">
                            <a href="#">New Arrivals!</a>
                        </li>
                    </ul>
                </div>
            </div> 

            <div class="col-12 d-none d-md-block col-lg-9">
                <div class="moduletable" style="background-image: url({{$banner['banner_bg']}})">
                    <div class="moduletable-text">
                        <div class="main-banner-title">
                            <span style="text-transform:uppercase;font-size: 30px;color: #db3215; margin-top:30px;">{!! $banner['promotion_name'] !!}</span>
                        </div>
                        <div class="BLDiscount">
                            <span>{{@$banner['percent']}}% </span> OFF ON ALL ITEMS
                            FREE FEDEX GROUND SHIPPING
                            IN USA AND CANADA ONLY
                            (ON ALL ORDERS ABOVE $300)
                        </div>
                        <span class="BannerValid standartpadding-top">
                            <span class="banner-layer-valid">
                                valid from <span class="BannerValidDate">{!! @$banner['date_start'] !!}</span>
                                thru <span class="BannerValidDate">{!! @$banner['date_end'] !!}</span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif