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
    <link href="/images/{{request()->get('layout')}}/favicon.png" rel="shortcut icon" type="image/png" />
    <meta name="robots" content="index, follow" />
    <link href="{!! asset('css/bootstrap.min.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('fonts/opensans/stylesheetfonts.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('css/'.request()->get('layout').'/app.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('css/'.request()->get('layout').'/app-responsive.css') !!}" type="text/css" rel="stylesheet" />
</head>
<body>
<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 logo-block col">
                <a href="/"><img src="/images/enlightensauna/logo.jpg" class="w-100"></a>
            </div>
            <div class="col-lg-6 col-auto">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav">
                            @foreach(request()->get('brand')->categories as $parent_category)
                            @foreach($parent_category->childs as $key => $category)
                            <li class="nav-item">
                                <a class="nav-link {{request()->slug == $category->slug || (empty(request()->slug) && $key == 0) ? 'active' : ''}}" href="{{$key == 0 ? "/" : route('category', $category->slug)}}">{{$category->name}}</a>
                            </li>
                            @endforeach
                            @endforeach
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-lg-3 text-right phone-block d-none d-lg-block">
                <div class="d-inline-block text-left">
                    <span>Toll free</span><br/>
                    <a href="tel: 888-87-SAUNA (72862)">888-87-SAUNA (72862)</a>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')

@section('footer')
<footer>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
                <div class="copyright">2001-<?=date('Y')?> Enlighten Infrared Saunas</div>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <img src="/images/enlightensauna/payments.jpg"/>
            </div>
        </div>
    </div>
</footer>
@show
<script type="text/javascript" src="{!! asset('js/jquery-3.3.1.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.form.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.inputmask.min.js') !!}"></script>
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
</body>
</html>