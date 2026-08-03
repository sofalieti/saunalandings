<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{rt($meta['title'])}}</title>
        <meta name="keywords" content="{{rt($meta['keywords'])}}" />
        <meta name="description" content="{{rt($meta['description'])}}"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="robots" content="index, follow" />
        <meta name="theme-color" content="#f2f2f4" />

        @if(!empty($meta['canonical_url']))
        <link rel="canonical" href="{{ $meta['canonical_url'] }}" />
        @endif

        @if(!empty($meta['schema_org_json']))
        <script type="application/ld+json">{!! $meta['schema_org_json'] !!}</script>
        @endif

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

        <link href="{!! asset('css/bootstrap.min.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset_version('fonts/inter/inter.css') !!}" type="text/css" rel="stylesheet" />
        <link href="{!! asset_version('css/parts_category_v2/app.css') !!}" type="text/css" rel="stylesheet" />
    </head>
    <body class="au-body">
        @php
            $auBrand = request()->get('brand');
            $auState = request()->get('state');
            $auNavItems = [
                'how_to_choose' => 'How to choose',
                'troubleshooting' => 'Troubleshooting',
                'repair' => 'Repair',
                'faq' => 'FAQ',
            ];
        @endphp

        <div class="au-topline">
            <div class="au-shell">
                <div class="au-topline__inner">
                    <span class="au-tag au-topline__badge">Fitment check</span>
                    <span>Send a photo of the old part — a specialist confirms the match before you order.</span>
                </div>
            </div>
        </div>

        <nav class="au-nav">
            <div class="au-shell">
                <div class="au-nav__pill">
                    <a class="au-nav__brand" href="/">
                        @include('parts_category_v2.partials.star')
                        <span>{{ $auBrand->domain }}</span>
                    </a>
                    <ul class="au-nav__links">
                        <li><a href="/">Home</a></li>
                        @foreach($auNavItems as $auSlug => $auLabel)
                            @if(page_template($auSlug))
                                <li><a href="{{ route('page_template_without_state', ['slug' => $auSlug]) }}">{{ $auLabel }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                    <a href="#" class="au-nav__state au-link" data-toggle="modal" data-target="#state_list">
                        <span class="au-label">State</span>
                        @if($auState->default)
                            {{ $auState->name }}
                        @else
                            USA, {{ $auState->name }}
                        @endif
                    </a>
                </div>
            </div>
        </nav>

        @yield('content')

        @include('parts_category_v2.partials.quote-modal')

        @section('footer')
        <footer class="au-footer">
            <div class="au-shell">
                <div class="au-footer__top">
                    <div>
                        <div class="au-footer__brand">
                            @include('parts_category_v2.partials.star')
                            <span>{{ $auBrand->domain }}</span>
                        </div>
                        <p class="au-footer__tagline">Replacement parts for infrared saunas, matched to your cabin by a specialist before you order.</p>
                    </div>
                    <div class="au-footer__phones">
                        <div><span>Toll free</span> <a href="tel:+18885597278">+1-888-559-PART (7278)</a></div>
                        <div><span>International</span> <a href="tel:+17187097278">+1-718-709-PART (7278)</a></div>
                        <div><span>Texting / SMS 24/7</span> <a href="tel:+13477461765">+1-347-746-1765</a></div>
                    </div>
                </div>

                <div class="au-footer__nav">
                    <div>
                        <h4>Build your sauna</h4>
                        <ul>
                            <li><a href="https://infraredsaunaparts.com/build-your-infrared-sauna.html">Build your sauna</a></li>
                            <li><a href="https://infraredsaunaparts.com/build-your-sauna-clone.html">Customize your Rain Cover</a></li>
                            <li><a href="https://infraredsaunaparts.com/do-it-yourself-infrared-sauna-kits-en.html">All DIY Infrared Sauna Kits</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Support</h4>
                        <ul>
                            <li><a href="https://infraredsaunaparts.com/support.html">Support</a></li>
                            <li><a href="https://infraredsaunaparts.com/f.a.q..html">F.A.Q.</a></li>
                            <li><a href="https://infraredsaunaparts.com/new-instructions.html">Instructions</a></li>
                            <li><a href="https://infraredsaunaparts.com/return-policy.html">Return Policy</a></li>
                            <li><a href="https://infraredsaunaparts.com/privacy-policy.html">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Main menu</h4>
                        <ul>
                            <li><a href="https://infraredsaunaparts.com/">Home Page</a></li>
                            <li><a href="https://infraredsaunaparts.com/reviews-en.html">Reviews</a></li>
                            <li><a href="https://infraredsaunaparts.com/become-a-dealer.html">Become a Dealer</a></li>
                            <li><a href="https://infraredsaunaparts.com//infrared-sauna-pars-drop-shipping-program.html">Drop Shipping Program</a></li>
                            <li><a href="https://infraredsaunaparts.com/index.php?dispatch=categories.catalog">Products</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4>Company</h4>
                        <ul>
                            <li><a href="https://infraredsaunaparts.com/about-us.html">About Us</a></li>
                            <li><a href="https://infraredsaunaparts.com/contact-infraredsaunaparts.com.html">Contact us</a></li>
                            <li><a href="https://infraredsaunaparts.com/support-claim.html">Trouble Ticket</a></li>
                            <li><a href="https://infraredsaunaparts.com/warranty.html">Warranty</a></li>
                            <li><a href="https://infraredsaunaparts.com/cant-find-a-part.html">Cant find a Part?</a></li>
                        </ul>
                    </div>
                </div>

                <div class="au-footer__bottom">
                    <div>© {{ date('Y') }} {{ $auBrand->domain }} — infrared sauna parts. Shipping across the USA and Canada.</div>
                    <div class="au-footer__social">
                        <a href="https://www.trustpilot.com/review/infraredsaunaparts.com">Trustpilot</a>
                        <a href="https://twitter.com/InfraSaunaParts">Twitter</a>
                        <a href="https://www.yelp.com/biz/infraredsaunaparts-san-diego">Yelp</a>
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
        <script type="text/javascript" src="{!! asset_version('js/app.js') !!}"></script>
        <script src="https://www.google.com/recaptcha/api.js?onload=ReCaptchaCallback&render=explicit" async defer></script>
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

        <div class="modal" id="state_list">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Select your state</h4>
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
    </body>
</html>
