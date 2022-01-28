@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Services</a> <a href="#" class="current">Add Service</a> </div>
    <h1>Services</h1>
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
            <h5>Add Services</h5>
          </div>

          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.add-service') }}" name="add_service" id="add_service" novalidate="novalidate">
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
                        <input type="text" name="ServiceName" id="ServiceName">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                        <input type="text" name="Description" id="Description">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Package Price</label>
                    <div class="controls">
                        <input type="text" name="ServicePrice" id="ServicePrice">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Image</label>
                    <div class="controls">
                        <input type="file" name="image" id="image">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Feature Service</label>
                    <div class="controls">
                        <input type="checkbox" name="featured_service" id="featured_service" value="1">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Enable</label>
                    <div class="controls">
                        <input type="checkbox" name="Status" id="Status" value="1">
                    </div>
                </div>


              <div class="form-actions">
                <input type="submit" value="Add Service" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
