<div class="delivery-layer">
    <div class="container ">
        <div class="row">
            <div class="col-4 col-xl-2  col-lg-3 col-md-3 d-none d-md-flex">
                <img src="/images/parts_main/delivery_machine.png" class="img-fluid">
            </div>
            <div class="col-12 col-xl-4 col-lg-4 col-md-5 ">
                <h4>{{request()->get('state')->name}} Delivery</h4>
                <p><span>
                        Our team offer fast delivery to all USA states including
                        {{request()->get('state')->name}}.  team offer fast delivery to all USA states including {{request()->get('state')->name}}. 
                    </span>
                    Delivery time: 5 Days<br>
                    Free delivery on all orders above $300 
                </p>


            </div>
            <div class="offset-lg-1 offset-xl-1 col-xl-4 col-lg-4 col-md-4  align-self-center">

                <a class="raw delivery_button" href="#">COUNT YOUR SHIPPING PRICE</a>

            </div>
        </div>

    </div>
</div>
      
