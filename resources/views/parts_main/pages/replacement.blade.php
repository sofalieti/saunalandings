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

<div class='container main-container leftheader '>
    <div class="model-categories">
    <div class="thin-line"></div>
    <h1>{{rt("!brand! Infrared Sauna Parts Replacement")}}</h1>
    {!! text_block('CATALOG_TEXT') !!}<br><br>
    
    
    <div class="row inside-block-margin categories-list ">
        @foreach(App\Category::get_main_categories() as $key => $category )

        @foreach($category->childs as $number => $child_category)
        @php $my_number = str_pad($number+1, 2, "0", STR_PAD_LEFT);  @endphp
        @if ($child_category)  
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3"><a href="{{route('category', ['slug' => $child_category->slug])}}"><span>{{$my_number}}|</span>{{$child_category->name}}</a></div>

        @endif
        @endforeach
        @endforeach

    </div>
    </div>
</div>





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