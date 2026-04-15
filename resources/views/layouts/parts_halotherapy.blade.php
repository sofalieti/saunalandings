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
        {!! get_favicon() !!}
        <link href="{!! asset('css/bootstrap.min.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('fontawesome-free-5.8.1/css/all.min.css') !!}" type="text/css" rel="stylesheet" /> 
        <link href="{!! asset('fancybox-3/dist/jquery.fancybox.min.css') !!}" rel="stylesheet" />
        <link href="{!! asset('fonts/opensans/stylesheetfonts.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css') !!}" rel="stylesheet" />
        <link href="{!! asset('OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') !!}" rel="stylesheet" />
        <link href="{!! asset('css/'.request()->get('layout').'/app.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('css/'.request()->get('layout').'/app-responsive.css') !!}" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <header>
            <div class="container">
                <div class="row align-items-center py-3">
                    <div class="col-12 col-lg-2 text-center text-lg-left mb-md-3 mb-lg-0">
                        <a href="/"><img class="top-logo-img" src="{{get_logo()}}"></a>
                    </div>
                    <div class="col-3 col-lg d-none d-md-block text-center phone-block">
                        <div class="d-inline-block text-left">
                            <span>Toll Free:</span>
                            <a href="tel: +1-888-559-PART (7278)" class="text-nowrap">+1-888-559-PART (7278)</a>
                        </div>
                    </div>
                    <div class="col-3 col-lg d-none d-md-block text-center phone-block">
                        <div class="d-inline-block text-left">
                            <span>International:</span>
                            <a href="tel: +1-718-709-PART (7278)" class="text-nowrap">+1-718-709-PART (7278)</a>
                        </div>
                    </div>
                    <div class="col-3 col-lg d-none d-md-block text-center phone-block">
                        <div class="d-inline-block text-left">
                            <span>24/7 Texting/SMS:</span>
                            <a href="tel: +1-347-746-1765" class="text-nowrap">+1-347-746-1765</a>                            
                        </div>
                    </div>
                    <div class="col-3 col-lg-2 d-none d-md-block s-links-block">
                        <div class="text-right">
                            <a href="https://www.facebook.com/infraredsaunaparts/"><img width="32" src="/images/{{request()->get('layout')}}/fb_icon.svg"></a>
                            <a href="https://twitter.com/InfraSaunaParts"><img width="32" src="/images/{{request()->get('layout')}}/twitter_icon.svg"></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        @yield('content')
        @section('footer')
        <footer class="pt-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-2 text-center text-lg-left my-2 my-lg-0">
                        <a href="/"><img class="top-logo-img" src="{{get_logo()}}"></a>
                    </div>
                    <div class="col-12 col-lg text-center phone-block my-2 my-lg-0">
                        <div class="d-inline-block text-center text-lg-left">
                            <span>Toll Free:</span>
                            <a href="tel: +1-888-559-PART (7278)">+1-888-559-PART (7278)</a>
                        </div>
                    </div>
                    <div class="col-12 col-lg text-center phone-block my-2 my-lg-0">
                        <div class="d-inline-block text-center text-lg-left">
                            <span>International:</span>
                            <a href="tel: +1-718-709-PART (7278)">+1-718-709-PART (7278)</a>
                        </div>
                    </div>
                    <div class="col-12 col-lg text-center phone-block my-2 my-lg-0">
                        <div class="d-inline-block text-center text-lg-left">
                            <span>24/7 Texting/SMS:</span>
                            <a href="tel: +1-347-746-1765">+1-347-746-1765</a>                            
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 s-links-block my-2 my-lg-0">
                        <div class="text-center text-lg-right">
                            <a href="https://www.facebook.com/infraredsaunaparts/"><img width="32" src="/images/{{request()->get('layout')}}/fb_icon_w.svg"></a>
                            <a href="https://twitter.com/InfraSaunaParts"><img width="32" src="/images/{{request()->get('layout')}}/twitter_icon_w.svg"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                © Copyright {{date('Y')}}
            </div>
        </footer>
        @show
        @section('js')
        <script type="text/javascript" src="{!! asset('js/jquery-3.3.1.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/jquery.form.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/bootstrap.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('fancybox-3/dist/jquery.fancybox.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('OwlCarousel2-2.3.4/dist/owl.carousel.min.js') !!}"></script>
        <script src="https://www.google.com/recaptcha/api.js?onload=ReCaptchaCallback&render=explicit" async defer></script>
        <script type="text/javascript" src="{!! asset('js/jquery.inputmask.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/'.request()->get('layout').'/app.js') !!}"></script>
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

@if(!empty(request()->get('brand')->site->google_analytics_id))
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{request()->get('brand')->site->google_analytics_id}}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{request()->get('brand')->site->google_analytics_id}}');
</script>
@endif