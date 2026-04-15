<nav class="navbar navbar-expand-lg top-menu-grid">
    <div class="container position-relative">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbar1">
            <ul class="navbar-nav mr-auto top-menu">
                @foreach(App\Menu::where(['active' => true, 'parent_id' => 0])->orderBy('position', 'ASC')->get() as $key => $menu )
                <li class="nav-item {{count($menu->childs) || count($menu->category) ? "dropdown" : ""}}">
                    <a class="nav-link {{"/".request()->path() == rt($menu->link) ? 'active' : ''}}  {{count($menu->childs) || count($menu->category) ? "dropdown" : ""}}" href="{{rt($menu->link)}}">
                        {{$menu->name}}
                    </a>
                    @if(count($menu->childs) || count($menu->category))
                    <button class="open-sub-menu d-block d-lg-none"><i class="fas fa-chevron-right"></i></button>
                    @endif
                    @if(count($menu->category) && count($menu->category->childs))
                    <div class="dropdown-menu menu-item-{{$key}}" aria-labelledby="navbarDropdown">
                        @foreach($menu->category->childs as $category)
                        <a class="dropdown-item drop" href="{{route('category', ['slug' => $category->slug])}}">{{$category->name}}</a>
                        @endforeach
                    </div>
                    @elseif(count($menu->childs))
                    <div class="dropdown-menu menu-item-{{$key}}" aria-labelledby="navbarDropdown">
                        @foreach($menu->childs as $child_menu)
                        <a class="dropdown-item drop" href="{{rt($child_menu->link)}}">{{$child_menu->name}}</a>
                        @endforeach
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        <div class="mobile-right-menu d-block d-lg-none">
            <a href="/troubleshooting"><i class="far fa-comment"></i></a>
            <a href="{{route_with_state('page_template', ['slug' => 'repair'])}}"><i class="fas fa-tools"></i></a>
            <a href="#" class="m-state" data-toggle="modal" data-target="#state_list">
                <i class="fas fa-map-marker-alt"></i>
                @if(request()->get('state')->default)
                {{request()->get('state')->name}}
                @else
                USA, {{request()->get('state')->name}}
                @endif
            </a>
        </div>
    </div>
</nav>