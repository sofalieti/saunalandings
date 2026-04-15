
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
                <li class="nav-item"> <a  class="nav-link" href="/">Home</a> </li>
                <li class="nav-item"> <a  class="nav-link" href="{{route_with_state('page_template', ['slug' => "repair"])}}">Repair/Fix </a> </li>
                <li class="nav-item"> <a  class="nav-link" href="{{route('page_template_without_state', ['slug' => "troubleshooting"])}}"> TroubleShoot </a> </li>
            </ul>
        </div>
    </div>
</nav>