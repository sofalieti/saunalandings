@extends('layouts.'.request()->get('layout'))
@section('content')
<div class="container py-5">
    <h1>Order Now</h1>
    <form class="pay-form" method="post" action="/send_pay_form">
        {{ csrf_field() }}
        <input type = "hidden" name = "LinkId" value ="b48d2881-13b4-489e-b258-3cb4c2e0c69d" />
        <div class="form-success"></div>
        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="required">First name</label>
                <input type="text" name="first_name" class="form-control"/>
            </div>
            <div class="col-md-6 mb-2">
                <label class="required">Last name</label>
                <input type="text" name="last_name" class="form-control"/>
            </div>
            <div class="col-md-6 mb-2">
                <label class="required">E-mail</label>
                <input type="text" name="email" class="form-control"/>
            </div>
            <div class="col-md-6 mb-2">
                <label class="required">Phone</label>
                <input type="text" name="phone" class="form-control"/>
            </div>
            <div class="col-md-3 mb-2">
                <label class="required">Country</label>
                <select name="country" class="form-control">
                    <option value="">---</option>
                    @foreach(\App\Country::whereIn('code', ['US', 'CA'])->orderBy('code', 'desc')->get() as $country)
                    <option value="{{$country->name}}" data-country-code="{{$country->code}}">{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label class="required">State</label>
                <select name="state" class="form-control">
                    <option value="">---</option>
                    @foreach(\App\CountryState::whereIn('country_code', ['US', 'CA'])->orderBy('name', 'asc')->get() as $state)
                    <option value="{{$state->id}}" class='d-none' data-country-code="{{$state->country_code}}">{{$state->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label class="required">City</label>
                <input type="text" name="city" class="form-control"/>
            </div>
            <div class="col-md-3 mb-2">
                <label class="required">Zip/postal code</label>
                <input type="text" name="zip" class="form-control"/>
            </div>
            <div class="col-md-12 mb-2">
                <label class="required">Address</label>
                <input type="text" name="address" class="form-control"/>
            </div>
            <div class="col-md-6 mt-3 mb-2 text-center text-md-right recaptcha-block">
                <div id="recaptcha_buy" class="g-recaptcha d-inline-block" data-sitekey="6LcgS1gUAAAAAIn8Ix2w2Bg2OeAZJ-F-_9c_XmBe"></div>
            </div>
            <div class="col-md-6 mt-3 mb-2 text-center text-md-left">
                <input type = "submit" value = "Buy Now" class="btn btn-primary btn-lg"/> 
            </div>
        </div>
    </form>
    <form name="pay_form" method = "post" action = "https://Simplecheckout.authorize.net/payment/CatalogPayment.aspx" class="d-none"> 
        <input type = "hidden" name = "LinkId" value ="b48d2881-13b4-489e-b258-3cb4c2e0c69d" />         
    </form>
</div>
@endsection