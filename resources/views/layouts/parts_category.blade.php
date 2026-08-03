<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ rt($meta['title']) }}</title>
    <meta name="keywords" content="{{ rt($meta['keywords']) }}" />
    <meta name="description" content="{{ rt($meta['description']) }}"/>
    <meta name="robots" content="index, follow" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Syne:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="{!! asset('css/bootstrap.min.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('css/parts_category/app.css') !!}" type="text/css" rel="stylesheet" />
</head>
<body class="parts-category-body">
<header class="pc-header">
    <div class="pc-shell pc-header-inner">
        <a class="pc-brand" href="/">
            <img src="/images/parts_category/logo.svg" alt="Infrared Sauna Parts">
            <div class="pc-brand-name">
                {{ request()->get('brand')->name }}
                <span>{{ request()->get('brand')->domain }}</span>
            </div>
        </a>
        <div class="pc-state">
            <div class="pc-state-label">Select your state</div>
            <a href="#" class="pc-state-link" data-toggle="modal" data-target="#state_list">
                @if(request()->get('state')->default)
                    {{ request()->get('state')->name }}
                @else
                    USA, {{ request()->get('state')->name }}
                @endif
            </a>
        </div>
        <div class="pc-phones">
            <div class="pc-social">
                <a href="https://www.trustpilot.com/review/infraredsaunaparts.com"><img src="/images/trustpilot_icon.svg" alt="Trustpilot"></a>
                <a href="https://twitter.com/InfraSaunaParts"><img src="/images/parts_main/twittericon.png" alt="Twitter"></a>
                <a href="https://www.yelp.com/biz/infraredsaunaparts-san-diego"><img src="/images/parts_main/yelpicon.png" alt="Yelp"></a>
            </div>
            <div>
                <strong>Toll Free</strong>
                <a href="tel:+18885597278">+1-888-559-PART (7278)</a>
            </div>
            <div>
                <strong>Text / SMS</strong>
                <a href="tel:+13477461765">+1-347-746-1765</a>
            </div>
        </div>
    </div>
</header>

@yield('content')

<div class="pc-map google-map">
    <iframe width="100%" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed" title="Service map"></iframe>
</div>

@section('footer')
<footer class="pc-footer">
    <div class="pc-shell pc-footer-grid">
        <div>
            <h4>Build your sauna</h4>
            <ul>
                <li><a href="https://infraredsaunaparts.com/build-your-infrared-sauna.html">Build your sauna</a></li>
                <li><a href="https://infraredsaunaparts.com/build-your-sauna-clone.html">Customize your rain cover</a></li>
                <li><a href="https://infraredsaunaparts.com/do-it-yourself-infrared-sauna-kits-en.html">DIY infrared sauna kits</a></li>
            </ul>
        </div>
        <div>
            <h4>Support</h4>
            <ul>
                <li><a href="https://infraredsaunaparts.com/support.html">Support</a></li>
                <li><a href="https://infraredsaunaparts.com/f.a.q..html">F.A.Q.</a></li>
                <li><a href="https://infraredsaunaparts.com/return-policy.html">Return policy</a></li>
                <li><a href="https://infraredsaunaparts.com/warranty.html">Warranty</a></li>
            </ul>
        </div>
        <div>
            <h4>Company</h4>
            <ul>
                <li><a href="https://infraredsaunaparts.com/">Home</a></li>
                <li><a href="https://infraredsaunaparts.com/about-us.html">About us</a></li>
                <li><a href="https://infraredsaunaparts.com/reviews-en.html">Reviews</a></li>
                <li><a href="https://infraredsaunaparts.com/become-a-dealer.html">Become a dealer</a></li>
            </ul>
        </div>
        <div>
            <h4>Contact</h4>
            <ul>
                <li><a href="https://infraredsaunaparts.com/contact-infraredsaunaparts.com.html">Contact us</a></li>
                <li><a href="https://infraredsaunaparts.com/support-claim.html">Trouble ticket</a></li>
                <li><a href="https://infraredsaunaparts.com/virtual-service-call.html">Virtual service call</a></li>
                <li><a href="https://infraredsaunaparts.com/cant-find-a-part.html">Can't find a part?</a></li>
            </ul>
        </div>
    </div>
</footer>
@show

@section('js')
<script type="text/javascript" src="{!! asset('js/jquery-3.3.1.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.form.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.inputmask.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=ReCaptchaCallback&render=explicit" async defer></script>
<script type="text/javascript">
    var recaptcha = [];
    var ReCaptchaCallback = function() {
        $('.g-recaptcha').each(function(){
            var el = $(this);
            recaptcha.push(grecaptcha.render(el.get(0), {'sitekey' : el.data("sitekey")}));
        });
    };
</script>
@show

<div class="modal" id="state_list">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select State</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <noindex>
                    <ul>
                        @foreach(request()->get('states') as $state)
                            @if(request()->route()->getName() == 'home')
                                <li><a rel="nofollow" href="{{ request()->secure() ? 'https' : 'http' }}://{{ request()->getHttpHost() }}/{{ $state->slug }}">{{ $state->name }}</a></li>
                            @else
                                <li><a rel="nofollow" href="{{ str_replace(request()->get('state')->slug, $state->slug, request()->fullUrl()) }}">{{ $state->name }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </noindex>
            </div>
        </div>
    </div>
</div>
</body>
</html>
