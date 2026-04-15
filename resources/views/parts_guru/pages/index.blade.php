
@extends('layouts.'.request()->get('layout'))
<div class='background'>
@section('content')

<div class='container standartmargin-top standartmargin-left'>

    <div class="row">


                {!! text_block('main_page_text_block') !!}



    </div>
</div>
<div class="question-block">
    <div class="container text-center">
        <h2>HAVE QUESTIONS?</h2>
        <h3>CLICK HERE FOR A FREE CONSULTATION!</h3>
        <a class="btn btn-lg btn-success" href="#" data-toggle="modal" data-target="#question">Submit a quote</a>
    </div>

</div>
<div class='romb-fon standartmargin-bot'>
    <div class='container'>
        <div class="rhombus-block">
            @if($repair = page_template('repair'))
            <div class="rhombus-block1">
                <a class="link-romb" href="{{route_with_state('page_template', ['slug' => $repair->var_name])}}">CLICK FOR Details</a>
                <img src="/images/parts_main/leftimg.png">
                <div class="rhombus-in">
                    <span class="title-romb">CHOROMOTHERAPY <span class="title-romb1">FIX/REPAIR</span></span>
                    <span class="main-romb">Describe your problem. And our specialist will contact you soon!</span>
                </div>
            </div>
            @endif
            @if($troubleshooting = page_template('troubleshooting'))
            <div class="rhombus-block2">
                <a class="link-romb" href="{{route_with_state('page_template', ['slug' => $troubleshooting->var_name])}}">CLICK FOR Details</a>
                <img src="/images/parts_main/rightimg.png">
                <div class="rhombus-in">
                    <span class="title-romb">
                        CHOROMOTHERAPY <span class="title-romb1">TROUBLESHOOT</span></span>
                        <span class="main-romb">Just make a photo of broken detail, and we will solve your problem</span>
                </div>
            </div>
            @endif
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
    </div></div>
    @parent
@stop