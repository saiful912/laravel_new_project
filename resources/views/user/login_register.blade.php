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
                        <h2>Login to your account</h2>
                        <form id="loginForm" action="{{url("/user-login")}}" method="post">
                            @csrf
                            <input type="email" name="email" placeholder="Email Address" />
                            <input type="password" name="password" placeholder="Password" />
                            {{--<span>--}}
								{{--<input type="checkbox" class="checkbox">--}}
								{{--Keep me signed in--}}
							{{--</span>--}}
                            <button type="submit" class="btn btn-default">Login</button>
                        </form>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>New User Signup!</h2>
                        {{--<for id="registerForm" action="{{url('/login-register')}}" method="post">--}}
                        <form id="registerForm"  name="registerForm"  action="{{url("/user-register")}}" method="post">
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
