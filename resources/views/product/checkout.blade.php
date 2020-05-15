@extends('layouts.frontLayout.front_design')
@section('content')
    <section id="form" style="margin: 0;"><!--form-->
        <div class="container">
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
                            <input type="text" placeholder="Shipping Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Shipping Address" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Shipping City" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Shipping State" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Shipping Country" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Shipping Pincode" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Shipping Mobile" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit"  class="btn btn-success">Checkout</button>
                        </div>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
@endsection
