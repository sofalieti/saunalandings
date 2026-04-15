@extends('layouts.'.request()->get('layout'))
@section('content')
<div class='container leftheader'>

    <div class="thin-line"></div>
    <h1>  {{rt("!brand!") }} {{$category->type}} TROUBLESHOOT </h1>
    <div class="row ">
        <div class="col-md-6">
            <div class="main-description_repair">
                <div class="main-description_repair-top standartmargin">
                    {!! text_block('TROUBLESHOOT_CATEGORY') !!}
                </div>
                <div class="main-description_repair-bot standartmargin-bot">
                    {!! text_block('BRAND_SHORT_TEXT') !!}
                </div>
                <div>
                    {{$category->text}}
                </div>
            </div> 
        </div>
        <div class="col-md-6">
            <div class="right-form">
                @include('forms.form', ['form_id' => 2])
            </div>
        </div>
    </div>
    @if($template->show_articles && count($articles))
    <div class="article-list">
        <div class="thin-line"></div>
        <h3>Articles</h3>
        <div class="row">
            @foreach($articles as $article)
            <div class="col-md-3">
                <a href="{{route('article', $article->slug)}}" class="item">{{$article->name}}</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>



<div class="question-block">
    <div class="container text-center">
        <h2>HAVE QUESTIONS?</h2>
        <h3>CLICK HERE FOR A FREE CONSULTATION!</h3>
        <a class="btn btn-lg btn-success" href="#" data-toggle="modal" data-target="#question">Submit a quote</a>
    </div>
</div>
@endsection
@section('footer')    
<div class="modal" id="question">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Submit a quote</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">   
                @include('forms.form', ['form_id' => 3])                    
            </div>
        </div>
    </div>
</div>
@parent
@stop