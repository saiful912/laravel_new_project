@extends('layouts.adminLayout.admin_design')
@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Coupon</a></div>
            <h1>Edit Banner</h1>
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
                            <h5>Edit Banner</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{url('/admin/edit-banner/'.$bannerDetails->id)}}" name="edit_banner" id="edit_banner" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="control-group">
                                    <label class="control-label" for="image">Banner Image</label>
                                    <div class="controls">
                                        <input type="file" name="image" id="image">
                                        @if(!empty($bannerDetails->image))
                                            <input type="hidden" name="current_image" value="{{$bannerDetails->image}}">
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Banner Title</label>
                                    <div class="controls">
                                        <input value="{{$bannerDetails->title}}" type="text" name="title" id="title" min="1" required />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Banner Link</label>
                                    <div class="controls">
                                        <input type="text" value="{{$bannerDetails->link}}" name="link" id="link" requiredban/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Enable</label>
                                    <div class="controls">
                                        <input @if($bannerDetails->status=="1") checked @endif type="checkbox" name="status" id="status" value="1" >
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <input type="submit" value="Add Banner" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


