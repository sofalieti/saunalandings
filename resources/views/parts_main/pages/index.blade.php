@php
$dualbanner_content[0]['name'] = "Fix/Repair";
$dualbanner_content[0]['text'] = "If you already know the cause of the problem with your sauna please visit the fix and repair page!";
$dualbanner_content[0]['img_link'] = "/images/parts_main/fix-big.png";
$dualbanner_content[0]['link'] = page_template('repair');

$dualbanner_content[1]['name'] = "TROUBLESHOOT";
$dualbanner_content[1]['text'] = "If you are unsure about the cause of malfunction please visit the troubleshooting page to book a free consultation.";
$dualbanner_content[1]['img_link'] = "/images/parts_main/trouble-top-big.png";
$dualbanner_content[1]['link'] = page_template('troubleshooting');

$dualbanner_content[0]['category'] = false;
$dualbanner_content[1]['category'] = false;
@endphp

@extends('layouts.'.request()->get('layout'))
@section('content')

@include('blocks.topbanner', ['banners_content' => $dualbanner_content])

<div class='container main-container'>
    <h1>{{rt("!brand! infrared sauna parts")}}</h1>
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 ">
            <div class="row">
                <div class="col-12 inside-block-margin">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="Blockimg"><img src="/images/parts_main/Hang-on.png"></div>
                        </div>
                        <div class="col-12 col-lg-8">
                        {!! text_block('BRAND_TEXT') !!} 
                        </div>
                    </div>
                </div>

                <div class="col-12 inside-block-margin">

                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="Blockimg">
                                @if(!empty(request()->get('brand')->main_image))
                                <img src="/uploads/{{request()->get('brand')->main_image}}">
                                @else
                                <img src="/uploads/{{request()->get('brand')->site->default_brand_logo}}">
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            {!! text_block('BRAND_SHORT_TEXT') !!}
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
</div>




@include('blocks.delivery')
@include('blocks.dualbanner', ['banners_content' => $dualbanner_content])




@endsection
@section('footer')    
<div class="modal" id="hidden_main_form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Submit a quote</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">   
                @include('forms.form', ['form_id' => 2])                 
            </div>
        </div>
    </div>
</div>
@parent
@stop