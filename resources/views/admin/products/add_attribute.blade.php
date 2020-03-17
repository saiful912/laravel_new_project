@extends('layouts.adminLayout.admin_design')
@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Attribute</a></div>
            <h1>Add Product Attributes</h1>
        </div>
        <div class="container-fluid"><hr>
            <div class="row-fluid">
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
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Add Attribute</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{url('/admin/add_attribute/'.$productDetails->id)}}" name="add_attribute" id="add_attribute" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input type="hidden" name="product_id" value="{{$productDetails->id}}">
                                <div class="control-group">
                                    <label class="control-label">Product Name</label>
                                    <label class="control-label"><strong>{{$productDetails->product_name}}</strong></label>

                                </div>
                                <div class="control-group">
                                    <label class="control-label">Product Code</label>
                                    <label class="control-label"><strong>{{$productDetails->product_code}}</strong></label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Product Color</label>
                                    <label class="control-label"><strong>{{$productDetails->product_color}}</strong></label>
                                </div>

                                <div class="field_wrapper">
                                    <div>
                                        <input type="text" name="sku[]" id="sku" placeholder="SKU" required/>
                                        <input type="text" name="size[]" id="size" placeholder="Size" required/>
                                        <input type="text" name="price[]" id="price" placeholder="Price" required/>
                                        <input type="text" name="stock[]" id="stock" placeholder="Stock" required/>
                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <input type="submit" value="Add Attribute" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Product Attribute</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Attribute ID</th>
                                    <th>SKU</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($productDetails->attributes as $attribute)
                                    <tr class="gradeX">
                                        <td>{{$attribute->id}}</td>
                                        <td>{{$attribute->sku}}</td>
                                        <td>{{$attribute->size}}</td>
                                        <td>{{$attribute->price}}</td>
                                        <td>{{$attribute->stock}}</td>
                                        <td class="center">
                                            <a href="" class="btn btn-primary btn-mini">Edit</a>
                                            <a id="" href="#deleteAttribute{{$attribute->id}}" data-toggle="modal"  class="btn btn-danger btn-mini">Delete</a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteAttribute{{$attribute->id}}" tabindex="-1"
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
                                                            <form action="{{url('/admin/delete_attribute/'.$attribute->id)}}"
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

