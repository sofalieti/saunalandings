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

        {{-- Canonical URL --}}
        <link rel="canonical" href="{{ !empty($meta['canonical_url']) ? $meta['canonical_url'] : url()->current() }}" />

        {{-- OpenGraph --}}
        <meta property="og:type"        content="{{ $meta['og_type'] ?? 'website' }}" />
        <meta property="og:title"       content="{{ rt(!empty($meta['og_title']) ? $meta['og_title'] : $meta['title']) }}" />
        <meta property="og:description" content="{{ rt(!empty($meta['og_description']) ? $meta['og_description'] : $meta['description']) }}" />
        <meta property="og:url"         content="{{ url()->current() }}" />
        <meta property="og:site_name"   content="{{ request()->get('brand') ? request()->get('brand')->name : '' }}" />
        @if(!empty($meta['og_image']))
        <meta property="og:image"       content="{{ $meta['og_image'] }}" />
        @endif

        {{-- Twitter Card --}}
        <meta name="twitter:card"        content="{{ $meta['twitter_card'] ?? 'summary_large_image' }}" />
        <meta name="twitter:title"       content="{{ rt(!empty($meta['twitter_title']) ? $meta['twitter_title'] : $meta['title']) }}" />
        <meta name="twitter:description" content="{{ rt(!empty($meta['twitter_description']) ? $meta['twitter_description'] : $meta['description']) }}" />
        @if(!empty($meta['twitter_image']))
        <meta name="twitter:image" content="{{ $meta['twitter_image'] }}" />
        @endif

        {{-- Schema.org JSON-LD (custom block from admin) --}}
        @if(!empty($meta['schema_org_json']))
        <script type="application/ld+json">{!! $meta['schema_org_json'] !!}</script>
        @endif

        {{-- FAQPage schema --}}
        @if(!empty($meta['faq_items']) && $meta['faq_items']->count())
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "FAQPage",
          "mainEntity": [
            @foreach($meta['faq_items'] as $faqItem)
            {
              "@type": "Question",
              "name": "{{ e($faqItem->question) }}",
              "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ e($faqItem->answer) }}"
              }
            }{{ $loop->last ? '' : ',' }}
            @endforeach
          ]
        }
        </script>
        @endif

        {!! get_favicon() !!}
        @if(file_exists(public_path('mix-manifest.json')) && request()->get('layout') === 'parts_main')
        <link href="{!! mix('css/parts_main/bundle.css') !!}" type="text/css" rel="stylesheet" />
        @else
        <link href="{!! asset('css/bootstrap.min.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('fontawesome-free-5.8.1/css/all.min.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('fancybox-3/dist/jquery.fancybox.min.css') !!}" rel="stylesheet" />
        <link href="{!! asset('fonts/opensans/stylesheetfonts.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('css/'.request()->get('layout').'/app.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset('css/'.request()->get('layout').'/app-responsive.css') !!}" type="text/css" rel="stylesheet" />
        @endif
    </head>
    <body>
        <header>
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-3 col-12 text-center text-lg-left">
                        <a href="/"><img class="top-logo-img" src="{{text_block('BRAND_LOGO')}}"></a>
                    </div>
                    <div class="col-xl-6 col-lg-5 col-sm-8 col-6 d-none d-lg-flex">
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-lg-6 col-sm-6 col-12">

                                <div class="repair-your">
                                    <img src="/images/{{request()->get('layout')}}/repair-top.png">
                                    <span class="repair-your-text">FIX/REPAIR <br>YOUR SAUNA</span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-sm-6 col-12">
                                <div class="repair-your">
                                    <img src="/images/{{request()->get('layout')}}/trouble-top.png">
                                    <span class="repair-your-text">TROUBLESHOOT</span>
                                </div></div></div>
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
                                <a href="https://twitter.com/InfraSaunaParts"><img src="/images/{{request()->get('layout')}}/twittericon.png"></a>
                                <a href="https://www.yelp.com/biz/infraredsaunaparts-san-diego"><img class="sms-icon" src="/images/{{request()->get('layout')}}/yelpicon.png" ></a>
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
        @include('menu.menu')
        @yield('content')
        @section('footer')
        <footer>
            <div class="container big-footer">
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="logo-text">
                            <img class="bot-logo-img" src="/images/{{request()->get('layout')}}/footer-logo-text.png">
                        </div>
                    </div>
                    <div class="col-xl-5 offset-xl-2 col-6 offset-1">
                        <div class="footer-menu">
                            <span class="span-menu">Menu</span>
                            <ul>
                                @foreach(App\Menu::where(['active' => true, 'parent_id' => 0])->orderBy('position', 'ASC')->get() as $key => $menu )
                                <li><a href="{{rt($menu->link)}}">{{$menu->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="free-consult">
                            <a href="#" data-toggle="modal" data-target="#footer_free_consult">FREE CONSULT</a>
                        </div>
                    </div>
                </div> </div>
            <div class="container small-footer">

                <span class="small-footer-text">INFRARED SAUNA PARTS (C) 2019</span>
                <img class="bot-logo-img" src="/images/{{request()->get('layout')}}/tel-img-top.png">

            </div>
        </footer>
        @show
        @section('js')
        <script type="text/javascript" src="{!! asset('js/jquery-3.3.1.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/jquery.form.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/bootstrap.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('fancybox-3/dist/jquery.fancybox.min.js') !!}"></script>
        <script src="https://www.google.com/recaptcha/api.js?onload=ReCaptchaCallback&render=explicit" async defer></script>
        <script type="text/javascript" src="{!! asset('js/jquery.inputmask.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/'.request()->get('layout').'/app.js') !!}"></script>
        <script type="text/javascript">
            var recaptcha = [];

            function renderCaptcha(el) {
                if ($(el).find('iframe').length === 0) {
                    recaptcha.push(grecaptcha.render(el, {'sitekey': $(el).data("sitekey")}));
                }
            }

            // Called by the reCAPTCHA API once it is loaded.
            // All captchas are lazy:
            //   - inside .modal  → rendered on show.bs.modal
            //   - visible on page → rendered when scrolled into viewport (IntersectionObserver)
            var ReCaptchaCallback = function() {
                $('.g-recaptcha').each(function() {
                    if ($(this).closest('.modal').length > 0) {
                        return; // handled by show.bs.modal below
                    }
                    if ('IntersectionObserver' in window) {
                        var observer = new IntersectionObserver(function(entries, obs) {
                            entries.forEach(function(entry) {
                                if (entry.isIntersecting) {
                                    renderCaptcha(entry.target);
                                    obs.unobserve(entry.target);
                                }
                            });
                        }, { rootMargin: '0px 0px 200px 0px', threshold: 0 });
                        observer.observe(this);
                    } else {
                        renderCaptcha(this); // fallback for IE
                    }
                });
            };

            // Lazy init for modal captchas — fires on first open.
            $(document).on('show.bs.modal', function(e) {
                $(e.target).find('.g-recaptcha').each(function() {
                    renderCaptcha(this);
                });
            });
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
                        <li><a rel='nofollow' href='{{route('home_with_state', $state->slug)}}'>{{$state->name}}</a></li> 
                        
                        @if(request()->route()->getName() != 'page_template')
                        <li><a rel='nofollow' href='{{route('home_with_state', $state->slug)}}'>{{$state->name}}</a></li> 
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
<div class="modal" id="footer_free_consult">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Free Consult</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                @include('forms.form', ['form_id' => 5])
            </div>
        </div>
    </div>
</div>

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
<?php
/*<script type="text/javascript">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || 
{widgetcode:"c2afde165106622ddd4c5539f2d62c7442ba851385be9877e7c880cae2257b895bf09755fc7b88f0175ae9c36cded47c", values:{},ready:function(){}};
var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;
s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
</script>*/
?>