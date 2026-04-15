@extends('layouts.'.request()->get('layout'))
@section('content')



<div class='main-container leftheader'>
    <div class="container">
        <div class="thin-line"></div>
        <h1>{{rt("Fix/Repair !brand! infrared sauna in !state!")}}</h1>
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 ">
                <div class="row">

                    <div class="col-lg-12 inside-block-margin">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="Blockimg"><img src="/images/parts_main/Hang-on.png"></div>
                            </div>
                            <div class="col-12 col-lg-8">
                                {!! text_block('REPAIR_TEXT') !!}
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

    <div class='main-container model-categories leftheader '>
        <div class="container">

            <div class="thin-line"></div>
            <h1>{{rt("!brand! Infrared Sauna Parts Replacement")}}</h1>
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
    <div class="container">
        <div class=" col-12 col-lg-12 inside-block-margin">

            <div class="row">
                <div class="col-12 col-lg-2">
                    <div class="Blockimg"><img src="/images/parts_main/Hang-on.png"></div>
                </div>
                <div class="col-12 col-lg-10">
                    {!! text_block('BRAND_TEXT') !!}
                </div>
            </div>
        </div>

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