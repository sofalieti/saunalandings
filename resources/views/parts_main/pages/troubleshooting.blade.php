@extends('layouts.'.request()->get('layout'))
@section('content')

<div class='container main-container leftheader'>
    <div class="thin-line"></div>
    <h1>{{rt('!brand! INFRARED SAUNA TROUBLESHOOTING')}}</h1>
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 ">
            <div class="row">

                <div class="col-lg-12 inside-block-margin">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="Blockimg"><img src="/images/parts_main/Hang-on.png"></div>
                        </div>
                        <div class="col-12 col-lg-8">
                            {!! text_block('TROUBLESHOOT_TEXT') !!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 inside-block-margin">

                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="Blockimg"><img src="/images/parts_main/Hang-on.png"></div>
                        </div>
                        <div class="col-12 col-lg-8">
                          
                   
                            
                            {!! str_limit(text_block('BRAND_TEXT'), 400) !!}
                        </div>
                    </div>
                </div>
            </div>





        </div>




        <div class="d-block d-md-none d-lg-block  col-12 col-md-4 col-lg-6">
            <div class="right-form">
                @include('forms.form', ['form_id' => 2])                     
            </div>
        </div>
        <div class="d-none d-md-block d-lg-none  col-12 col-md-4 col-lg-6 ">
            <a  href="#" data-toggle="modal" data-target="#hidden_main_form">
                <div class="right-form right-form-link">
                    <img src="/images/parts_main/freeconsult.png">
                    <b>Free Consult</b><br>
                    Click for details
                </div>
            </a>
        </div>

    </div>
    @if($template->show_articles && count($categories))
    <div class="article-list">
        <div class="thin-line"></div>
        <h3>Articles</h3>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3">
                <a href="{{route('category_template',['var_name' => 'troubleshooting','category_slug' => $category->slug])}}" class="item">{{$category->name}}</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif


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