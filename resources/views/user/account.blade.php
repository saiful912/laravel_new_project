@extends('layouts.frontLayout.front_design')
@section('content')
    <section id="form" style="margin-top: 0px" xmlns="http://www.w3.org/1999/html"><!--form-->
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
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Update to your account</h2>
                        <form id="accountForm" name="accountForm" action="{{url('/account')}}" method="post">
                            @csrf
                            <input name="name" id="name" type="text" placeholder="Name" value="{{$userDetails->name}}" required/>
                            <input name="address" id="address" type="text" placeholder="Address" value="{{$userDetails->address }}" required/>
                            <input value="{{$userDetails->city}}" name="city" id="city" type="text" placeholder="City" required/>
                            <input value="{{$userDetails->state}}" name="state" id="state" type="text" placeholder="State" required/>
                            <select name="country" id="country" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->country_name}}" @if($country->country_name==$userDetails->country) selected @endif>
                                        {{$country->country_name}}
                                    </option>
                                @endforeach
                            </select>
                            <input value="{{$userDetails->pincode}}" style="margin-top: 10px" name="pincode" id="pincode" type="text" placeholder="Pincode" required/>
                            <input value="{{$userDetails->mobile}}" name="mobile" id="mobile" type="text" placeholder="Mobile" required/>
                            <input name="email" id="email" type="email" placeholder="Email Address" value="{{$userDetails->email}}" required/>
                            <button type="submit" class="btn btn-success" >SignUp</button>
                        </form>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>Update Password</h2>
                        {{--<for  action="{{url('/login-register')}}" method="post">--}}
                        <form id="registerForm" action="#" method="post">
                            @csrf
                            <input name="name" id="name" type="text" placeholder="Name"/>
                            <input name="email" id="email" type="email" placeholder="Email Address"/>
                            <input name="password" id="myPassword" type="password" placeholder="Password"/>
                            <button type="submit" class="btn btn-success" >SignUp</button>
                        </form>


                        {{--</for>--}}
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
@stop

