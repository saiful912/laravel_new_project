@extends('layouts.frontLayout.front_design')
@section('content')
    <section id="form" style="margin: 0;"><!--form-->
        <div class="container">
            @if(Session::has('flash_message_error'))
                <div class="alert alert-error alert-danger">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif
            @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif
            <form action="{{url('checkout')}}" method="post">
                {{csrf_field()}}
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Bill To</h2>
                        <div class="form-group">
                            <input name="billing_name" id="billing_name" value="{{$userDetails->name}}" type="text" placeholder="Billing Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <input name="billing_address" id="billing_address" value="{{$userDetails->address}}" type="text" placeholder="Billing Address" class="form-control">
                        </div>
                        <div class="form-group">
                            <input name="billing_city" id="billing_city" type="text" value="{{$userDetails->city}}"  placeholder="Billing City" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="billing_state" id="billing_state" value="{{$userDetails->state}}" placeholder="Billing State" class="form-control">
                        </div>
                        <div class="form-group">

                            <select name="billing_country" id="billing_country" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->country_name}}" @if($country->country_name==$userDetails->country) selected @endif>
                                        {{$country->country_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="billing_pincode" id="billing_pincode" value="{{$userDetails->pincode}}" placeholder="Billing Pincode" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="billing_mobile" id="billing_mobile" value="{{$userDetails->mobile}}" placeholder="Billing Mobile" class="form-control">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="billtoship" id="billtoship">
                            <label class="form-check-label" for="billtoship">Shipping address same as Billing address</label>
                        </div>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>Ship TO</h2>
                        <div class="form-group">
                            <input name="shipping_name" @if(!empty($shippingDetails->name)) value="{{$shippingDetails->name}}" @endif id="shipping_name" type="text" placeholder="Shipping Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <input name="shipping_address" id="shipping_address" @if(!empty($shippingDetails->address)) value="{{$shippingDetails->address}}" @endif  type="text" placeholder="Shipping Address" class="form-control">
                        </div>
                        <div class="form-group">
                            <input name="shipping_city" @if(!empty($shippingDetails->city)) value="{{$shippingDetails->city}}" @endif  id="shipping_city" type="text" placeholder="Shipping City" class="form-control">
                        </div>
                        <div class="form-group">
                            <input name="shipping_state" @if(!empty($shippingDetails->state)) value="{{$shippingDetails->state}}" @endif  id="shipping_state" type="text" placeholder="Shipping State" class="form-control">
                        </div>
                        <div class="form-group">
                            <select name="shipping_country" id="shipping_country" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->country_name}}" @if(!empty($shippingDetails->country) && $country->country_name==$shippingDetails->country) selected @endif>
                                        {{$country->country_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input name="shipping_pincode" @if(!empty($shippingDetails->pincode)) value="{{$shippingDetails->pincode}}" @endif  id="shipping_pincode" type="text" placeholder="Shipping Pincode" class="form-control">
                        </div>
                        <div class="form-group">
                            <input name="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{$shippingDetails->mobile}}" @endif  id="shipping_mobile" type="text" placeholder="Shipping Mobile" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit"  class="btn btn-success">Checkout</button>
                        </div>
                    </div><!--/sign up form-->
                </div>
            </div>
            </form>
        </div>
    </section><!--/form-->
@endsection
