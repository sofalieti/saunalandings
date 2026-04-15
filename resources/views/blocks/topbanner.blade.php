@if($banner = get_promo_banner())
<div class='banner-fon'>
    <div class="banner-home_top" style="background-image: url({{$banner['banner_bg']}});">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 offset-md-1 text-center image-block">
                    <img src='{{$banner['banner_image']}}' class='img-fluid'/>
                </div>
                <div class="col-md-5">
                    <div class="info">
                        <div class="title">{{$banner['promotion_name']}}</div>
                        <div class="promotion-text">
                            <span class="percent">{{$banner['percent']}}% </span>
                            <span class="sub-title">Off On All Items</span> <br/> 
                            FREE FEDEX GROUND SHIPPING <br/> 
                            In USA And Canada Only <br/> 
                            (On All Orders Above $300)
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dates">
                            <label>
                                Valid from:
                            </label>
                            <div class="value">
                                <span class="BannerValidDate">{{$banner['date_start']}}</span>
                            </div>
                            <div class="clear"></div>
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
                                <div class="clear"></div>
                                <label>
                                    Extended:
                                </label>
                                <div class="value">
                                    <span class="BannerValidDate">{{$banner['date_extended']}}</span>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center r-and-t-block">
            <div class="col-lg-5 offset-md-1 col-md-10">
                <a href="/{{request()->get('state')->slug}}/repair" class="home-top-leftblock-link">
                    <div class="home-top-leftblock row">
                        <div class="col-3">
                            <img src="{{$banners_content[0]['img_link']}}" class="img-fluid">
                        </div>
                        <div class="col-9">
                            <span class="home-top-leftblock_span-title">{{$banners_content[0]['name']}}</span>
                            <span class="home-top-leftblock_span-main">{{$banners_content[0]['text']}}</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-5 col-md-10 offset-md-1 offset-lg-0 mt-3 mt-lg-0">
                <a href="/troubleshooting" class="home-top-leftblock-link">
                    <div class="home-top-leftblock row">
                        <div class="col-3">
                            <img src="{{$banners_content[1]['img_link']}}" class="img-fluid">
                        </div>
                        <div class="col-9">
                            <span class="home-top-leftblock_span-title">{{$banners_content[1]['name']}}</span>
                            <span class="home-top-leftblock_span-main">{{$banners_content[1]['text']}}</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endif