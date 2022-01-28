@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Categories</a> <a href="#" class="current">Edit Category</a> </div>
        <h1>Categories</h1>
        @if (Session::has('flash_message_error'))
            <div class="alert alert-error alert-block">
                <button type="button" class="close" data-dismiss='alert'></button>
                <strong>{!! session('flash_message_error') !!}</strong>
            </div>
        @endif
        @if (Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss='alert'></button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="list-style-type:none;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit Category</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ url('/admin/edit-category/'.$categoryDetails->id) }}" name="edit_category" id="edit_category" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Category Name</label>
                                <div class="controls">
                                <input type="text" name="CategoryName" id="CategoryName" value="{{ $categoryDetails->CategoryName }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                <textarea name="CategoryDescription" id="CategoryDescription">{{ $categoryDetails->CategoryDescription }}</textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Meta Title</label>
                                <div class="controls">
                                    <input type="text" name="meta_title" id="meta_title" value="{{ $categoryDetails->meta_title }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Meta Description</label>
                                <div class="controls">
                                    <input type="text" name="meta_description" id="meta_description" value="{{ $categoryDetails->meta_description }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Meta Keywords</label>
                                <div class="controls">
                                    <input type="text" name="meta_keywords" id="meta_keywords"value="{{ $categoryDetails->meta_keywords }}">
                                </div>
                            </div>
                        <div class="control-group">
                                <label class="control-label">Image</label>
                                <div class="controls">
                                    <input type="hidden" name="current_image" value="{{ $categoryDetails->image }}">
                                    <input type="file" name="image" id="image">
                                    @if(!empty($categoryDetails->image))
                                        <img style= "width: 70px;"  src="{{ asset('images/backend_images/categories/large/'.$categoryDetails->image) }}"> | <a href="{{ url('/admin/delete-category-image/'.$categoryDetails->id) }}">Delete</a>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                            <label class="control-label">Enable</label>
                            <div class="controls">
                            <input type="checkbox" name="CategoryStatus" id="CategoryStatus" @if($categoryDetails->CategoryStatus=="1") checked @endif value="1">
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" value="Edit Category" class="btn btn-success">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
