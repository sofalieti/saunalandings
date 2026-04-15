@extends('layouts.'.request()->get('layout'))
@section('content')  

<div class='container main-container leftheader'>
    <div class="thin-line"></div>
    <h1>{{rt("!brand!" )}} {{$model->name}}</h1>
    <div class="row">

        <div class="col-12">


            <div class="single_model row">
                <div class="col-sm-3">
                    <div class="thin-line-2"></div>
                    <img  src="{{$model->ImageThumb}}" class="img-fluid">
                </div>
                <div class="col-sm-9 model_categories">
                    <div class="thin-line-2"></div>
                    <span>{{ $model->description  }}.</span><br><br>
                    <br><br>
                    <div class="row model-categories">
                        <h3>Categories</h3>
                        @foreach ($category->childs as $key => $child_category) 
                        @if ($child_category)  
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4"><a href="{{route('model_category', ['category_slug' => $child_category->slug,'slug' => $slug])}}">{{$child_category->name}}</a></div>

                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
</div>  
@include('blocks.delivery')


<div class='romb-fon '>
    <div class='container'>
        <div class="row align-items-center">
            @if($repair = page_template('repair'))
            <div class="col-12 col-md-6 home-bot_block">
                <div class="row align-items-center">
                    <div class="col-4">
                        <img src="/images/parts_main/fix-big.png">
                    </div>
                    <div class="col-8 col-lg-6">
                        <span class="home-bot-leftblock_span-title">Fix/Repair</span>
                        <span class="home-bot-leftblock_span-main">Describe your problem. And our specialist will contact you soon!</span>
                        @if($repair->use_for_states)
                        <a class="link-romb" href="{{route_with_state('page_template', ['slug' => $repair->var_name])}}">CLICK FOR Details</a>
                        @else
                        <a class="link-romb" href="{{route('page_template_without_state', ['slug' => $repair->var_name])}}">CLICK FOR Details</a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @if($troubleshooting = model_template('troubleshooting'))
            <div class="col-12  col-md-6 home-bot_block">
                <div class="row align-items-center">
                    <div class="col-4">
                        <img src="/images/parts_main/trouble-top-big.png">
                    </div>
                    <div class="col-8  col-lg-6">
                        <span class="home-bot-leftblock_span-title">TROUBLESHOOT</span>
                        <span class="home-bot-leftblock_span-main">Describe your problem. And our specialist will contact you soon!</span>
                        <a class="link-romb" href="{{route('model_template', ['model_slug' => $model->slug, 'var_name' => $troubleshooting->var_name])}}">CLICK FOR Details</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>




@endsection

