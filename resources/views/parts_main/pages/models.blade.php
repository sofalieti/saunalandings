@extends('layouts.'.request()->get('layout'))
@section('content')
<div class='container  leftheader'>
    <div class="thin-line"></div>
    <h1>{{rt('!brand! Models')}}</h1>

    <div class="row ">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="row"> 
                        
                     
                        @foreach (\App\ModelLine::get_active_models()->get() as $key => $my_model) 
                        <div class="col-12 col-md-6 col-lg-3 inside-block-margin">
                            <a href="{{route('model', $my_model->slug)}}">
                                <div class="model_line">
                                    <h4>{{$my_model->name}}</h4>
                                    <img src="/uploads/{{$my_model->image}}">
                                    <span>{{ str_limit($my_model->description, $limit = 70, $end = '...') }}.</span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
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