@extends('layouts.adminLayout.admin_design')
@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">view</a> </div>
            <h1>Categories</h1>
        </div>
        <div class="container-fluid">
            @if(Session::has('flash_message_error'))
                <div class="alert alert-error alert-block">
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
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>All Categories</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Product Color</th>
                                    <th>Product Price</th>
                                    <th>Product Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr class="gradeX">
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->category_id}}</td>
                                        <td>{{$product->category_name}}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->product_code}}</td>
                                        <td>{{$product->product_color}}</td>
                                        <td>{{$product->price}}</td>
                                        <td>
                                            @if(!empty($product->image))
                                                <img src="{{asset('/images/backend_image/product/large/'.$product->image)}}" alt="" style="width: 60px;">
                                                @endif
                                        </td>
                                        <td class="center">
                                            <a href="#view_product{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini">View</a>
                                            <a href="{{url('/admin/add_attribute/'.$product->id)}}"  class="btn btn-info btn-mini">Add</a>
                                            <a href="{{url('/admin/edit_product/'.$product->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                            <a id="" href="#deleteModal{{$product->id}}" data-toggle="modal" class="btn btn-danger btn-mini">Delete</a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteModal{{$product->id}}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Are you sure to
                                                                delete!</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{url('/admin/delete_product/'.$product->id)}}"
                                                                  method="post">
                                                                {{csrf_field()}}
                                                                <button type="submit" class="btn btn-danger">Permanent Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <div id="view_product{{$product->id}}" class="modal hide">
                                        <div class="modal-header">
                                            <button data-dismiss="modal" class="close" type="button">x</button>
                                            <h3>{{$product->product_name}} view details</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>Category Name: {{$product->category_name}}</p>
                                            <p>Product Code: {{$product->product_code}}</p>
                                            <p>Product Color: {{$product->product_code}}</p>
                                            <p>Product Price: {{$product->price}}</p>
                                            <p>Product Description: {{$product->description}}</p>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

