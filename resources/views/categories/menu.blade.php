
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="mobil-nav">
            <span class="navbar-toggler-text"><span class="rad">10% OFF</span> FATHER’S DAY SALE</span>
            <img class="top-telef-img" src="/images/parts_main/tel-img-top.png">
        </div>

        <div class="collapse navbar-collapse" id="navbar1">
            <ul class="navbar-nav mr-auto top-menu">


                @foreach(App\Category::get_main_categories() as $key => $category )
                <li class="nav-item {{count($category->childs) ? "dropdown" : ""}}">
                    @if ($category->name == "Catalogue")
                    <a class="nav-link {{count($category->childs) ? "dropdown" : ""}} {{@$category_slug == $category->slug ? 'active' : ''}}" href="{{route('page_template_without_state', ['slug' => "replacement"])}}">
                        {{$category->name}}
                    </a>
                    @else
                    <a class="nav-link {{count($category->childs) ? "dropdown" : ""}} {{@$category_slug == $category->slug ? 'active' : ''}}" href="{{route('category', ['slug' => $category->slug])}}">
                        {{$category->name}}
                    </a>
                    @endif
                     

                    @if(count($category->childs))
                    <div class="dropdown-menu menu-item-{{$key}}" aria-labelledby="navbarDropdown">
                        @foreach($category->childs as $child)
                        <a class="dropdown-item drop" href="{{route('category', ['slug' => $child->slug])}}">{{$child->name}}</a>
                        @endforeach
                    </div>
                    @endif

                </li>
                @endforeach
                <li class="nav-item"> <a  class="nav-link" href="{{route_with_state('page_template', ['slug' => "repair"])}}">Repair/Fix </a> </li>
                <li class="nav-item"> <a  class="nav-link" href="{{route('page_template_without_state', ['slug' => "troubleshooting"])}}"> TroubleShoot </a> </li>
                <li class="nav-item"> <a  class="nav-link" href="{{route('page_template_without_state', ['slug' => "models"])}}"> Models </a> </li>
                <li class="nav-item"> <a  class="nav-link" href="{{route('page_template_without_state', ['slug' => "contact_us"])}}"> Contact Us </a></li>

            </ul>
        </div>
    </div>
</nav>