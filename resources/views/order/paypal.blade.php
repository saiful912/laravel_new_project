@extends('layouts.frontLayout.front_design')
@section('content')
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">Thanks</li>
            </ol>
        </div>
    </div>
    <section id="do_action">
    <div class="container">
        <div class="heading" align="center">
            <h3>Your Code Order has been placed</h3>
            <p>Your Order Number Is {{Session::get('order_id')}} And total payable about is BDT {{Session::get('grand_total')}}</p>
        </div>
    </div>
    </section>
@endsection

<?php
    Session::forget('grand_total');
    Session::forget('order_id');
    ?>

