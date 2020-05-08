@extends('layouts.adminLayout.admin_design')
@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">view</a> </div>
            <h1>Coupons</h1>
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
                            <h5>All Banners</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Banner Image</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($banners as $banner)
                                    <tr class="gradeX">
                                        <td>{{$banner->id}}</td>
                                        <td>
                                            <img src="{{asset('images/frontend_image/banner/'.$banner->image)}}" alt="bannerImage" width="250px">
                                        </td>
                                        <td>{{$banner->title}}</td>
                                        <td>{{$banner->link}}</td>
                                        <td>@if($banner->status==1)Active @else Inactive @endif</td>
                                        <td class="center">
                                            <a href="{{url('/admin/edit-banner/'.$banner->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                            <a id="delCat" href="{{url('/admin/delete_banner/'.$banner->id)}}" class="btn btn-danger btn-mini">Delete</a>
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


