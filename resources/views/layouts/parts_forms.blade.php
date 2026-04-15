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
    <link href="{!! asset('fonts/opensans/stylesheetfonts.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('css/parts_main/app-responsive.css') !!}" type="text/css" rel="stylesheet" />
    <link href="{!! asset('css/'.request()->get('layout').'/app.css') !!}" type="text/css" rel="stylesheet" />
</head>
<body>

@yield('content')

@section('footer')

@show
<script type="text/javascript" src="{!! asset('js/jquery-3.3.1.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.form.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/bootstrap.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/jquery.inputmask.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
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