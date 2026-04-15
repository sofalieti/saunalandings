<div class='romb-fon '>
    <div class='container'>
        <div class="row align-items-center">
            <div class="col-12 col-md-6 home-bot_block">
                <div class="row align-items-center">
                    <div class="col-4">
                        <img src="{{$banners_content[0]['img_link']}}">
                    </div>
                    <div class="col-8 col-lg-6">
                        <span class="home-bot-leftblock_span-title">{{$banners_content[0]['name']}}</span>
                        <span class="home-bot-leftblock_span-main">{{$banners_content[0]['text']}}</span>
                        @if($left_block = $dualbanner_content[0]['link'])
                        @if($left_block->use_for_states)
                        <a class="link-romb" href="{{route_with_state('page_template', ['slug' => $left_block->var_name])}}">CLICK FOR Details</a>
                        @else
                        <a class="link-romb" href="{{route('page_template_without_state', ['slug' => $left_block->var_name])}}">CLICK FOR Details</a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12  col-md-6 home-bot_block">
                <div class="row align-items-center">
                    <div class="col-4">
                        <img src="{{$banners_content[1]['img_link']}}">
                    </div>
                    <div class="col-8  col-lg-6">
                        <span class="home-bot-leftblock_span-title">{{$banners_content[1]['name']}}</span>
                        <span class="home-bot-leftblock_span-main">{{$banners_content[1]['text']}}</span>

                        @if($right_block = $dualbanner_content[1]['link'])
                        @if($right_block->use_for_states)
                        <a class="link-romb" href="{{route_with_state('page_template', ['slug' => $right_block->var_name])}}">CLICK FOR Details</a>
                        @else
                        <a class="link-romb" href="{{route('page_template_without_state', ['slug' => $right_block->var_name])}}">CLICK FOR Details</a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
