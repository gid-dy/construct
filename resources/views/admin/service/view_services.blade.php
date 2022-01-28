@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Services</a> <a href="#" class="current">View Services</a> </div>
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
  <div style="margin-left:20px;">
    <a href="{{ url('/admin/export-services') }}" class="btn btn-primary btn-mini">Export</a>
</div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Services</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                    <th>Package Id</th>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Package Name</th>
                    <th>Package Price</th>
                    <th>Image</th>
                    <th>Featured Service</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $services)
                        <tr class="gradeX">
                            <td>{{ $services->id }}</td>
                            <td>{{ $services->Category_id }}</td>
                            <td>{{ $services->CategoryName }}</td>
                            <td>{{ $services->ServiceName }}</td>
                            <td>GHS {{ $services->ServicePrice }}</td>
                            <td>
                                @if(!empty($services->image))
                                    <img src="{{ asset ('/images/backend_images/services/large/'.$services->image) }}" style= "width:70px;">
                                @endif
                            </td>
                            <td>@if($services->featured_service ==1) Yes @else No @endif</td>
                            <td class="center">
                              <a href="#myModal{{ $services->id }}" data-toggle="modal" class="btn btn-success btn-mini">view</a>
                              <a href="{{ url('/admin/edit-service/'.$services->id) }}" class="btn btn-primary btn-mini">Edit</a>
                              <a href="{{ url('/admin/add-Servicetype/'.$services->id) }}" class="btn btn-dark btn-mini">Add</a>
                              <a href="{{ url('/admin/add-image/'.$services->id) }}" class="btn btn-info btn-mini">Image</a>
                              <a rel="{{ $services->id }}" rel1="delete-service"  href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                            </td>
                        </tr>

                        <div id="myModal{{ $services->id }}" class="modal hide">
                            <div class="modal-header">
                              <button data-dismiss="modal" class="close" type="button">×</button>
                              <h3>{{ $services->ServiceName }} Full Details</h3>
                            </div>
                            <div class="modal-body">
                              <p>Service ID:{{ $services->id }} </p>
                              <p>Category ID:{{ $services->Category_id }} </p>
                              <p>Package Name:{{ $services->ServiceName }} </p>
                              <p>Description:{{ $services->Description }} </p>
                              <p>Package Price:{{ $services->ServicePrice }} </p>
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
@endsection
