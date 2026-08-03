<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{rt($meta['title'])}}</title>
        <meta name="keywords" content="{{rt($meta['keywords'])}}" />
        <meta name="description" content="{{rt($meta['description'])}}"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="index, follow" />
        <link href="{!! asset('css/bootstrap.min.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('fontawesome-free-5.8.1/css/all.min.css') !!}" type="text/css" rel="stylesheet" /> 
        <link href="{!! asset('css/parts_main/app.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('css/parts_category/app.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('fonts/opensans/stylesheetfonts.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('css/parts_main/app-responsive.css') !!}" type="text/css" rel="stylesheet" />


    </head>
    <body>
        <header>
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-3 col-6 text-center text-lg-left">
                        <a href="/"><img src="/images/parts_category/logo.svg"></a>
                    </div>
                    <div class="col-xl-6 col-lg-5 col-sm-8 col-6">
                        <div class="geo-states">
                            <div class="l-title">Select your state:</div>
                            <a href="#" class="cm-dialog-opener cm-dialog-auto-size current-state" data-toggle="modal" data-target="#state_list">
                                @if(request()->get('state')->default)
                                {{request()->get('state')->name}}
                                @else
                                USA, {{request()->get('state')->name}}
                                @endif
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4">

                        <div class="top-phones-main">
                            <div class="s-links">
                                <a href="https://www.trustpilot.com/review/infraredsaunaparts.com"><img src="/images/trustpilot_icon.svg" alt="Trustpilot"></a>
                                <a href="https://twitter.com/InfraSaunaParts"><img src="/images/parts_main/twittericon.png"></a>
                                <a href="https://www.yelp.com/biz/infraredsaunaparts-san-diego"><img class="sms-icon" src="/images/parts_main/yelpicon.png" ></a>
                            </div>
                            <div class="top-phones">
                                <div>
                                    <span>Toll Free:</span>
                                    <span>+1-888-559-PART (7278)</span>
                                </div>
                                <div>

                                    <span>International:</span>
                                    <span>+1-718-709-PART (7278)</span>
                                </div>
                                <div>
                                    <span>24/7 Texting/SMS:</span>
                                    <span>+1-347-746-1765</span>                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        {{--@include('categories.menu_category')--}}
        @yield('content')
        <div class="google-map"><iframe width="100%" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed"></iframe></div>
        @section('footer')
        <footer>
            <div class="container">    
                <div class="row">
                    <div class="col-md-3">
                        <h4>Build your sauna</h4>
                        <ul>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/build-your-infrared-sauna.html">Build your sauna</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/build-your-sauna-clone.html">Customize your Rain Cover</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/do-it-yourself-infrared-sauna-kits-en.html">All DIY Infrared Sauna Kits</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h4>Support</h4>
                        <ul>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/support.html">Support</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/f.a.q..html">F.A.Q.</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/new-instructions.html">Instructions</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/return-policy.html">Return Policy</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/privacy-policy.html">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4>Main Menu</h4>
                        <ul>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/">Home Page</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/reviews-en.html">Reviews</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/become-a-dealer.html">Become a Dealer</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com//infrared-sauna-pars-drop-shipping-program.html">Drop Shipping Program</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h4 class="s-empty">&nbsp;</h4>
                        <ul>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/about-us.html">About Us</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/index.php?dispatch=categories.catalog">Products</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/cant-find-a-part.html">Cant find a Part?</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/recycle.html">Recycle with Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h4 class="s-empty">&nbsp;</h4>
                        <ul>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/contact-infraredsaunaparts.com.html">Contact us</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/support-claim.html">Trouble Ticket</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/warranty.html">Warranty</a></li>
                            <li><a class="ty-text-links__a" href="https://infraredsaunaparts.com/virtual-service-call.html">Virtual Service Call</a></li>
                        </ul>
                    </div>
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
        <script type="text/javascript" src="{!! asset('js/parts_main/app.js') !!}"></script>
        <script type="text/javascript">
            var recaptcha = [];
            var ReCaptchaCallback = function() {
                $('.g-recaptcha').each(function(key, obj){
                    var el = $(this);
                    recaptcha.push(grecaptcha.render(el.get(0), {'sitekey' : el.data("sitekey")}));
                });
            };
        </script>
        @show
    </body>
</html>
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
                        <li><a rel='nofollow' href='{{request()->secure() ? 'https' : 'http'}}://{{request()->getHttpHost()}}/{{$state->slug}}'>{{$state->name}}</a></li> 
                        @else
                        <li><a rel='nofollow' href='{{str_replace(request()->get('state')->slug, $state->slug, request()->fullUrl())}}'>{{$state->name}}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </noindex>
            </div>
        </div>
    </div>
</div>