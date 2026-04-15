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
    <link href="{!! asset('css/'.request()->get('layout').'/app.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('css/parts_main/app.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('fonts/opensans/stylesheetfonts.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('css/parts_main/app-responsive.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('css/'.request()->get('layout').'/app-responsive.css') !!}" type="text/css" rel="stylesheet" />
</head>
<body>
<header>
    <div class="container">
        <div class="row header-block">

            <div class="col-lg-3 align-self-center logo-block">
                <a href="/"><img src="/images/parts_main/logo11.png"></a>
            </div>
            <div class="col-xl-6 col-lg-5 align-self-center text-center">
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
            <div class="col-xl-3 col-lg-4 align-self-center telefon-block">

                <div class="top-phones">
                    <div>
                        <span>Toll Free:</span>
                        <span>888-87 SAUNA (72862)</span>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container container-top_menu">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
            	<span class="navbar-toggler-icon"></span>
        <span class="top-menu_text">MENU</span>
          	</button>

        <div class="collapse navbar-collapse" id="navbar1">
            	<ul class="navbar-nav mr-auto top-menu">



            <li class="nav-item">
                <a class="nav-link" href="#">
                    2-PERSON
                </a>
            </li>

          <li class="nav-item">
                <a class="nav-link" href="#">
                    3-PERSON
                </a>
            </li>

          <li class="nav-item">
                <a class="nav-link" href="#">
                    4-PERSON
                </a>
            </li>

          <li class="nav-item">
                <a class="nav-link" href="#">
                     5-PERSON
                </a>
            </li>

          <li class="nav-item">
                <a class="nav-link" href="#">
                    Corner Saunas
                </a>
            </li>



        </ul>
        </div>
        </div>
        </nav>
    </div>
    </div>
</header>

@yield('content')
<div class="google-map"><iframe width="100%" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed"></iframe></div>
@section('footer')
<footer>
    <div class="container">    
        <div class="row">
            <div class="col-md-3">
                <h4>SAUNA LINES</h4>
                 <ul>
                                   <li><a class="ty-text-links__a" href="https://enlightensauna.com/outdoor/sierra-golden.html">Sierra Outdoor Infrared Sauna</a></li>
                                   <li><a class="ty-text-links__a" href="https://enlightensauna.com/outdoor/rustic-vitality.html">Rustic Outdoor Infrared Sauna</a></li>
                                   <li><a class="ty-text-links__a" href="https://enlightensauna.com/indoor/sierra-golden.html">Golden Indoor Infrared Sauna</a></li>
                                   <li><a class="ty-text-links__a" href="https://enlightensauna.com/indoor/rustic-vitality.html">Vitality Indoor Infrared Sauna</a></li>
                               </ul>
            </div>
            <div class="col-md-2">
            <h4>Menu</h4>
 <ul>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/about-guru.html">About us</a></li>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/contact-us.html">Contact Us</a></li>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/sauna-reviews.html">Customer Testimonials</a></li>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/enlighten-sauna-diference.html">Why Enlighten</a></li>
                </ul>
            </div>

            <div class="col-md-2">

                <ul>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/health-benefits.html">Health Benefits</a></li>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/become-a-dealer.html">Become a Dealer</a></li>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/f.a.q..html">F.A.Q.</a></li>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/return-policy.html">Return Policy</a></li>
                </ul>
            </div>
            <div class="col-md-2">

                <ul>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/warranty.html">Warranty</a></li>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/shipping-and-handling.html">Shipping & Handling</a></li>
                    <li><a class="ty-text-links__a" href="https://enlightensauna.com/privacy-policy-en-2.html">Privacy Policy</a></li>

                </ul>
            </div>
        </div>
    </div>
</footer>
@show
<script type="text/javascript" src="{!! asset('js/jquery-3.3.1.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.form.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.inputmask.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/parts_main/app.js') !!}"></script>
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