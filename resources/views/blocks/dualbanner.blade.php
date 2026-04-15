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
                        @if($left_block = $banners_content[0]['link'])
                        @if($this_category = $banners_content[0]['category'])


                        <a class="link-romb" href="{{route('category_template',['var_name' => $left_block->var_name,'category_slug' => $this_category])}}">CLICK FOR Details</a>
                        @else
                        @if($left_block->use_for_states)
                        <a class="link-romb" href="{{route_with_state('page_template', ['slug' => $left_block->var_name])}}">CLICK FOR Details</a>
                        @else
                        <a class="link-romb" href="{{route('page_template_without_state', ['slug' => $left_block->var_name])}}">CLICK FOR Details</a>
                        @endif
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

                        @if($right_block = $banners_content[1]['link'])
                        @if($this_category2 = $banners_content[1]['category'])
                        <a class="link-romb" href="{{route('category_template',['var_name' => $right_block->var_name,'category_slug' => $this_category2])}}">CLICK FOR Details</a>
                        @else
                        @if($right_block->use_for_states)
                        <a class="link-romb" href="{{route_with_state('page_template', ['slug' => $right_block->var_name])}}">CLICK FOR Details</a>
                        @else
                        <a class="link-romb" href="{{route('page_template_without_state', ['slug' => $right_block->var_name])}}">CLICK FOR Details</a>
                        @endif
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
