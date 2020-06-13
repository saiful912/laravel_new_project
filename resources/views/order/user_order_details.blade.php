@extends('layouts.frontLayout.front_design')
@section('content')
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li><a href="{{url('/orders')}}">Orders</a></li>
                <li class="active">{{$order_details->id}}</li>
            </ol>
        </div>
    </div>
    <section id="do_action">
        <div class="container">
            <div class="heading" align="center">
                <table id="example" class="table table-striped table-bordered table-hover" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Product Size</th>
                        <th>Product Color</th>
                        <th>Product Price</th>
                        <th>Product Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order_details->orders as $pro)
                        <tr>
                            <td>{{$pro->product_code}}</td>
                            <td>{{$pro->product_name}}</td>
                            <td>{{$pro->product_size}}</td>
                            <td>{{$pro->product_color}}</td>
                            <td>{{$pro->product_price}}</td>
                            <td>{{$pro->product_qty}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
