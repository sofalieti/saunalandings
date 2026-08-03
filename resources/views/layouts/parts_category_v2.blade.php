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
            <div class="au-topline__inner">
                <span class="au-tag au-topline__badge">NEW</span>
                <span>Send a photo of the old part — a specialist confirms the match before you order.</span>
            </div>
        </div>

        <nav class="au-nav" aria-label="Primary">
            <div class="au-nav__pill">
                <a class="au-nav__brand" href="/">
                    @include('parts_category_v2.partials.star')
                    <span>{{ $auBrand->domain }}</span>
                </a>
                <ul class="au-nav__links">
                    <li><a class="au-ghost" href="/">Home</a></li>
                    @foreach($auNavItems as $auSlug => $auLabel)
                        @if(page_template($auSlug))
                            <li><a class="au-ghost" href="{{ route('page_template_without_state', ['slug' => $auSlug]) }}">{{ $auLabel }}</a></li>
                        @endif
                    @endforeach
                    <li>
                        <a class="au-ghost" href="#" data-toggle="modal" data-target="#state_list">
                            @if($auState->default)
                                {{ $auState->name }}
                            @else
                                {{ $auState->name }}
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        @yield('content')

        @include('parts_category_v2.partials.quote-modal')

        @section('footer')
        <footer class="au-footer">
            <div class="au-shell">
                <div class="au-footer__brand">
                    @include('parts_category_v2.partials.star')
                    <span>{{ $auBrand->domain }}</span>
                </div>
                <p class="au-footer__tagline">Replacement parts for infrared saunas, matched to your cabin by a specialist.</p>
                <ul class="au-footer__links">
                    <li><a href="/">Home</a></li>
                    @foreach($auNavItems as $auSlug => $auLabel)
                        @if(page_template($auSlug))
                            <li><a href="{{ route('page_template_without_state', ['slug' => $auSlug]) }}">{{ $auLabel }}</a></li>
                        @endif
                    @endforeach
                    <li><a href="tel:+18885597278">+1-888-559-PART</a></li>
                </ul>
                <div class="au-footer__bottom">
                    <span>© {{ date('Y') }} {{ $auBrand->domain }}</span>
                    <span class="au-footer__social">
                        <a href="https://www.trustpilot.com/review/infraredsaunaparts.com">Trustpilot</a>
                        <a href="https://twitter.com/InfraSaunaParts">Twitter</a>
                        <a href="https://www.yelp.com/biz/infraredsaunaparts-san-diego">Yelp</a>
                    </span>
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
