@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Service </a> <a href="#" class="current">Edit Service </a> </div>
    <h1>Service </h1>
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
            <h5>Edit Service </h5>
          </div>

          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/edit-service/'.$servicesDetails->id) }}" name="edit_service" id="edit_service" novalidate="novalidate">
                @csrf
                <div class="control-group">
                    <label class="control-label">Under Category</label>
                    <div class="controls">
                        <select name="Category_id" id="Category_id" style="width: 220px;">
                            <?php echo $category_dropdown; ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Package Name</label>
                    <div class="controls">
                        <input type="text" name="ServiceName" id="ServiceName" value="{{ $servicesDetails->ServiceName}}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                        <textarea name="Description" id="Description">{{ $servicesDetails->Description}}</textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Package Price</label>
                    <div class="controls">
                        <input type="text" name="ServicePrice" id="ServicePrice" value="{{ $servicesDetails->ServicePrice}}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Image</label>
                    <div class="controls">
                        <input type="hidden" name="current_image" value="{{ $servicesDetails->image}}">
                        <input type="file" name="image" id="image">
                        @if(!empty($servicesDetails->image))
                            <img style= "width: 70px;"  src="{{ asset('/images/backend_images/services/large/'.$servicesDetails->image) }}"> | <a href="{{ url('/admin/delete-service-image/'.$servicesDetails->id) }}">Delete</a>
                        @endif
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Feature Item</label>
                    <div class="controls">
                        <input type="checkbox" name="featured_service" id="featured_service" @if($servicesDetails->featured_service=="1") checked @endif value="1">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Enable</label>
                    <div class="controls">
                        <input type="checkbox" name="Status" id="Status" @if($servicesDetails->Status=="1") checked @endif value="1">
                    </div>
                </div>


              <div class="form-actions">
                <input type="submit" value="Edit Service " class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
