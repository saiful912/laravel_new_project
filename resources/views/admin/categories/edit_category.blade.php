@extends('layouts.adminLayout.admin_design')
@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Category</a></div>
            <h1>Edit Category</h1>
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
                            <h5>Edit Category</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{url('/admin/update_category/'.$category->id)}}" name="add_category" id="add_category" novalidate="novalidate">
                                {{csrf_field()}}
                                <div class="control-group">
                                    <label class="control-label">Category Name</label>
                                    <div class="controls">
                                        <input type="text" name="name" id="name" value="{{$category->name}}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Category Level</label>
                                    <div class="controls">
                                        <select name="parent_id" id="parent_id" style="width: 220px;">
                                            <option value="0">Main Category</option>
                                            @foreach($levels as $level)
                                                <option value="{{$level->id}}" @if($level->id==$category->parent_id) selected @endif>{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                <div class="control-group">
                                    <label class="control-label">Category Description</label>
                                    <div class="controls">
                                        <textarea name="description" id="description">{{$category->description}}</textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">URL (Start with http://)</label>
                                    <div class="controls">
                                        <input type="text" name="url" id="url" value="{{$category->url}}">
                                    </div>
                                </div>

                                    <div class="control-group">
                                        <label class="control-label">Enable</label>
                                        <div class="controls">
                                            <input type="checkbox" name="status" id="status" @if($category->status=="1") checked @endif value="1">
                                        </div>
                                    </div>
                                <div class="form-actions">
                                    <input type="submit" value="Update Category" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

